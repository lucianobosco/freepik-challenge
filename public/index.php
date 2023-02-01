<?php

use App\Context\Country\Infrastructure\CountryController;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Create a new container for dependency injection
$container = new Container();
$app = SlimAppFactory::create($container);

$app->get('/country-check/{code}', [CountryController::class, 'checkCountry']);
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();