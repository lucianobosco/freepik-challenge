<?php

declare(strict_types=1);

namespace Tests\Country\Application\Find;

use App\Context\Country\Application\Check\CountryChecker;
use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\CountryName;
use App\Context\Country\Domain\CountryPopulation;
use App\Context\Country\Domain\CountryRegion;
use App\Context\Country\Domain\CountryRepository;
use App\Context\Country\Domain\Criteria;
use App\Context\Country\Domain\Exceptions\InvalidLengthException;
use App\Context\Country\Domain\Exceptions\InvalidTypeException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @group feature
 */
class CountryCheckTest extends MockeryTestCase
{
    private CountryRepository $repositoryMock;

    public function setUp(): void
    {
        $this->repositoryMock = Mockery::mock(CountryRepository::class);
    }

    /** @test */
    public function test_check_should_success_when_valid_country_code(): void
    {
        $this->repositoryMock
            ->shouldReceive('getByCode')
            ->andReturn(new Country(
                new CountryName('elorem'),
                new CountryCode('elo'),
                new CountryRegion('europe'),
                new CountryPopulation(60000000),
            ));

        $countryChecker = new CountryChecker($this->repositoryMock);
        $result = $countryChecker->__invoke(new CountryCode('es'));

        $this->assertInstanceOf(Criteria::class, $result);
    }

    /** @test */
    public function find_should_fail_when_too_long_country_code(): void
    {
        $this->expectException(InvalidLengthException::class);

        $this->repositoryMock
            ->shouldReceive('getByCode')
            ->never();

        $countryFinder = new CountryChecker($this->repositoryMock);
        $countryFinder->__invoke(new CountryCode('lorem'));
    }

    /** @test */
    public function find_should_fail_when_invalid_country_code(): void
    {
        $this->expectException(InvalidTypeException::class);

        $this->repositoryMock
            ->shouldReceive('getByCode')
            ->never();

        $countryFinder = new CountryChecker($this->repositoryMock);
        $countryFinder->__invoke(new CountryCode('123'));
    }
}