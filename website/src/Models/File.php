<?php

namespace AlterFalter\Models;

class File
{
    public $id;
    public $folderId;
    public $name;
    public $extension;
    public $data;

    public function __construct($id, $folderId, $name, $extension, $data)
    {
        $this->id = $id;
        $this->folderId = $folderId;
        $this->name = $name;
        $this->extension = $extension;
        $this->data = $data;
    }

    public function getFullName()
    {
        return ($name . "." . $extension);
    }

    public function getFileSize()
    {
        if (function_exists('mb_strlen')) 
        {
            $size = mb_strlen($string, '8bit');
        }
        else
        {
            $size = strlen($string);
        }
        return $size;
    }
}
