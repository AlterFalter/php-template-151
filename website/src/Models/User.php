<?php

namespace AlterFalter\Models;

class User
{
    public $id;
    public $mainFolderId;
    public $firstname;
    public $surname;
    public $email;
    public $password;


    public function __construct($id, $mainFolderId, $firstname, $surname, $email, $password)
    {
        $this->id = $id;
        $this->mainFolderId = $mainFolderId;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
    }
}
