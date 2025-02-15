<?php

namespace App\interfaces;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

interface RegisterUserControllersTypes
{
   function registerUser(Request $request, Response $response);
}
