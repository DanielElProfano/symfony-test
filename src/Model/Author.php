<?php

namespace App\Model;

class Author
{
    public $name;
    public $admin;

    public function __construct($name, $isAdmin)
    {
        echo ("elnombre es: $name");
        $this->name = $name;
        $this->admin = $isAdmin;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getAdmin()
    {
        return $this->admin;
    }
}