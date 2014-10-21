<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;


class Server
{
    const PUBLIC_TOKEN = 'publicToken';
    const PRIVATE_TOKEN = 'privateToken';

    const SUCCESS_CODE  = 1;
    const ERROR_CODE    = 0;

    const INTERN_ERROR = 'internError';
    const MISSING_TOKEN = 'missingToken';
    const INVALID_EXPIRED_TOKEN = 'invalidToken';

    protected $errorMessages = array(
        self::INTERN_ERROR => 'Something went wrong with the server',
        self::MISSING_TOKEN => 'Private token required for this action',
        self::INVALID_EXPIRED_TOKEN => 'Invalid or expired token',
    );

    protected $serviceName;

    protected $serviceClass;

    protected $db;

    protected $privateToken;

    protected $allowedRequest = array('generateTokens', 'verifyTokens');

    public function __construct($serviceName, $getData)
    {
        $this->db = DatabaseFactory::getInstance()->getDb();

        $this->serviceName = $serviceName;
        $this->_loadService();

        if (isset($getData['token']))
            $this->privateToken = $getData['token'];
    }


    protected function _loadService()
    {
        $className = '\App\Services\\' . $this->serviceName;
        $this->serviceClass = new $className();
    }


    protected function _getErrorMessage($error = self::INTERN_ERROR)
    {
        return array('message' => $this->errorMessages[$error]);
    }

    public function generateTokens()
    {
        $tokensArray = array(
            self::PUBLIC_TOKEN => $this->_generateToken(),
            self::PRIVATE_TOKEN => $this->_generateToken(60),
        );

        $sql = $this->db->prepare("INSERT INTO tokens (serviceId, privateToken, publicToken, expirationTime) VALUES (:serviceId, :privateToken, :publicToken, NOW() + INTERVAL 20 MINUTE)");
        $return = $sql->execute(array(
            ':serviceId' => $this->serviceClass->getServiceId(),
            ':privateToken' => $tokensArray[self::PRIVATE_TOKEN],
            ':publicToken' => $tokensArray[self::PUBLIC_TOKEN],
        ));

        $returnData = array_merge($tokensArray, array(
           'loginUri' => \App\Login::getloginUri() . '?token=' . $tokensArray[self::PUBLIC_TOKEN],
            'askUri' => \App\Server::getAskUri($tokensArray[self::PRIVATE_TOKEN], $this->serviceName),
        ));

        if ($return === true)
            $this->displayResponse(self::SUCCESS_CODE, $returnData);
        else
            $this->displayResponse(self::ERROR_CODE, $this->_getErrorMessage(self::INTERN_ERROR));
    }

    public function displayResponse($code, $returnData = array())
    {
        $responseCode = array('code' => $code);
        $response = array_merge($responseCode, $returnData);

        echo json_encode($response);

        return true;
    }

    public function verifyTokens()
    {
        if ($this->privateToken === '')
            $this->displayResponse(self::ERROR_CODE, $this->_getErrorMessage(self::MISSING_TOKEN));
        else
        {
            $sql = $this->db->prepare('SELECT username, level FROM tokens WHERE privateToken = :token AND expirationTime > NOW() LIMIT 1;');
            $sql->execute(array(':token' => $this->privateToken));

            $result = $sql->fetch(\PDO::FETCH_ASSOC);

            if ($result === false)
                $this->displayResponse(self::ERROR_CODE, $this->_getErrorMessage(self::INVALID_EXPIRED_TOKEN));
            else
                $this->displayResponse(self::SUCCESS_CODE, $result);
        }
    }

    public function getRequest($request)
    {
        if (in_array($request, $this->allowedRequest))
            return $request;

        return false;
    }

    protected function _generateToken($size = 50)
    {
        $longString = md5(uniqid()) . md5(uniqid()) . md5(uniqid());
        return substr($longString, 0, $size);
    }

    static function getAskUri($privateToken, $serviceName)
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . '/' . \App\App::APP_VERSION . '/server.php?token=' . $privateToken . '&service=' . $serviceName . '&request=verifyTokens';
    }
} 