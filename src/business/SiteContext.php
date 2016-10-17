<?php
namespace src\business;

class SiteContext {
	
	public $userId;
	public $domainIsActive;
	public $pageOwner;
	public $isOwner;
	public $domain;
	public $currentUser;
	
	
	public function __construct($userId, $domainIsActive, UserProfile $pageOwner, $domain) {
		$this->userId = $userId;
		$this->domainIsActive = $domainIsActive;
		$this->pageOwner = $pageOwner;
		$this->domain = $domain;
	}
}