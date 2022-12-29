<?php

namespace App\Core\Console;

use App\Core\Exceptions\DetailableException;

class InvalidCommandDescException extends DetailableException
{
    public function __construct()
    {
        parent::__construct("Your command description is invalid");
    }

    public function getDetail(): string
    {
        return "Please fill \$desc property on your command file.";
    }
}
