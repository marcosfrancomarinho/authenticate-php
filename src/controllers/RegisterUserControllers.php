<?php

namespace App\controllers;

use App\interfaces\RegisterUserControllersTypes;
use App\interfaces\RegisterUserServicesTypes;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RegisterUserControllers implements RegisterUserControllersTypes
{
   private RegisterUserServicesTypes $registerUserServices;
   public function __construct(RegisterUserServicesTypes  $registerUserServices)
   {
      $this->registerUserServices = $registerUserServices;
   }
   function registerUser(Request $request, Response $response)
   {
      try {
         $body = $request->getBody()->getContents();
         $datas = json_decode($body, true);
         $name = $datas['name'];
         $email = $datas['email'];
         $password = $datas["password"];
         $id = $this->registerUserServices->add($name, $email, $password);
         $response->getBody()->write(json_encode([
            "id" => $id,
            "message" => "cadastro feito com sucesso"
         ]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(201);
      } catch (Exception $error) {
         $response->getBody()->write(json_encode(["error" => $error->getMessage()]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }
   }
}
