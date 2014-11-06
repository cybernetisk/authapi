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
use Zend\Config\Reader\Ini;

class Config
{
    private static $instance = null;

    protected $databaseInfo = array();
    protected $generalInfo = array();


    private function __construct($configFile = "global.ini")
    {

        $reader = new Ini();
        $data = $reader->fromFile(APP_PATH . '/config/' . $configFile);

        $this->generalInfo = $data['global'];
        $this->databaseInfo = $data[APP_ENV]['database'];

    }

    public function getConfig($configKey)
    {
        switch($configKey)
        {
            case 'database':
                return $this->databaseInfo;
                break;

            default:
                if (array_key_exists($configKey, $this->generalInfo))
                    return $this->generalInfo[$configKey];

                throw new ArgumentException("$configKey is not a valid config param");
                break;
        }
    }

    static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new Config();

        return self::$instance;
    }


} 