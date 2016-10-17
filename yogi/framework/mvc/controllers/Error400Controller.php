<?php
namespace yogi\framework\mvc\controllers;

use yogi\framework\mvc\Controller;

class Error400Controller extends Controller {
	public function index($code) {
		return $code;
		return $this->view();
	}
}