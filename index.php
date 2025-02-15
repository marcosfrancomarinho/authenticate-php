<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\routers\Router;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;

$app = AppFactory::create();

$options_cors = [
   "origin" => ["*"],
   "methods" => ["POST"],
   "headers.allow" => ["Authorization", "Content-Type", "X-Requested-With"],
   "headers.expose" => [],
   "credentials" => true,
];
$app->add(new CorsMiddleware($options_cors));
Router::registerRoutes($app);


$app->run();
