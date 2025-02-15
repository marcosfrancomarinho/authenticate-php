<?php

namespace App\controllers;

use App\interfaces\LoginUserControllersTypes;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class VerifyDatasLoginControllers implements LoginUserControllersTypes
{
   private LoginUserControllersTypes $loginUserControllers;
   private $message_error = [
      "email" => "email inválido",
      "password" => "senha inválida, defina uma senha de 8 carateres"
   ];
   public function __construct(LoginUserControllersTypes $loginUserControllers)
   {
      $this->loginUserControllers = $loginUserControllers;
   }
   public function loginUser(Request $request, Response $response)
   {
      try {
         $body = $request->getBody()->getContents();
         $datas = json_decode($body, true);

         $email = $datas['email'] ?? "";
         $password = $datas["password"] ?? "";

         $regex_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
         $regex_password = "/^[a-zA-Z0-9]{8,10}$/";

         if (!preg_match($regex_email, $email)) throw new Exception($this->message_error["email"]);
         if (!preg_match($regex_password, $password)) throw new Exception($this->message_error["password"]);
         
         return $this->loginUserControllers->loginUser($request, $response);
      } catch (Exception $error) {
         $response->getBody()->write(json_encode(["error" => $error->getMessage()]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }
   }
}
