<?php
namespace src\business\repositories\mockups;

use src\business\repositories\interfaces\IUserRepository;
use src\business\SiteContext;
use src\business\UserProfile;

class MockUserRepository implements IUserRepository {
	
	private $users;
	
	public function __construct() {
		$this->users = array(
			'0923b4d0-5ce1-47f3-8286-5d3591fc1c60' => 
				new SiteContext('0923b4d0-5ce1-47f3-8286-5d3591fc1c60', true, new UserProfile(), 'lousyat'),
		);
	}
	
	
	public function getUserDomain($domain) {
		foreach($this->users as $id => $user) {
			if(strtolower($user->domain) == strtolower($domain)) {
				return $user;
			}
		}
	}
	
	public function getUserById($id) {
		
	}
	
	public function getUserByEmail($email) {
		
	}
	
	public function saveUser($user) {
		
	}
	
	public function getFriendsForUser($id) {
		
	}
	
	public function requestFriendship($id, $instigatorId, $friendshipDetails) {
		
	}
	
}