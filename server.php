<?php
$dsn      = 'mysql:dbname=cpdn-oauth;host=localhost';
$username = 'cpdn-idp';
$password = 'cpdn-idp';

date_default_timezone_set ( 'Europe/Prague' );
ini_set('display_errors',1);error_reporting(E_ALL);
require_once('vendor/autoload.php');

OAuth2\Autoloader::register();

$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

$server = new OAuth2\Server($storage);
$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));
$server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));

?>
