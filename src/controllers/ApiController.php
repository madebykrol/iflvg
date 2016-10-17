<?php

namespace src\controllers;

use yogi\framework\mvc\ServiceController;
use yogi\framework\mvc\JsonResult;
use yogi\framework\io\db\interfaces\IServiceDataStore;
use yogi\framework\io\interfaces\IRequest;

class ApiController extends ServiceController {
	
	/**
	 *
	 * @var IServiceDataStore
	 */
	private $dataStore;
	
	/**
	 *
	 * @var IRequest
	 */
	private $request;
	public function __construct(/*IServiceDataStore $dataStore*/ IRequest $request) {
		// $this->dataStore = $dataStore;
		$this->request = $request;
	}
	public function endpoint($id = null) {
		return new JsonResult ( $this->request );
	}
	
	
	public function index() {
		$object = ( object ) array (
				'Version' => 'Api-v.1',
				'Endpoints' => array (
						'Index' => ( object ) array (
								'Description' => 'Front page.',
								'Rest' => array (
										'GET' => '' 
								) 
						),
						'Games' => ( object ) array (
								'Description' => '',
								'Rest' => array (
										'GET' => '',
										'POST' => '',
										'PATCH' => '',
										'DELETE' => '' 
								) 
						) 
				) 
		);
		
		return new JsonResult ( $object );
	}
}  