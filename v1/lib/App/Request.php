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
    protected $verb;
    protected $elements;

    protected $authorizedMethods = array('login');

    protected $requestCorpse = array(
        'method' => '',
        'action' => '',
    );

    public function __construct($request)
    {
        $this->verb = $_SERVER['REQUEST_METHOD'];
        $this->elements = explode('/', $request);
        $this->_parseIncomingData();
    }

    protected function _parseIncomingData()
    {
        var_dump($this->elements);
        foreach($this->elements as $params)
        {

        }
    }
} 