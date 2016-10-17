<?php
namespace src\business\repositories\interfaces;

interface IUserRepository {
	
	/**
	 * @param unknown $domain
	 * @return SiteContext
	 */
	public function getUserDomain($domain);
	public function getUserById($id);
	public function getUserByEmail($email);
	public function saveUser($user);
	public function getFriendsForUser($id);
	public function requestFriendship($id, $instigatorId, $friendshipDetails);
	
}