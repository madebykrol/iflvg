<?php
namespace src\controllers;

use yogi\framework\mvc\Controller;
use src\business\repositories\interfaces\IUserRepository;
use yogi\framework\io\interfaces\IRequest;
use yogi\framework\mvc\JsonResult;
use src\business\factories\interfaces\IStartPageViewModelFactory;
use src\business\SiteContext;

class StartController extends Controller {
	
	/**
	 * @var IUserRepository
	 */
	private $_userRepository;
	
	/**
	 * @var IRequest
	 */
	private $_currentRequest;
	
	/**
	 * @var IStartPageViewModelFactory
	 */
	private $_viewModelFactory;
	
	public function __construct(
			IUserRepository $repo, 
			IRequest $currentRequest, 
			IStartPageViewModelFactory $viewModelFactory) {
		$this->_userRepository = $repo;
		$this->_currentRequest = $currentRequest;
		$this->_viewModelFactory = $viewModelFactory;
	}
	
	/**
	 * @return ViewResult
	 */
	public function index() {
		$siteContext = $this->_userRepository->getUserDomain($this->_currentRequest->getSubdomain());
		
		if ($siteContext != null && $siteContext->domainIsActive) {
    		return $this->view($this->_viewModelFactory->createViewModel($siteContext));
		} else {
			return $this->redirectToAction('index', 'Home');
		}
	}
	
	public function derp() {
		return new JsonResult($this->_userRepository->getUserDomain($this->_currentRequest->getSubdomain()));
	}
}