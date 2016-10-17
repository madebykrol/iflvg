<?php
namespace yogi\framework\route;
use yogi\framework\route\interfaces\IRouter;
use yogi\framework\route\interfaces\IRoute;
use yogi\framework\route\interfaces\IRouterConfig;
use yogi\framework\io\interfaces\IRequest;
use yogi\framework\mvc\Action;
use yogi\framework\utils\Regexp;
use yogi\framework\utils\HashMap;
class Router implements IRouter {
	
	private $controllerFactory = null;
	private $registry = null;
	private $config = null;
	
	public function __construct() {
		
	}
	
	public function setRouterConfig(IRouterConfig $config) {
		$this->config = $config;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see IRouter::getConfig()
	 */
	public function getRouterConfig() {
		return $this->config;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \smll\framework\route\interfaces\IRouter::lookup()
	 */
	public function lookup(IRequest $request) {
		$reqPath = $request->getPath();
		//$rPath[] = null;
 		$action = new Action();
		$parameters = array();
		$routes = new HashMap();
		/**
		 * @var IRoute
		 */
		$defaultRoute = $routes->get('Default');
		
		// Need to rewrite eliminitation
		// Get requested URL
		foreach($this->config->getRoutes()->getIterator() as $name => $routeMap) {
			
			// Match against routes.
			// An exact match will yield a direct hit from the routemap
			$routeMapUrl = $routeMap->getUrl();
			if($routeMapUrl == implode("/", $reqPath)) {
				$routes->add($name, $routeMap);
				break;
			}
			
			$pathSegments = explode("/", $routeMapUrl);
			// this route did not match exactly lets see if we can step through this route to figure out if it's a candidate.
			foreach($pathSegments as $index => $step) {
				
				// If this segment matches exact the route this route is still a candidate
				if($reqPath[$index] == $step) {
					$routes->add($name, $routeMap);
				} else {
					// If it did not match exactly, give it a second chance to match by tokens
					if(isset($pathSegments[$index])) {
						// If segment is a token
						if($this->isToken($pathSegments[$index])) {
							// We parse the token add it to the parameters and let this route still be a candidate
							$parameters[$name][str_replace(array('{', '}'), '', $pathSegments[$index])] = $reqPath[$index];
							$routes->add($name, $routeMap);
							continue;
						} else {
							// If this is NOT a token and it did NOT match exactly, we remove and leave this route to another day.
							$routes->remove($name);
							break;
						}
					}
					
					$routes->remove($name);
				}
			}
		}
				
		//$routes->remove('Default');
		
		// First cascade is finished.
		$controller = "";
		$actionString = "";
		$name = "";
		if($routes->getLength() > 0) {
			foreach($routes->getIterator() as $name => $route) {
				
				$defaults = $route->getDefaults();
				
				$controller = $defaults['controller'];
				unset($defaults['controller']);
				if(isset($parameters[$name]['controller'])  && $parameters[$name]['controller'] != "") {
					$controller = $parameters[$name]['controller'];
					unset($parameters[$name]['controller']);
				}
				$actionString = $defaults['action'];
				unset($defaults['action']);
				if(isset($parameters[$name]['action']) && $parameters[$name]['action'] != "") {
					$actionString = $parameters[$name]['action'];
					unset($parameters[$name]['action']);
				}
				
				foreach($defaults as $var => $val) {
					if($val == Route::URLPARAMETER_REQUIRED && !isset($parameters[$name][$var])) {
						throw new \Exception();
					} else {
						
					}
				}
			}
		}
		
		$action->setAction($actionString);
		$action->setController($controller);
		
		foreach($parameters[$name] as $param => $value) {
			$action->addParameter($param, $value);
		}
		
		foreach($request->getGetData() as $ident => $val) {
			if($ident != "q") {
				$action->addParameter($ident,$val);
			}
		}
			
		foreach($request->getPostData() as $ident => $val) {
			$action->addParameter($ident,$val);
		}
		
		return $action;
		
	}
	
	public function init() {
		
	}
	
	private function isToken($string) {
		$regex = new Regexp('{.+?}');
		
		return $regex->match($string);
	}
}