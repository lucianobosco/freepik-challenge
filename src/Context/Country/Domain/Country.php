<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\CountryName;
use App\Context\Country\Domain\CountryPopulation;
use App\Context\Country\Domain\CountryRegion;
use JsonSerializable;

class Country implements JsonSerializable
{

    public function __construct(protected CountryName $name, protected CountryCode $code, protected CountryRegion $region, protected CountryPopulation $population)
    {
    }

    public function name(): CountryName
    {
        return $this->name;
    }

    public function code(): CountryCode
    {
        return $this->code;
    }

    public function region(): CountryRegion
    {
        return $this->region;
    }

    public function population(): CountryPopulation
    {
        return $this->population;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name->value(),
            'code' => $this->code->value(),
            'region' => $this->region->value(),
            'population' => $this->population->value()
        ];
    }
}