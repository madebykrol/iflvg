<?php
namespace src\controllers;

use yogi\framework\mvc\Controller;

class HomeController extends Controller {
	public function index () {
		
		return $this->view();
	}
}