<?php

namespace App\interfaces;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

interface AuthenticateUserControllersType
{
   function execute(Request $request, Response $response);
}
