<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\routers\Router;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

Router::registerRoutes($app);


$app->run();
