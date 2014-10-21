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

//Set up the autoladers
require_once 'lib/App/Psr4Autoloader.php';

$loader = new \App\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('Facebook', 'lib/Facebook');
$loader->addNamespace('App', 'lib/App');

