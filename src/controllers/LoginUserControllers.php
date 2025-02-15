<?php

namespace App\controllers;

use App\interfaces\LoginUserControllersTypes;
use App\services\LoginUserServices;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class LoginUserControllers implements LoginUserControllersTypes
{
   private LoginUserServices $loginUserServices;

   public function __construct(LoginUserServices $loginUserServices)
   {
      $this->loginUserServices = $loginUserServices;
   }

   function loginUser(Request $request, Response $response)
   {
      try {
         $body = $request->getBody()->getContents();
         $datas = json_decode($body, true);
         $email = $datas['email'];
         $password = $datas["password"];
         $id = $this->loginUserServices->login($email, $password);
         $response->getBody()->write(json_encode([
            "id" => $id,
            "message" => "login feito com sucesso"
         ]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(200);
      } catch (Exception $error) {
         $response->getBody()->write(json_encode(["error" => $error->getMessage()]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }
   }
}
