<?php
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Crypt;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Files as MetaDataAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;
use CpdnIDP\Plugins\NotFoundPlugin;

$di = new FactoryDefault ();

$di->set ( 'config', $config );

$di->set ( 'dispatcher', function () use($di) {
	$eventsManager = new EventsManager ();
	$eventsManager->attach ( 'dispatch:beforeException', new NotFoundPlugin () );
	$dispatcher = new Dispatcher ();
	$dispatcher->setDefaultNamespace ( 'CpdnIDP\Controllers' );
	$dispatcher->setEventsManager ( $eventsManager );
	return $dispatcher;
} );

$di->set ( 'url', function () use($config) {
	$url = new UrlResolver ();
	$url->setBaseUri ( $config->application->baseUri );
	return $url;
}, true );

$di->set ( 'view', function () use($config) {
	$view = new View ();
	$view->setViewsDir ( $config->application->viewsDir );
	$view->setLayoutsDir ( $config->application->layoutsDir );
	$view->setPartialsDir ( $config->application->partialsDir );
	$view->registerEngines ( array (
			'.volt' => function ($view, $di) use($config) {
				$volt = new VoltEngine ( $view, $di );
				$volt->setOptions ( array (
						'compiledPath' => $config->application->cacheDir . 'volt/',
						'compiledSeparator' => '_' 
				) );
				return $volt;
			} 
	) );
	return $view;
}, true );

$di->set ( 'idpDb', function () use($config) {
	return new DbAdapter ( array (
			'host' => $config->database->idp->host,
			'username' => $config->database->idp->username,
			'password' => $config->database->idp->password,
			'dbname' => $config->database->idp->name,
			'charset' => $config->database->idp->charset 
	) );
} );

$di->set ( 'oauthDb', function () use($config) {
	return new DbAdapter ( array (
			'host' => $config->database->oauth->host,
			'username' => $config->database->oauth->username,
			'password' => $config->database->oauth->password,
			'dbname' => $config->database->oauth->name,
			'charset' => $config->database->oauth->charset 
	) );
} );

$di->set ( 'modelsMetadata', function () use($config) {
	return new MetaDataAdapter ( array (
			'metaDataDir' => $config->application->cacheDir . 'metaData/' 
	) );
} );

$di->set ( 'session', function () {
	$session = new SessionAdapter ( array (
			'uniqueId' => 'cpdnidp' 
	) );
	$session->start ();
	return $session;
} );

$di->set ( 'crypt', function () use($config) {
	$crypt = new Crypt ();
	$crypt->setKey ( $config->application->cryptSalt );
	return $crypt;
} );

$di->set ( 'router', function () {
	return require __DIR__ . '/routes.php';
} );

$di->set ( 'flash', function () {
	return new FlashDirect ( array (
			'error' => 'alert alert-danger',
			'success' => 'alert alert-success',
			'notice' => 'alert alert-info',
			'warning' => 'alert alert-warning' 
	) );
} );

$di->set ( 'flashSession', function () {
	$flash = new FlashSession ( array (
			'error' => 'alert alert-danger',
			'success' => 'alert alert-success',
			'notice' => 'alert alert-info',
			'warning' => 'alert alert-warning' 
	) );
	
	return $flash;
} );

$di->set ( 'OAuthServer', function () use($config) {
	OAuth2\Autoloader::register ();
	
	$dsn = sprintf ( 'mysql:dbname=%s;host=%s', $config->database->oauth->name, $config->database->oauth->host );
	$username = $config->database->oauth->username;
	$password = $config->database->oauth->password;
	$storage = new OAuth2\Storage\Pdo ( array (
			'dsn' => $dsn,
			'username' => $username,
			'password' => $password 
	) );
	
	$server = new OAuth2\Server ( $storage );
	$server->addGrantType ( new OAuth2\GrantType\ClientCredentials ( $storage ) );
	$server->addGrantType ( new OAuth2\GrantType\AuthorizationCode ( $storage ) );
	$server->addGrantType ( new OAuth2\GrantType\UserCredentials ( $storage ) );
	$server->addGrantType ( new OAuth2\GrantType\RefreshToken ( $storage, array(
			'refresh_token_lifetime' => 2419200,
			'always_issue_new_refresh_token' => true
	) ) );
	
	return $server;
} );
	