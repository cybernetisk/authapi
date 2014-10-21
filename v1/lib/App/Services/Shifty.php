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
    const SERVICE_ID = 1;

    public $requestField = array(
        \App\Request::LOGIN => array('username', 'level'),
    );

    public function __construct()
    {
        parent::__construct('Shifty', 'http://shifty.blabla');
    }

    public function getServiceId()
    {
        return self::SERVICE_ID;
    }
}