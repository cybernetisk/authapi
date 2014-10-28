<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App\Auth;


use App\DatabaseFactory;

abstract class AbstractMethod
{

    protected $db;

    protected $requiredFields;

    abstract function authenticate($userData);

    public function __construct()
    {
        $this->db = DatabaseFactory::getInstance()->getDb();
    }

} 