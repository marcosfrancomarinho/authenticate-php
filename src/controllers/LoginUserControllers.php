<?php

namespace App\controllers;

use App\interfaces\AuthenticateUserAdapterTypes;
use App\interfaces\LoginUserControllersTypes;
use App\services\LoginUserServices;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LoginUserControllers implements LoginUserControllersTypes
{
   private LoginUserServices $loginUserServices;
   private AuthenticateUserAdapterTypes $authenticateUserAdapter;
   public function __construct(LoginUserServices $loginUserServices, AuthenticateUserAdapterTypes $authenticateUserAdapter)
   {
      $this->loginUserServices = $loginUserServices;
      $this->authenticateUserAdapter = $authenticateUserAdapter;
   }

   function loginUser(Request $request, Response $response)
   {
      try {
         $body = $request->getBody()->getContents();
         $datas = json_decode($body, true);

         $email = $datas['email'];
         $password = $datas["password"];

         $id = $this->loginUserServices->login($email, $password);
         $token = $this->authenticateUserAdapter->genereteToken($id);
         
         $response->getBody()->write(json_encode([
            "id" => $id,
            "message" => "login feito com sucesso"
         ]));

         return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200)
            ->withAddedHeader("token", $token);
      } catch (Exception $error) {
         $response->getBody()->write(json_encode(["error" => $error->getMessage()]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }
   }
}
