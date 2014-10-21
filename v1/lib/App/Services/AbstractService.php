<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App\Services;


abstract class AbstractService
{
    public $serviceName;

    public $serviceUrl;

    protected $apiKey;

    public function __construct($serviceName, $serviceUrl)
    {
        $this->serviceName = $serviceName;

        $this->serviceUrl = $serviceUrl;
    }

    public function sendResponse($responseData = array())
    {
        header('Location: ' . $this->_buildResponseUrl($responseData));
        //@todo LOG
        die();
    }

    public function decryptData($data)
    {
        return json_decode($data);
    }

    protected function _buildResponseUrl($data)
    {
        if (is_array($data))
            return $this->serviceUrl . '?r=' . $this->_encryptData($data);
        else
            return $this->serviceUrl . '?r=' . $data;
    }

    protected function _encryptData(array $data)
    {
        return json_encode($data);
    }
}