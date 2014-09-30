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

    protected $curl;

    protected $apiKey;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    protected function _setCurlOptions()
    {
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'AuthService for Cyb');
    }

    abstract public function sendResponse($responseData = array());

    abstract protected function _buildResponseUrl();

    abstract public function getRequest($requestData = array());
} 