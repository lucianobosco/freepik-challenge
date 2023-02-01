<?php

declare(strict_types=1);

use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\CountryName;
use App\Context\Country\Domain\CountryPopulation;
use App\Context\Country\Domain\CountryRegion;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class CountryTest extends TestCase
{
    protected function setUp(): void
    {
    }

    /** @test */
    public function should_success_when_valid(): void
    {
        $faker = Factory::create();

        $country = new Country(
            new CountryName($faker->city),
            new CountryCode($faker->lexify('???')),
            new CountryRegion($faker->country),
            new CountryPopulation($faker->randomNumber()),
        );

        $this->assertInstanceOf(Country::class, $country);
    }
}