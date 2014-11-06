<?php
/**
 * Auth API
 * 
 * @author Alexis
 * @version 
 * @since 
 */

namespace App;

use App\Config;

class DatabaseFactory
{
    private static $instance = null;

    protected $dbh;

    private function __construct()
    {

        $databaseConfig = Config::getInstance()->getConfig("database");

        $this->dbh = new \PDO('mysql: host=' . $databaseConfig['host'] . ';dbname=' . $databaseConfig['dbname'], $databaseConfig['username']);//, $databaseConfig['password']);
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