<?php

declare(strict_types=1);

namespace App\Context\Country\Infrastructure\Exceptions;

class RestApiConnectException extends \Exception
{
    function __construct($message)
    {
        parent::__construct($message);
    }
}