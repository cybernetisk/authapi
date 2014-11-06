<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

//Start sessions
session_start();

//Set up app constants
define('APP_PATH', __DIR__);
define('APP_ENV', getenv('APP_MODE') ?: 'production');

//Set up the autoloaders
require_once 'lib/App/Psr4Autoloader.php';

$loader = new \App\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('Facebook', 'lib/Facebook');
$loader->addNamespace('App', 'lib/App');
$loader->addNamespace('Zend', 'lib/Zend');

//Register FacebookSession
$facebookCredentials = \App\Config::getInstance()->getConfig("facebook");
\Facebook\FacebookSession::setDefaultApplication($facebookCredentials['appid'], $facebookCredentials['secretid']);
unset($facebookCredentials);