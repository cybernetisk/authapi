<?php
/**
 * Auth API
 *
 * @author Alexis
 * @version
 * @since
 */

require_once 'bootstrap.php';

$requestedFields = array('service');

if (!empty($_GET))
{
    foreach($requestedFields as $name)
        if (!isset($_GET[$name])) die();

    $serviceName = $_GET['service'];
    $server = new App\Server($serviceName, $_GET);

    if (isset($_GET['request']))
    {
        $request = $server->getRequest($_GET['request']);
        if ($request === false)
            echo 'Error'; //@todo
        else
            $server->$request();
    }

}