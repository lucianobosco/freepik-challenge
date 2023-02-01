<?php

declare(strict_types=1);

namespace App\Context\Country\Domain\Exceptions;

class NotFoundException extends \Exception
{
    function __construct($message)
    {
        parent::__construct($message);
    }
}