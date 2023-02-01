<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

use App\Context\Country\Domain\Exceptions\InvalidTypeException;

class CountryPopulation
{
    public function __construct(protected int $value)
    {
        $this->validate($value);
    }

    public function value(): int
    {
        return $this->value;
    }

    /*******************
     * @param int $population
     * @throws InvalidArgumentException
     */
    private function validate(int $population): void
    {
        if (!filter_var($population, FILTER_VALIDATE_INT)) {
            throw new InvalidTypeException("Country Population can only contain integers.");
        }
    }
}