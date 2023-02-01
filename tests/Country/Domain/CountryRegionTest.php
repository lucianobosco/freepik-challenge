<?php

declare(strict_types=1);

namespace Tests\Country\Domain;

use App\Context\Country\Domain\CountryRegion;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class CountryRegionTest extends TestCase
{
    protected function setUp(): void
    {
    }

    /** @test */
    public function should_success_when_valid(): void
    {
        $country = Factory::create()->country;
        $result = new CountryRegion($country);
        $this->assertTrue($result->value() == $country);
    }
}