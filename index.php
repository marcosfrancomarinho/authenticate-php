<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\routers\Router;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;

$app = AppFactory::create();

$options_cors = [
   "origin" => ["*"],
   "methods" => ["GET", "POST"],
   "headers.allow" => ["Authorization", "Content-Type", "X-Requested-With", "token"],
   "headers.expose" => ["token"],
   "credentials" => true,
];

$app->add(new CorsMiddleware($options_cors));

Router::allRouters($app);

$app->run();
