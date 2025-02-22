<?php

namespace App\middlewares;

use App\interfaces\AuthenticateRouterMiddlewaresTypes;
use App\repository\AuthenticateUserAdapter;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Exception;

class AuthenticateRouterMiddlewares implements AuthenticateRouterMiddlewaresTypes
{
   private AuthenticateUserAdapter $authenticateUserAdapter;
   public function __construct(AuthenticateUserAdapter $authenticateUserAdapter)
   {
      $this->authenticateUserAdapter = $authenticateUserAdapter;
   }
   public function authenticate(Request $request, RequestHandlerInterface $handle)
   {
      try {
         $response_headear = $request->getHeader("token");
         if (empty($response_headear)) throw new Exception("Token inválido ou não informado");
         $token = $response_headear[0] ?? "";
         $response_authenticate = (array) $this->authenticateUserAdapter->validateToken($token);
         $idUser = (int) $response_authenticate["idUser"];
         if (empty($idUser)) throw new Exception("IdUser não econtrado.");
         $request = $request->withAttribute("idUser", $idUser);
         return $handle->handle($request);
      } catch (Exception $error) {
         $response = new Response();
         $response->getBody()->write(json_encode(["error" => $error->getMessage()]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }
   }
}
