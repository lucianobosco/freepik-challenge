<?php

declare(strict_types=1);

use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\CountryName;
use App\Context\Country\Domain\CountryPopulation;
use App\Context\Country\Domain\CountryRegion;
use App\Context\Country\Domain\Criteria;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class CriteriaTest extends TestCase
{
    protected $rival;

    protected function setUp(): void
    {
        $faker = Factory::create();

        $this->rival = new Country(
            new CountryName($faker->city),
            new CountryCode($faker->lexify('???')),
            new CountryRegion($faker->country),
            new CountryPopulation(55000000),
        );
    }

    /** @test */
    public function should_success_when_country_is_rival(): void
    {
        $country = new Country(
            new CountryName('elorem'),
            new CountryCode('elo'),
            new CountryRegion('europe'),
            new CountryPopulation(60000000),
        );

        $criteria = new Criteria($country, $this->rival);

        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertEquals(true, $criteria->result);
    }

    /** @test */
    public function should_fail_when_country_name_is_incorrect(): void
    {
        $country = new Country(
            new CountryName('lorem'),
            new CountryCode('elo'),
            new CountryRegion('europe'),
            new CountryPopulation(60000000),
        );

        $criteria = new Criteria($country, $this->rival);


        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertEquals(false, $criteria->result);
    }

    /** @test */
    public function should_fail_when_country_region_is_incorrect(): void
    {
        $country = new Country(
            new CountryName('elorem'),
            new CountryCode('elo'),
            new CountryRegion('asia'),
            new CountryPopulation(60000000),
        );

        $criteria = new Criteria($country, $this->rival);

        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertEquals(false, $criteria->result);
    }

    /** @test */
    public function should_fail_when_country_population_is_incorrect(): void
    {
        $country = new Country(
            new CountryName('elorem'),
            new CountryCode('elo'),
            new CountryRegion('europe'),
            new CountryPopulation(30000000),
        );

        $criteria = new Criteria($country, $this->rival);

        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertEquals(false, $criteria->result);
    }

    /** @test */
    public function should_fail_when_country_population_is_not_rival(): void
    {
        $country = new Country(
            new CountryName('elorem'),
            new CountryCode('elo'),
            new CountryRegion('europe'),
            new CountryPopulation(50000000),
        );

        $criteria = new Criteria($country, $this->rival);

        $this->assertInstanceOf(Criteria::class, $criteria);
        $this->assertEquals(false, $criteria->result);
    }
}