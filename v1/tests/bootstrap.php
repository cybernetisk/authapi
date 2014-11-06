<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

/**
 * Setup autoloading
 */
//Set up the autoloaders
require_once 'Psr4Autoloader.php';

$rootFolder = realpath(dirname(__DIR__));
$libFolder = "$rootFolder/lib";
$testsFolder = realpath(__DIR__);

$loader = new Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('AppTest', "$testsFolder/AppTest");
$loader->addNamespace('App', "$libFolder/App");
$loader->addNamespace('Zend', "$libFolder/Zend");
$loader->addNamespace('Facebook', "$libFolder/Facebook");


//Setup configuration
defined('APP_PATH') || define('APP_PATH', $rootFolder);
defined('APP_MODE') || define('APP_ENV', 'dev');