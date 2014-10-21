<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App\Auth;

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookSession;

class Facebook extends AbstractMethod
{

    public $fbHelper;

    public function __construct($publicToken, $facebookSession = false)
    {
        FacebookSession::setDefaultApplication('378344682313337', 'b8476b290aa2abcdb9168a6190d89ea0');
        $this->helper = new FacebookRedirectLoginHelper(\App\Login::getLoginUri() . '?token=' . $publicToken);
    }


    function authenticate($userData)
    {
        // TODO: Implement authenticate() method.
    }

    public function getLoginUri()
    {
        return $this->helper->getLoginUrl();
    }
}