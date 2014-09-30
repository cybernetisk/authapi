<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

class User
{
    protected $db;

    protected $userData;

    public function __construct($userId = false)
    {

        $this->db = DatabaseFactory::getInstance()->getDb();

        if ($userId !== false)
            $this->_loadUserByUserId($userId);

    }

    protected function _loadUserByUserId($userId)
    {
        $sqlRequest = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $sqlRequest->execute(array($userId));

        $result = $sqlRequest->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) //@todo Exception
            return false;

        $this->userData = $result;
    }

    public function getServiceLevel($serviceName)
    {

    }


} 