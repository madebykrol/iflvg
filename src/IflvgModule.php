<?php
namespace src;

use yogi\framework\di\interfaces\IContainerModule;
use yogi\framework\utils\HashMap;
use yogi\framework\di\Definition;
use yogi\framework\route\RouterConfig;
use yogi\framework\di\Service;

class IflvgModule implements IContainerModule {
	private $reg;
	
	public function __construct() {
		$this->reg = new HashMap();
		$this->init();
	}
	
	public function init() {
	
		$this->register('src\business\repositories\mockups\MockUserRepository',
			'src\business\repositories\interfaces\IUserRepository');
		
		$this->register('yogi\framework\io\db\DataStoreManager',
				'yogi\framework\io\db\interfaces\IDataStoreManager');
		
		$this->register('yogi\framework\io\db\DBFieldFactory',
				'yogi\framework\io\db\interfaces\IDBFieldFactory');
		
		$this->register('src\business\factories\mockups\MockStartPageViewModelFactory', 
				'src\business\factories\interfaces\IStartPageViewModelFactory');
		
		$this->register('src\business\factories\LayoutViewModelFactory', 
				'src\business\factories\interfaces\ILayoutViewModelFactory');
	}
	
	public function getRegister() {
		return $this->reg;
	}
	
	private function register($class, $for) {
		return $this->registerWithIdent($for, $class, $for);
	}
	
	private function registerWithIdent($ident, $class, $for) {
		$definition = new Definition($class);
		$this->reg->add($ident, $definition);
	
		return $definition;
	}
}