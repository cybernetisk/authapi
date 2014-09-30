<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App\Auth;


abstract class AbstractMethod
{

    protected $requiredFields;

    abstract function authenticate($userData);

} 