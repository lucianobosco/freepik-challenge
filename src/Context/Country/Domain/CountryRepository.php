<?php

declare(strict_types=1);

namespace App\Context\Country\Domain;

use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;

interface CountryRepository
{
    public function getByCode(CountryCode $code): ?Country;
}