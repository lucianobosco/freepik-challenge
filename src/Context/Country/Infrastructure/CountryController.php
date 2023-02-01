<?php

namespace App\Context\Country\Infrastructure;

use App\Context\Country\Application\Check\CountryChecker;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\Exceptions\InvalidLengthException;
use App\Context\Country\Domain\Exceptions\InvalidTypeException;
use App\Context\Country\Domain\Exceptions\NotFoundException;
use App\Context\Country\Infrastructure\Exceptions\RestApiConnectException;
use App\Context\Country\Infrastructure\RestCountriesRepository;
use Psr\Http\Message\ResponseInterface;

/**
 * @OA\Info(
 *     title="Freepik Challenge API",
 *     version="1.0"
 * )
 */

class CountryController
{
    /**
     * @OA\Get(
     *      path="/country-check",
     *      tags={"Country"},
     *      @OA\Parameter(
     *          name="code",
     *          in="query",
     *          required=true,
     *          description="Country code to search by",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *         response="200",
     *         description="The country Criteria"
     *      )
     * )
     */

    public function checkCountry(ResponseInterface $response, $code): ResponseInterface
    {
        try {
            $countryChecker = new CountryChecker(new RestCountriesRepository());
            $result = $countryChecker->__invoke(new CountryCode($code));

            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (InvalidTypeException | InvalidLengthException | NotFoundException $e) {
            $response->getBody()->write($e->getMessage());
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (RestApiConnectException $e) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus($e->getCode());
        }
    }
}