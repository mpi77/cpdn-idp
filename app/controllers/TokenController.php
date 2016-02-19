<?php

namespace CpdnIDP\Controllers;
use OAuth2\Request;

class TokenController extends ControllerBase {
	public function initialize() {
		$this->view->disable();
	}
	public function runAction() {
		$server = $this->OAuthServer;
		$server->handleTokenRequest(Request::createFromGlobals())->send();
	}
}

