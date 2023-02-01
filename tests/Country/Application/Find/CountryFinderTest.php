<?php

declare(strict_types=1);

namespace Tests\Country\Application\Find;

use App\Context\Country\Application\Find\CountryFinder;
use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\CountryRepository;
use App\Context\Country\Domain\Exceptions\InvalidLengthException;
use App\Context\Country\Domain\Exceptions\InvalidTypeException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 * @group feature
 */
class CountryFinderTest extends MockeryTestCase
{
    /**
     * @var shouldRecieve $this->repositoryMock
     */

    private Country $countryMock;
    private CountryRepository $repositoryMock;

    public function setUp(): void
    {
        $this->countryMock = Mockery::mock(Country::class);
        $this->repositoryMock = Mockery::mock(CountryRepository::class);
    }

    /** @test */
    public function find_should_success_when_valid_country_code(): void
    {
        $this->repositoryMock
            ->shouldReceive('getByCode')
            ->once()
            ->andReturn($this->countryMock);

        $countryFinder = new CountryFinder($this->repositoryMock);
        $result = $countryFinder->__invoke(new CountryCode('es'));

        $this->assertInstanceOf(Country::class, $result);
    }

    /** @test */
    public function find_should_fail_when_too_long_country_code(): void
    {
        $this->expectException(InvalidLengthException::class);

        $this->repositoryMock
            ->shouldReceive('getByCode')
            ->never();

        $countryFinder = new CountryFinder($this->repositoryMock);
        $countryFinder->__invoke(new CountryCode('lorem'));
    }

    /** @test */
    public function find_should_fail_when_invalid_country_code(): void
    {
        $this->expectException(InvalidTypeException::class);

        $this->repositoryMock
            ->shouldReceive('getByCode')
            ->never();

        $countryFinder = new CountryFinder($this->repositoryMock);
        $countryFinder->__invoke(new CountryCode('123'));
    }
}