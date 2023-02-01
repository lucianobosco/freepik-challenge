<?php

namespace Tests\Country\Infrastructure;

use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Infrastructure\Exceptions\NotFoundException;
use App\Context\Country\Infrastructure\RestCountriesRepository;
use PHPUnit\Framework\TestCase;

/**
 * @group adapter
 */
class RestCountriesRepositoryTest extends TestCase
{
    protected RestCountriesRepository $adapter;

    protected function setUp(): void
    {
        $this->adapter = new RestCountriesRepository();
    }

    /** @test */
    public function should_success_when_country_found(): void
    {
        $code = new CountryCode('es');
        $result = $this->adapter->getByCode($code);

        $this->assertInstanceOf(Country::class, $result);
    }

    /** @test */
    public function should_fail_when_country_not_found(): void
    {
        $this->expectException(NotFoundException::class);

        $code = new CountryCode('www');
        $this->adapter->getByCode($code);
    }
}