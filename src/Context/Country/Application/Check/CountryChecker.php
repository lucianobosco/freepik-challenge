<?php

declare(strict_types=1);

namespace App\Context\Country\Application\Check;

use App\Context\Country\Domain\CountryRepository;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\Criteria;
use App\Context\Country\Domain\Exceptions\NotFoundException;

class CountryChecker
{
    public function __construct(protected CountryRepository $countryRepository)
    {
    }

    public function __invoke(CountryCode $code): Criteria
    {
        // Get Norway
        $norway = $this->countryRepository->getByCode(new CountryCode('nor'));
        // Get country by code
        $country = $this->countryRepository->getByCode($code);

        if (null === $country) {
            throw new NotFoundException($code);
        }

        // Return criteria
        $criteria = new Criteria($country, $norway);
        return $criteria;
    }
}