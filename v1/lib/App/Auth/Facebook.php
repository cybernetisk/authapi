<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App\Auth;

use App\Exception\ArgumentException;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;
use Facebook\GraphUser;

class Facebook extends AbstractMethod
{
    protected $publicToken;

    public function __construct($publicToken)
    {
        parent::__construct();
        $this->publicToken = $publicToken;
    }


    //@todo Implements facebook Exception
    function authenticate($facebookSession)
    {
        if (! $facebookSession instanceof FacebookSession)
            throw new ArgumentException('Facebook authentification need a valid FacebookSession object');

        $response = (new FacebookRequest($facebookSession, 'GET', '/me'))->execute();
        $userFacebookId = $response->getGraphObject(GraphUser::className())->getId();

        $sqlRequest = $this->db->prepare('SELECT id FROM users WHERE facebookId = ? LIMIT 1');
        $sqlRequest->execute(array($userFacebookId));

        $result = $sqlRequest->fetchAll(\PDO::FETCH_ASSOC);
        if (!empty($result))
            return $result[0]['id'];

        return false;
    }
}