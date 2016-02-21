<?php

namespace CpdnIDP\Controllers;
use OAuth2\Request;
use OAuth2\Response;

class AuthorizationController extends ControllerBase {
	private static $clients = array(
			"editorV1" => array(
					"network / schemes",
					"network / elements",
					"network / maps",
					"network / permissions",
					"background / tasks",
					"background / executors",
					"idp / users"
			)
	);
	public function initialize() {
		$this->view->setTemplateBefore ( 'public' );
	}
	public function runAction() {
		$this->view->showAuthorizeForm = false;
		
		$response_type = $this->request->getQuery ( "response_type" );
		$client_id = $this->request->getQuery ( "client_id" );
		$state = $this->request->getQuery ( "state" );
		$token = $this->request->getQuery ( "token" );
		
		if (empty ( $response_type ) || empty ( $client_id ) || !array_key_exists($client_id, self::$clients) || empty ( $state )) {
			$this->view->showAuthorizeForm = false;
			$this->session->validAuthenticationToken = null;
			$this->session->userId = null;
			$this->flashSession->error ( "Invalid or missing URI parameters in request. Required params are: response_type, client_id, state. Try it again." );
		} else{
			if (! (! empty ( $this->session->validAuthenticationToken ) && ! empty ( $token ) && $token == $this->session->validAuthenticationToken)) {
				$this->session->validAuthenticationToken = null;
				$this->session->userId = null;
				return $this->dispatcher->forward ( array (
						"controller" => "errors",
						"action" => "e401"
				) );
			} else{
				$this->view->showAuthorizeForm = true;
				$this->view->resources = self::$clients[$client_id];
				$this->view->clientId = $client_id;
				
				$server = $this->OAuthServer;
				$request = Request::createFromGlobals ();
				$response = new Response ();
				
				if (! $server->validateAuthorizeRequest ( $request, $response )) {
					$response->send ();
					die ();
				}
				
				if ($this->request->isPost ()) {
					if ($this->security->checkToken ()) {
						$user_id = $this->session->userId;
						$this->session->validAuthenticationToken = null;
						$this->session->userId = null;
						$is_authorized = ($this->request->getPost ( "confirm" ) === "yes");
						$server->handleAuthorizeRequest ( $request, $response, $is_authorized, $user_id);
						$response->send ();
					} else {
						$this->flashSession->error ( "Security form validation failed. Try it again." );
						return $this->response->redirect ( sprintf("/authentication?response_type=%s&client_id=%s&state=%s", $response_type, $client_id, $state));
					}
				}
			}
		}
	}
}

