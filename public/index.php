<?php

use App\Context\Country\Infrastructure\CountryController;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Create a new container for dependency injection
$container = new Container();
$app = SlimAppFactory::create($container);

// Routes
$app->get('/country-check/{code}', [CountryController::class, 'checkCountry']);
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

// Add Routing Middleware
$app->addRoutingMiddleware();

// Force errorHandler to return json content type
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

$app->run();