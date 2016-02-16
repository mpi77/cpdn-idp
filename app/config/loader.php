<?php
$loader = new \Phalcon\Loader ();

$loader->registerNamespaces ( array (
		'CpdnIDP\Models' => $config->application->modelsDir,
		'CpdnIDP\Controllers' => $config->application->controllersDir,
		'CpdnIDP\Plugins' => $config->application->pluginsDir,
		'CpdnIDP' => $config->application->libraryDir 
) );

$loader->register ();

// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../../vendor/autoload.php';
