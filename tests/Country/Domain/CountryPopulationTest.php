<?php

declare(strict_types=1);

namespace Tests\Country\Domain;

use App\Context\Country\Domain\CountryPopulation;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class CountryPopulationTest extends TestCase
{
    protected function setUp(): void
    {
    }

    /** @test */
    public function should_success_when_valid(): void
    {
        $population = (int) Factory::create()->randomNumber();
        $result = new CountryPopulation($population);
        $this->assertTrue($result->value() == $population);
    }
}