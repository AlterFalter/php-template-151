<?php

namespace AlterFalter\Models;

class Folder
{
    public $id;
    public $parentFolderId;
    public $name;
    public $folders;
    public $files;
    public $isMainFolder;

    public function __construct($id, $parentFolderId, $name, $folders, $files, $isMainFolder)
    {
        $this->id = $id;
        $this->parentFolderId = $parentFolderId;
        $this->name = $name;
        $this->folders = $folders;
        $this->files = $files;
        $this->isMainFolder = $isMainFolder;
    }
}
