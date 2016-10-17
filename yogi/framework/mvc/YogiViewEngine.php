<?php
namespace yogi\framework\mvc;
use yogi\framework\mvc\interfaces\IViewEngine;
use yogi\framework\mvc\interfaces\IActionResult;
use yogi\framework\utils\ArrayList;
use yogi\framework\utils\HashMap;
use yogi\framework\helpers\Html;
use yogi\framework\utils\Regexp;

class YogiViewEngine implements IViewEngine {
	
	private $partialViews = null;
	private $regions = array();
	
	/**
	 * 
	 * @param string $paths
	 */
	public function __construct($paths = null) {
		
		if(!isset($paths)) {
			$this->partialViews = new ArrayList();
		} else if(is_array($paths)) {
			$this->partialViews = new ArrayList($paths);
		} else if($paths instanceof ArrayList){
			$this->partialViews = $paths;
		}
		$this->initPartialViews();
	}
	
	public function initPartialViews() {
		$this->partialViews->add('src/views/{0}/_default.phtml');
		$this->partialViews->add('src/views/{0}/{1}.phtml');
		$this->partialViews->add('src/Share/{1}.phtml');
	}
	
	public function addPartialViewLocation($locationString) {
		$this->partialViews->add($locationString);
	}
	
	public function getPartialViewLocations() {
		return $this->partialViews;
	}
	
	public function renderResult(IActionResult $result, $controller, $action) {
		$viewFileExists = false;
		$triedViewFiles = new ArrayList();
		
		$output = "";
		
		if($result->getHeaders() != null) {
			foreach($result->getHeaders()->getIterator() as $field => $value) {
				header($field.": ".$value);
			}
		}
		if ($result->useView()) {
			if ($result->getViewFile() != null) {
				if(is_file($result->getViewFile())) {
					$viewFileExists = true;
			
				} else {
					$triedViewFiles->add($result->getViewFile());
				}
			} else {
				// Loop through view file conventions
				foreach($this->partialViews->getIterator() as $file) {
					$file = str_replace(array("{0}", "{1}"), array($controller, $action), $file);
					if(is_file($file)) {
						$viewFileExists = true;
						$result->setViewFile($file);
						break;
					} else {
						$triedViewFiles->add($file);
					}
				}
			}
			
			if($viewFileExists) {
				$output = $this->render($result);
			} else {
				foreach($triedViewFiles->getIterator() as $file) {
					$output .= $file."\n";
				}
			}
		} else {
			if(($content = $result->getContent()) != null) {
				$output = $content;
			} else {
				$output = $this->render($result);
			}
		}
		
		return $output;
	}
	
	public function renderSection($section) {
		if(isset($this->regions[$section])) {
			return $this->regions[$section];
		}
	}
	
	public function renderContent() {
	
	}
	
	private function render(IActionResult $result) {		
		$output = "";
	
		$model 		= $result->getModel();
		$layout 	= null;
		$viewBag 	= $result->getViewBag();
	
		ob_start();
		include($result->getViewFile());
		$content = ob_get_clean();
	
		$rexp = new Regexp('@Region (.+?)\n(.+?)@Endregion');
		$rexp->setOption("is");
	
		$r = $rexp->find($content);
		$regions = array();
		if (count($r) > 0 ) {
			foreach($r as $index => $region) {
				$name = "";
				$complete = "";
				$rContent = "";
				 
				if(is_array($r)) {
					if(isset($r[0])) {
						if(isset($r[0][$index])) {
							$complete = $r[0][$index];
						}
					}
					if(isset($r[1])) {
						if(isset($r[1][$index])) {
							$name = $r[1][$index];
						}
					}
					if(isset($r[2])) {
						if(isset($r[2][$index])) {
							$rContent = $r[2][$index];
						}
					}
				}
	
				$content = str_replace($complete, "", $content);
	
				$this->regions[trim($name)] .= trim($rContent);
			}
				
		}
	
			
		if($layout == null) {
			$output = $content;
		} else {
			ob_start();
			include($layout);
			$output = ob_get_clean();
		}
	
		return $output;
	
	}
}