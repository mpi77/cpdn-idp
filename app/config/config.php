<?php

return new \Phalcon\Config ( array (
		'database' => array (
				"idp" => array(
						'adapter' => 'Mysql',
						'host' => 'localhost',
						'username' => 'cpdn',
						'password' => 'cpdn',
						'name' => 'cpdn-idp',
						'charset'  => 'utf8'),
				"oauth" => array(
						'adapter' => 'Mysql',
						'host' => 'localhost',
						'username' => 'cpdn',
						'password' => 'cpdn',
						'name' => 'cpdn-oauth',
						'charset'  => 'utf8')
		),
		'application' => array (
				'controllersDir' => APP_DIR . '/controllers/',
				'modelsDir' => APP_DIR . '/models/',
				'viewsDir' => APP_DIR . '/views/',
				'layoutsDir' => '/layouts/',
				'partialsDir' => '/partials/',
				'libraryDir' => APP_DIR . '/library/',
				'pluginsDir' => APP_DIR . '/plugins/',
				'cacheDir' => APP_DIR . '/cache/',
				'baseUri' => '/',
				'publicUrl' => 'localhost:488',
				'cryptSalt' => 'I2W+71alkDfR|_&G&f,eEs654erwd4;pfdskW*JJFeasdadfgSAD3IU2&23' 
		),
		'mail' => array(
				'fromName' => 'CPDN IDP',
				'fromEmail' => 'noreply@cpdn',
				'smtp' => array(
						'server' => 'smtp...',
						'port' => 587,
						'security' => 'tls',
						'username' => 'noreply@...',
						'password' => 'pass...'
				)
		),
		'models' => array (
				'metadata' => array (
						'adapter' => 'Memory' 
				) 
		), 
		'urls' => array(
				'oauthAuthorizeEndpoint' => 'http://localhost:488/authorize',
				'oauthTokenEndpoint' => 'http://localhost:488/token'
		)
) );
