<?php
use Phalcon\Mvc\Router;
use CpdnAPI\Routes\ConfigRoutes;
use CpdnAPI\Routes\ExecutorRoutes;
use CpdnAPI\Routes\MappointRoutes;
use CpdnAPI\Routes\NodeRoutes;
use CpdnAPI\Routes\NotificationRoutes;
use CpdnAPI\Routes\ObjectRoutes;
use CpdnAPI\Routes\PathRoutes;
use CpdnAPI\Routes\PermissionRoutes;
use CpdnAPI\Routes\SchemeRoutes;
use CpdnAPI\Routes\SectionRoutes;
use CpdnAPI\Routes\TaskRoutes;
use CpdnAPI\Routes\UserRoutes;

$router = new Router ();
$router->setDefaultController ( 'index' );
$router->setDefaultAction ( 'index' );

$router->add ( '/authentication', array (
		'controller' => 'authentication',
		'action' => 'login'
) );

$router->add ( '/token', array (
		'controller' => 'token',
		'action' => 'run'
) );

$router->add ( '/authorization', array (
		'controller' => 'authorization',
		'action' => 'run'
) );



return $router;