<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace AppTest;


use App\User;

class UserTest extends \PHPUnit_Framework_TestCase {

    protected $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testIsAuthenticate()
    {
        $this->assertFalse($this->user->isAuthenticate());
    }
}
 