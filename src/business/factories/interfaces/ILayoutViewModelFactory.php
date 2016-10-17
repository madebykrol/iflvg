<?php
namespace src\business\factories\interfaces;

use src\models\LayoutViewModel;

interface ILayoutViewModelFactory {
	public function populateLayoutViewModel(LayoutViewModel $model);
}