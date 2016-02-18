<?php

namespace CpdnIDP\Controllers;

class ErrorsController extends ControllerBase {
	public function initialize() {
		$this->view->setTemplateBefore ( 'error' );
	}
	public function e404Action() {
	}
	public function e401Action() {
	}
	public function e500Action() {
	}
}
