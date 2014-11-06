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

class Page
{

    static function getHeader()
    {
        return self::getTemplate('header');
    }

    static function getFooter($scriptName = 'site')
    {
        return include "Page/footer.php";
    }

    static function getNavBar()
    {
        return self::getTemplate("navbar");
    }

    static function getTemplate($templateName, $ext = 'php')
    {
        return require_once "Page/$templateName.$ext";

     //   throw new ArgumentException("Impossible to find $templateName.$ext in the templates files");
    }
} 