<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

use App\Exception\ArgumentException;
use App\Exception\InvalidMethodCall;

trait ErrorTrait
{
    public $hasError = false;
    public $errorMessageArray = array();

    public $errorMessage;

    public function getErrorMessage($errorId)
    {
        if (array_key_exists($errorId, $this->errorMessageArray))
            return $this->errorMessageArray[$errorId];

        throw new ArgumentException('Unknown message error id. Time to go to bed');
    }

    public function setError($errorId, $argumentsArray = array())
    {
        $this->hasError = true;

        $errorMessage = $this->getErrorMessage($errorId);


        if (is_string($argumentsArray))
            $this->errorMessage = sprintf($errorMessage, $argumentsArray);

        else if (!empty($argumentsArray))
            $this->errorMessage = vsprintf($errorMessage, $argumentsArray);

        else
            $this->errorMessage = $errorMessage;
    }

    public function getError()
    {
        if ($this->hasError === true)
            return $this->errorMessage;

        throw new InvalidMethodCall('This function should not been called if there is no error.');
    }

    public function getStatusCode()
    {
        if ($this->hasError)
            return App::ERROR_CODE;
        else
            return App::SUCCESS_CODE;
    }

    public function getData($normalData)
    {
        if ($this->hasError === true)
            return $this->getError();
        else
            return $normalData;
    }
}