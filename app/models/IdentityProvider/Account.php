<?php

namespace CpdnIDP\Models\IdentityProvider;

use Phalcon\Mvc\Model;

class Account extends Model {
	
	/**
	 *
	 * @var integer
	 *
	 */
	public $id;
	
	/**
	 *
	 * @var integer
	 *
	 */
	public $profileId;
	
	/**
	 *
	 * @var string
	 *
	 */
	public $email;
	
	/**
	 *
	 * @var string
	 *
	 */
	public $password;
	
	/**
	 *
	 * @var integer
	 *
	 */
	public $active;
	
	/**
	 *
	 * @var integer
	 *
	 */
	public $banned;
	
	/**
	 *
	 * @var integer
	 *
	 */
	public $suspended;
	
	/**
	 *
	 * @var integer
	 *
	 */
	public $enforceChangePassword;
	
	/**
	 *
	 * @var string
	 *
	 */
	public $tsCreate;
	
	/**
	 *
	 * @var string
	 *
	 */
	public $tsUpdate;
	
	public function initialize() {
		$this->setConnectionService ( 'idpDb' );
		
		$this->belongsTo ( "profileId", "CpdnIDP\Models\IdentityProvider\Profile", "id", array (
				'alias' => 'profile' 
		) );
	}
	public function beforeValidationOnCreate() {
		$this->tsCreate = date ( "Y-m-d H:i:s" );
		$this->tsUpdate = date ( "Y-m-d H:i:s" );
	}
	public function beforeValidationOnUpdate() {
		$this->tsUpdate = date ( "Y-m-d H:i:s" );
	}
	public function columnMap() {
		return array (
				'id' => 'id',
				'profile_id' => 'profileId',
				'email' => 'email',
				'password' => 'password',
				'active' => 'active',
				'banned' => 'banned',
				'suspended' => 'suspended',
				'enforce_change_password' => 'enforceChangePassword',
				'ts_create' => 'tsCreate',
				'ts_update' => 'tsUpdate' 
		);
	}
}
