<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

use App\Context\Country\Domain\Exceptions\InvalidTypeException;

class CountryRegion
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
     * @param string $region
     * @throws InvalidArgumentException
     */
    private function validate(string $region): void
    {
        if (!filter_var($region, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => '/[a-zA-Z\s]+/']])) {
            throw new InvalidTypeException("Country Code can only contain alpha characters and spaces.");
        }
    }
}