<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

class Login
{
    const INTERN_AUTH = 1;

    protected $db;

    protected $loginData = array();

    protected $authMethod;

    public function __construct($postData, $method = Login::INTERN_AUTH)
    {
        $this->db = DatabaseFactory::getInstance()->getDb();
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

            default: //@todo Exception
                return false;
                break;
        }

        return $loginProvider->authenticate($this->loginData);
    }

} 