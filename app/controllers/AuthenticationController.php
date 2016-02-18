<?php

namespace CpdnIDP\Controllers;

use Phalcon\Security\Random;
use CpdnIDP\Models\IdentityProvider\Account;

class AuthenticationController extends ControllerBase {
	const PATTERN_PASSWORD = "/^[a-zA-Z0-9_\/\.\-\\:]{5,45}$/";
	private $random;
	
	public function initialize() {
		$this->view->setTemplateBefore ( 'public' );
		$this->random = new Random ();
		$this->session->validAuthenticationToken = null;
		$this->session->userId = null;
	}
	public function loginAction() {
		$this->view->showLoginForm = true;
		
		$response_type = $this->request->getQuery ( "response_type" );
		$client_id = $this->request->getQuery ( "client_id" );
		$state = $this->request->getQuery ( "state" );
		
		if (empty ( $response_type ) || empty ( $client_id ) || empty ( $state )) {
			$this->flashSession->error ( "Invalid or missing URI parameters in request. Required params are: response_type, client_id, state. Try it again." );
			$this->view->showLoginForm = false;
		}
		if ($this->request->isPost ()) {
			if ($this->security->checkToken ()) {
				$email = filter_var ( $this->request->getPost ( "email" ), FILTER_VALIDATE_EMAIL );
				$password = $this->request->getPost ( "password" );
				if ($email && preg_match ( self::PATTERN_PASSWORD, $password ) === 1) {
					$account = Account::findFirst ( array (
							'email = :email: AND active = 1 AND banned = 0 AND suspended = 0',
							'bind' => array (
									"email" => $email 
							) 
					) );
					if (! $account) {
						$this->flashSession->error ( "Unknown user. Try it again." );
						return $this->response->redirect ( sprintf("/authentication?response_type=%s&client_id=%s&state=%s", $response_type, $client_id, $state));
					} else {
						if ($this->security->checkHash ( $password, $account->password )) {
							$this->session->validAuthenticationToken = hash ( "sha256", $this->random->uuid () );
							$this->session->userId = $account->profileId;
							return $this->response->redirect ( 
									sprintf("/authorization?response_type=%s&client_id=%s&state=%s&token=%s", $response_type, $client_id, $state,
											$this->session->validAuthenticationToken
							) );
						} else {
							$this->flashSession->error ( "Incorrect password. Try it again." );
							return $this->response->redirect ( sprintf("/authentication?response_type=%s&client_id=%s&state=%s", $response_type, $client_id, $state));
						}
					}
				} else {
					$this->flashSession->error ( "Form validation failed. Try it again." );
				}
			} else {
				$this->flashSession->error ( "Security form validation failed. Try it again." );
				return $this->response->redirect ( sprintf("/authentication?response_type=%s&client_id=%s&state=%s", $response_type, $client_id, $state));
			}
		}
	}
}

