<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App\Auth;

class Intern extends AbstractMethod
{
    protected $db;

    protected $requiredFields = array('username', 'password');

    public function __construct()
    {
        $this->db = \App\DatabaseFactory::getInstance()->getDb();
    }

    /**
     * Authenticate an user
     *
     * @param $authArray
     * @return bool
     */
    public function authenticate($authArray)
    {
        foreach($this->requiredFields as $field)
        {
            if (!isset($authArray[$field]))
                return false;
        }

        $sqlRequest = $this->db->prepare('SELECT userId, password FROM intern_auth WHERE username = ? LIMIT 1');
        $sqlRequest->execute(array($authArray['username']));

        $result = $sqlRequest->fetchAll(\PDO::FETCH_ASSOC);

        if (!empty($result))
        {
            $userDbData = $result[0];
            if (password_verify($authArray['password'], $userDbData['password']))
                return $userDbData['userId'];
            else
                return false;
        }
        else
            return false;
    }

    /**
     * Hash password to store it in database
     *
     * @param $password Password to hash
     * @return bool|string
     */
    protected function _hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
} 