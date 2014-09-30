<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

class DatabaseFactory
{
    private static $instance = null;

    //TODO read by ini file
    private $host = 'localhost';
    private $dbName = 'apiauth';
    private $dbUsername = 'apiauth';
    private $dbPassword = '9DpzYPAD59EFM9Tu';

    protected $dbh;

    private function __construct()
    {

        $this->dbh = new \PDO('mysql: host=' . $this->host . ';dbname=' . $this->dbName, $this->dbUsername);//, $this->dbPassword);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new DatabaseFactory();

        return self::$instance;
    }

    public function getDb()
    {
        return $this->dbh;
    }
} 