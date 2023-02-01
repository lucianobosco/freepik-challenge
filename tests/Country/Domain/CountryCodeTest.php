<?php

declare(strict_types=1);

namespace Tests\Country\Domain;

use App\Context\Country\Domain\Exceptions\InvalidLengthException;
use App\Context\Country\Domain\Exceptions\InvalidTypeException;
use App\Context\Country\Domain\CountryCode;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class CountryCodeTest extends TestCase
{
    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create();
    }

    /** @test */
    public function should_success_when_valid(): void
    {
        $name = $this->faker->lexify('???');
        $result = new CountryCode($name);
        $this->assertTrue($result->value() == $name);
    }

    /** @test */
    public function should_fail_when_invalid_length(): void
    {
        $this->expectException(InvalidLengthException::class);

        $name = $this->faker->lexify('????'); // More than 3 chars
        new CountryCode($name);
    }

    /** @test */
    public function should_fail_when_invalid_type(): void
    {
        $this->expectException(InvalidTypeException::class);

        $name = (string) $this->faker->randomNumber(3, true); // Integers in code string
        new CountryCode($name);
    }
}