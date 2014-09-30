<?php
/**
 * Auth API
 *
 * @author Alexis
 * @version
 * @since
 */

namespace App\Services;

class Shifty extends AbstractService
{

    public function __construct()
    {
        $this->serviceName = 'Shifty';
        $this->serviceUrl = 'http://shifty.blabla';
        $this->apiKey = '';
    }

    public function getRequest($requestData = array())
    {
        // TODO: Implement getRequest() method.
    }

    public function sendResponse($responseData = array())
    {
        $encryptedData = $this->_encryptData($responseData);
        curl_exec($this->curl);
    }

    protected function _setCurlOptions()
    {
        parent::_setCurlOptions();
        curl_setopt($this->curl, CURLOPT_URL, $this->_buildResponseUrl());
    }

    protected function _buildResponseUrl()
    {
        return $this->serviceUrl + '?response=';
    }

    protected function _encryptData() //@todo
    {

    }
}