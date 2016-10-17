<?php
namespace src\controllers;
use yogi\framework\mvc\Controller;
use yogi\framework\mvc\JsonResult;
use yogi\framework\io\db\interfaces\IDal;
use yogi\framework\settings\interfaces\ISettingsRepository;
use yogi\framework\io\db\PDODal;

class BlogApiController extends Controller {
	
	/**
	 * @var IDal
	 */
	private $_dal;
	
	public function __construct(ISettingsRepository $settings) {
		$connectionStrings = $settings->get('connectionStrings');
		$this->_dal = new PDODal($connectionStrings['Default']['connectionString']);
	}
	
	public function index($id) {
		
		var_dump($this->_dal->sanitize($id));
		
		return new JsonResult((object)array("Blogg" => "ggolB", "id" => $id));
	}
	
	public function post_index($id) {
		return new JsonResult((object)array("Blogg" => "ggolB", "id" => $id));
	}
	
	public function derp($id) {
		return new JsonResult((object)array("Blogg" => "ggolB - derp", "id" => $id));
	}
	
}