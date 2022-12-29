<?php

namespace App\Core\Console;

use App\Core\Exceptions\DetailableException;

class InvalidCommandArgumentException extends DetailableException
{
    public function __construct()
    {
        parent::__construct("Your command Argument is invalid");
    }

    public function getDetail(): string
    {
        return "Please fill \$args property on your command file with correct format.";
    }
}
