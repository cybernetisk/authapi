<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

class Request
{
    const LOGIN = 'login';

    public $isLinked = false;

    public $token = '';

    protected $db;

    protected $service;
    protected $request;

    private $authorizedServices = array('shifty');
    private $authorizedRequest = array('login', 'tokenGen');

    private $servicesArray = array(
        \App\Services\Shifty::SERVICE_ID => 'Shifty',
    );

    public function __construct($request)
    {
        $this->db = DatabaseFactory::getInstance()->getDb();

        if (isset($request['token']))
        {
            $serviceId = $this->_getServiceIdByToken($request['token']);
            if ($serviceId === false)
                echo 'Error'; //@todo Exception
            else
            {
                $this->_initializeService($this->servicesArray[$serviceId]);
                $this->publicToken = $request['token'];
            }
        } else
            die(); //@todo Exception

        if (isset($request['request']))
        {
            if (in_array($request['request'], $this->authorizedRequest))
                $this->request = $request['request'];
            else //@todo Exception
                die();
        } else
            die(); //@todo Exception

    }

    protected function _getServiceIdByToken($publicToken)
    {
        $sql = $this->db->prepare('SELECT serviceId FROM tokens WHERE publicToken = :token LIMIT 1');
        $sql->execute(array(
           ':token' => $publicToken,
        ));

        $result = $sql->fetch(\PDO::FETCH_ASSOC);
        if ($result !== false)
            return $result['serviceId'];

        return $result;
    }

    protected function _initializeService($serviceName)
    {
        $className = '\App\Services\\' . $serviceName;
        $this->service = new $className();

        $this->isLinked = true;
    }

    protected function _loginResponse($requestFields, User $user)
    {
        $sql = $this->db->prepare('SELECT p.level,u.username FROM permissions as p INNER JOIN users as u WHERE u.id = p.userId AND serviceId = :serviceId AND u.id = :userId LIMIT 1');
        $sql->execute(array(
            ':serviceId' => $this->service->getServiceId(),
            ':userId' => $user->getUserId(),
        ));

        $result = $sql->fetch(\PDO::FETCH_ASSOC);

        if ($result === false) //@todo Exception
            die();
        else
            return $result;
    }

    public function sendResponse($user = false)
    {
        if ($this->isLinked === false) die();
            //@todo Exception

        $requestField = $this->service->requestField[$this->request];
        switch($this->request)
        {
            case 'login':
                $returnResult = $this->_loginResponse($requestField, $user);
                break;

            default:
                die(); //@todo Exception
        }

        $this->_updateTokens($returnResult);

        $this->service->sendResponse($this->publicToken);
    }

    protected function _updateTokens($returnResult)
    {
        $sql = $this->db->prepare('UPDATE tokens SET username = :username, level = :level WHERE publicToken = :token ;');
        $result = $sql->execute(array(
           ':username' => $returnResult['username'],
            ':level' => $returnResult['level'],
            ':token' => $this->publicToken,
        ));

        if ($result === false)
            die(); //@todo exception

        return true;
    }

}