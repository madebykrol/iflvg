<?php
namespace src\controllers;
use yogi\framework\mvc\Controller;
use src\models\AccountModel;
use src\models\AccountViewModel;
use src\models\LayoutViewModel;
use src\models\RegisterModel;
/**
 * [Authorize]
 */
class AccountController extends Controller {
	
	/**
	 * [Authorize]
	 * @return ViewResult
	 */
	public function index() {
	    
	    $model = new LayoutViewModel();
	    
		$model->title = 'Account';
		
		return $this->view($model);
	}
	
	/**
	 * [Auhtorize]
	 * @return ViewResult
	 */
	public function edit() {
		$model = new RegisterModel();
		$user = $this->membership->getUser($this->user->getIdentity()->getName());
		$model->username = $user->getProviderName();
		return $this->view($model);
	}
	
	public function post_edit() {
		
	}
	
	/**
	 * [AllowAnonymous]
	 * @return ViewResult
	 */
	public function login() {
		$model = new AccountViewModel();
	    
		$model->title = 'Login';
		$model->accountModel = new AccountModel();
		
		return $this->view($model);
	}
	
	/**
	 * [AllowAnonymous]
	 * @return ViewResult|string
	 */
	public function block_login() {
		
		if(!$this->user->getIdentity()->isAuthenticated()) {
			$this->viewBag['title'] = 'Login';
			$model = new AccountModel();
			
			return $this->view($model);
		} 
		
		return "";
	}
	
	/**
	 * [AllowAnonymous]
	 * @return ViewResult
	 */
	public function post_login(AccountModel $model, $returnUrl = 'index') {
		$this->viewBag['title'] = 'Login';
		if($this->modelState->isValid()) {
			if($this->membership->validateUser($model->username, $model->password)) {
				$this->authentication->signin($model->username);
				return $this->redirectToAction($returnUrl);
			} else {
				$this->modelState->setErrorMessageFor('username', 'Username or Password was incorrect');
			}
		} 
		$viewModel = new AccountViewModel();
		$viewModel->accountModel = $model;
		return $this->view($viewModel);
	}
	
	/**
	 * [Authorize]
	 * @return ViewResult
	 */
	public function logout() {
		$this->authentication->signout();
		return $this->redirectToAction('login');
	}
	
	/**
	 * [AllowAnonymous]
	 * @return ViewResult
	 */
	public function register() {
		$this->viewBag['title'] = 'Register';
		$model = new RegisterModel();
		return $this->view($model);
	}
	
	/**
	 * [AllowAnonymous]
	 * @return ViewResult
	 */
	public function post_register(RegisterModel $model, $returnUrl = 'index') {
		if($this->modelState->isValid()) {
			try {
				$user = $this->membership->createUser($model->email, $model->username, $model->password, false);
				$this->authentication->signin($user->getProviderName());
				return $this->redirectToAction($returnUrl);
			} catch(MembershipUserExistsException $e) {
				$this->modelState->setErrorMessageFor('username', 'Username is already in use, please pick another');
			}
		}
		
		return $this->view($model);
	}
}