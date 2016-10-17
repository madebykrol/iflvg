<?php
namespace yogi\framework\mvc\interfaces;
interface IActionResult {
	/**
	 * @return HashMap
	 */
	public function getHeaders();
	
	public function getModel();
	public function setModel($model);
	
	public function getViewFile();
	public function setViewFIle($file);
	
	public function getViewBag();
	public function setViewBag($viewBag);
	
	public function useView($boolean = null);
	
	/**
	 * This is used for self rendered action results.. For instance json results or 
	 * results that deliver files, xml or anything else.
	 */
	public function getContent();
}