<?php

declare(strict_types=1);

namespace App\Context\Country\Application\Find;

use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryRepository;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\Exceptions\NotFoundException;

class CountryFinder
{
    public function __construct(protected CountryRepository $countryRepository)
    {
    }

    public function __invoke(CountryCode $code): Country
    {
        $country = $this->countryRepository->getByCode($code);

        if (null === $country) {
            throw new NotFoundException($code);
        }

        return $country;
    }
}