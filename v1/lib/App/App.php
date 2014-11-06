<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;


class App
{
    const APP_VERSION = 'v1';

    const SUCCESS_CODE = 1;
    const ERROR_CODE = 0;

    public static function getAppUri()
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/' . self::APP_VERSION . '/';
    }

    public static function getPageUri($pageName, $parametersArray = array())
    {
        $baseUrl = self::getAppUri() . $pageName . '.php?';
        foreach ($parametersArray as $name => $value)
            $baseUrl .=  $name . '=' . $value . '&';

        return $baseUrl;
    }
} 