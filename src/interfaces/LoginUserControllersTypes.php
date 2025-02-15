<?php

namespace App\interfaces;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

interface LoginUserControllersTypes
{
   function loginUser(Request $request, Response $response);
}
