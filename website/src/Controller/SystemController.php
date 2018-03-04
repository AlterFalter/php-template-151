<?php

namespace AlterFalter\Controller;

class SystemController
{
    public function createGUID()
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        }
        else
        {
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $guid = //chr(123).// "{"
                substr($charid, 0, 8).$hyphen.
                substr($charid, 8, 4).$hyphen.
                substr($charid,12, 4).$hyphen.
                substr($charid,16, 4).$hyphen.
                substr($charid,20,12);
                //.chr(125);// "}"
            return $guid;
        }
    }

    private function createCSRFToken()
    {
        $_SESSION["Token"] = $this->createGUID();
    }

    public function getHtmlToken()
    {
        $this->createCSRFToken();
        return '<input type="hidden" name="token" value="' . $_SESSION["Token"] . '">';
    }

    public function checkCSRFToken($data)
    {
        return (isset($_SESSION) &&
                isset($_SESSION["Token"]) &&
                isset($data) &&
                isset($data["token"]) &&
                $_SESSION["Token"] == $data["token"]);
    }
}