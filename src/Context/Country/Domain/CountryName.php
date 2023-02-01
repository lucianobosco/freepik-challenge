<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

use App\Context\Country\Domain\Exceptions\InvalidTypeException;

class CountryName
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
     * @param string $name
     * @throws InvalidArgumentException
     */
    private function validate(string $name): void
    {
        if (!filter_var($name, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => '/[a-zA-Z\s]+/']])) {
            throw new InvalidTypeException("Country Code can only contain alpha characters and spaces.");
        }
    }
}