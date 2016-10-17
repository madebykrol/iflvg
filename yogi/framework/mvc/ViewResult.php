<?php
namespace yogi\framework\mvc;

use yogi\framework\mvc\interfaces\IActionResult;
use yogi\framework\utils\HashMap;
use yogi\framework\helpers\Html;
use yogi\framework\utils\Regexp;

class ViewResult implements IActionResult {
	
	private $viewFile;
	private $model;
	private $viewBag;
	private $headers;
	/**
	 * @var IViewEngine
	 */
	private $viewEngine;
	
	private $useView = true;
	private $regions = array();
	
	public function __construct($model = null) {
		$this->model = $model;
		$this->headers = new HashMap();
	}
	
	public function setHeader($field, $value) {
		$this->headers->add($field, $value);
	}
	
	public function setHeaders(HashMap $headers) {
		$this->headers = $headers;
	}
	
	public function getHeaders() {
		return $this->headers;
	}
	
	public function setModel($model) {
		$this->model = $model;
	}
	public function getModel(){
		return $this->model;
	}
	
	public function setViewFile($file){
		$this->viewFile = $file;
	}
	
	public function getViewFile(){
		return $this->viewFile;
	}
	
	public function setViewBag($viewBag) {
		$this->viewBag = $viewBag;
	}
	
	public function getViewBag() {
		return $this->viewBag;
	}
	
	public function useView($boolean = null) {
		if(is_bool($boolean)) {
			$this->useView = $boolean;
		}
		return $this->useView;
	}
	
	public function getContent() {
		return null;
	}
	
}