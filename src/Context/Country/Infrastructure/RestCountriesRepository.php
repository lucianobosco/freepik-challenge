<?php

declare(strict_types=1);

namespace App\Context\Country\Infrastructure;

use App\Context\Country\Domain\Country;
use App\Context\Country\Domain\CountryCode;
use App\Context\Country\Domain\CountryName;
use App\Context\Country\Domain\CountryPopulation;
use App\Context\Country\Domain\CountryRegion;
use App\Context\Country\Domain\CountryRepository;
use App\Context\Country\Infrastructure\Exceptions\NotFoundException;
use App\Context\Country\Infrastructure\Exceptions\RestApiConnectException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;

class RestCountriesRepository implements CountryRepository
{
    public function getByCode(CountryCode $code): ?Country
    {
        try {
            $codeValue = $code->value();

            $client = new Client([
                'base_uri' => "https://restcountries.com/v3.1/",
                'timeout'  => 30,
            ]);

            $response = $client->request('GET', 'alpha', [
                'query' => ['codes' => $codeValue]
            ]);

            $content = $response->getBody()->getContents();
            $country = json_decode($content)[0];

            return new Country(
                new CountryName($country->name->common),
                new CountryCode($country->cca2),
                new CountryRegion($country->region),
                new CountryPopulation($country->population)
            );
        } catch (ClientException $th) {
            throw new NotFoundException("Country with code \"$codeValue\" does not exist.");
        } catch (ConnectException $th) {
            throw new RestApiConnectException("Unable to connect to restcountries.com.");
        }
    }
}