<?php
namespace src\business\factories\mockups;

use src\business\factories\interfaces\IStartPageViewModelFactory;
use src\models\viewmodels\StartPageViewModel;
use src\business\factories\interfaces\ILayoutViewModelFactory;
use src\business\SiteContext;
use src\business\models\BillboardItem;

class MockStartPageViewModelFactory implements IStartPageViewModelFactory {
	
	private $_layoutViewModelFactory;
	
	public function __construct(ILayoutViewModelFactory $layoutViewModelFactory) {
		$this->_layoutViewModelFactory = $layoutViewModelFactory;
	}
	
	
	public function createViewModel(SiteContext $context) {
		
		$model = new StartPageViewModel();
		$model->title = $context->domain;
		$model->billboard = array();
		$model->billboard[] = new BillboardItem();
		$model->billboard[] = new BillboardItem();
		$model->billboard[] = new BillboardItem();
		return $model;
		
	}
}
