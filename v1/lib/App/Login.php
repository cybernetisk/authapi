<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

use App\Exception\ArgumentException;

class Login
{
    const INTERN_AUTH = 1;
    const FACEBOOK_AUTH = 2;

    protected $db;

    protected $loginData = array();

    protected $publicToken = '';

    protected $authMethod;

    public function __construct($publicToken, $postData, $method = Login::INTERN_AUTH)
    {
        $this->db = DatabaseFactory::getInstance()->getDb();
        $this->publicToken = $publicToken;
        $this->loginData = $postData;
        $this->authMethod = $method;
    }

    public function authenticate()
    {
        switch($this->authMethod)
        {
            case Login::INTERN_AUTH:
                $loginProvider = new Auth\Intern();
                break;

            case Login::FACEBOOK_AUTH:
                $loginProvider = new Auth\Facebook($this->publicToken);
                break;

            default:
                throw new ArgumentException("Unknown authentication method : " . $this->authMethod);
                break;
        }

        return $loginProvider->authenticate($this->loginData);
    }


    static function getLoginUri($parametersArray = array())
    {
        $baseUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/' . \App\App::APP_VERSION . '/login.php?';
        foreach ($parametersArray as $name => $value)
            $baseUrl .=  $name . '=' . $value . '&';

        return $baseUrl;
    }
} 