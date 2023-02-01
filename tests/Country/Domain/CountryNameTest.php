<?php

declare(strict_types=1);

namespace Tests\Country\Domain;

use App\Context\Country\Domain\CountryName;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */
class CountryNameTest extends TestCase
{
    protected function setUp(): void
    {
    }

    /** @test */
    public function should_success_when_valid(): void
    {
        $name = Factory::create()->city;
        $result = new CountryName($name);
        $this->assertTrue($result->value() == $name);
    }
}