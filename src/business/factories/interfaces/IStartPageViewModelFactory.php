<?php
namespace src\business\factories\interfaces;

use src\business\SiteContext;

interface IStartPageViewModelFactory {
	public function createViewModel(SiteContext $context);
}