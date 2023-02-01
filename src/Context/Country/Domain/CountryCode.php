<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

use App\Context\Country\Domain\Exceptions\InvalidLengthException;
use App\Context\Country\Domain\Exceptions\InvalidTypeException;

class CountryCode
{
    public function __construct(protected string $value)
    {
        $this->validate($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    /*******************
     * @param string $code
     * @throws InvalidArgumentException
     */
    private function validate(string $code): void
    {
        if (!ctype_alpha($code)) {
            throw new InvalidTypeException("Country Code can only contain alpha characters.");
        }
        if (strlen($code) > 3) {
            throw new InvalidLengthException("Country Code can not contain more than 3 characters.");
        }
    }
}