<?php
namespace App\interfaces;

use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Request;

interface AuthenticateRouterMiddlewaresTypes{
   function authenticate(Request $request, RequestHandlerInterface $handle);
}