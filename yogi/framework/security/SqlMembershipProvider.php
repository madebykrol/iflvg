<?php
namespace yogi\framework\security;
use yogi\framework\utils\ArrayList;

use yogi\framework\security\interfaces\IMembershipProvider;
use yogi\framework\security\interfaces\ICryptographer;
use yogi\framework\settings\interfaces\ISettingsRepository;
use yogi\framework\io\db\PDODal;
use yogi\framework\security\MembershipUser;
use yogi\framework\utils\Guid;
use yogi\framework\io\db\interfaces\IDal;
use yogi\framework\exceptions\MembershipUserExistsException;

class SqlMembershipProvider implements IMembershipProvider {
	
	private $datastore = null;
	private $settings = null;
	
	/**
	 * [Inject(yogi\framework\security\interfaces\ICryptographer)]
	 * @var ICryptographer
	 */
	private $encrypter = null;
	
	public function setEncrypter(ICryptographer $encrypter) {
		$this->encrypter = $encrypter;
	}
	
	public function __construct(ISettingsRepository $settings) {
		$this->settings = $settings;
		$connectionStrings = $settings->get('connectionStrings');
		$this->datastore = new PDODal($connectionStrings['Default']['connectionString']);
	}
	
	public function getAllUsers() {
		$users = new ArrayList();
		$this->datastore->clearCache();
		if($allUsers = $this->datastore->get('memberships') !== false) {
			
			foreach($allUsers as $u) {
				$user = new MembershipUser();
				$user->setProviderIdent($u->ident);
				$user->setProviderName($u->username);
				
				$users->add($user);
			}
		}
		
		return $users;
	}
	
	public function validateUser($username, $password) {
		$user = null;
		$users = $this->datastore->query('SELECT password, username FROM users AS u JOIN memberships AS m ON (u.ident = m.ident) WHERE username = ?', $username);
		
		if(count($users) == 1) {			
			$user = $users[0];
		}
		
		if(isset($user)) {
			if($this->encrypter->checkHash($password, $user->password)) {
				return true;
			} else {
				// update failed login attempts
			}
		}
		
		return false;
	}
	
	
	/**
	 * 
	 * @param unknown $username
	 * @param unknown $password
	 * @param unknown $providerUserKey
	 * @return MembershipUser
	 */
	public function createUser($email, $username, $password, $approved = false, $providerUserKey = null, $application = "#1") {
		$user = null;
		
		if($providerUserKey == null) {
			$providerUserKey = Guid::createNew();
		}
		
		if($this->getUser($username) == null) {
			$createDate = date('Y-m-d H:i:s');
			if($this->datastore->insert('memberships', 
					array(
							'email' => $email,  
							'password' => $this->encrypter->hash($password), 
							'ident' => $providerUserKey,
							'create_date' => $createDate,
							'is_approved' => $approved
							
					))) {
				$user = new MembershipUser();
				$user->setProviderIdent($providerUserKey);
				$user->setProviderName($username);
				
				$this->datastore->insert('users', 
						array(
								'application' => $application, 
								'ident' => $providerUserKey, 
								'username' => $username, 
								'last_active_date' => $createDate
						));
			}
		} else {
			throw new MembershipUserExistsException();
		}
		return $user;
	}
	
	public function getUser($user) {
		
		$userObject = null;
		$this->datastore->clearCache(true);
		
		if($user instanceof Guid) {
			$this->datastore->where(array('ident', '=', $user));
		} else if(is_string($user)) {
			if(Guid::parse($user) != null) {
				$this->datastore->where(array('ident', '=', $user));
			} else {
				$this->datastore->where(array('username', '=', $user));
			}
		}
		if(($users = $this->datastore->get('users')) !== false) {
			$userObject = new MembershipUser();
			$userObject->setProviderIdent($users[0]->ident);
			$userObject->setProviderName($users[0]->username);
		}
		
		return $userObject;
	}
}