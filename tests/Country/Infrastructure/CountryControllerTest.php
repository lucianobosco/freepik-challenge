<?php

namespace Tests\Country\Infrastructure;

use App\Context\Country\Application\Check\CountryChecker;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\Criteria;
use App\Context\Country\Domain\Exceptions\InvalidLengthException;
use App\Context\Country\Domain\Exceptions\InvalidTypeException;
use Mockery;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

/**
 * @group e2e
 */
class CountryControllerTest extends TestCase
{
    protected $logger;
    protected $countryCheckerMock;

    protected function setUp(): void
    {
        $this->logger = new Logger('app');
        $streamHandler = new StreamHandler('public/test.log', Level::Debug);
        $this->logger->pushHandler($streamHandler);

        $this->countryCheckerMock = Mockery::mock(CountryChecker::class);
        $this->countryCheckerMock
            ->shouldReceive('__invoke')
            ->once()
            ->andReturn(Mockery::mock(Criteria::class));
    }

    /** @test */
    public function should_success_when_country_found(): void
    {
        $response = $this->countryCheckerMock->__invoke(new CountryCode('es'));
        $this->assertInstanceOf(Criteria::class, $response);
    }

    /** @test */
    public function should_fail_when_too_long_country_code(): void
    {
        $this->expectException(InvalidLengthException::class);

        $this->countryCheckerMock
            ->shouldReceive('__invoke')
            ->never();

        $this->countryCheckerMock->__invoke(new CountryCode('lorem'));
    }

    /** @test */
    public function should_fail_when_invalid_country_code(): void
    {
        $this->expectException(InvalidTypeException::class);

        $this->countryCheckerMock
            ->shouldReceive('__invoke')
            ->never();

        $this->countryCheckerMock->__invoke(new CountryCode('123'));
    }
}