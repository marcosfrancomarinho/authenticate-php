<?php

namespace App\controllers;

use App\interfaces\RegisterUserControllersTypes;
use Exception;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class VerifyDatasRegisterControllers implements RegisterUserControllersTypes
{
   private RegisterUserControllersTypes $registerUserControllers;
   private array $message_error = [
      "name" => "nome do usuário inválido",
      "email" => "email inválido.",
      "password" => "senha inválida, defina uma senha de 8 caracteres."
   ];

   public function __construct(RegisterUserControllersTypes $registerUserControllers)
   {
      $this->registerUserControllers = $registerUserControllers;
   }

   public function registerUser(Request $request, Response $response)
   {
      try {
         $body = $request->getBody()->getContents();
         $datas = json_decode($body, true);

         $name = $datas["name"] ?? "";
         $email = $datas["email"] ?? "";
         $password = $datas["password"] ?? "";

         $regex_name = "/^[A-Za-zÀ-ÖØ-öø-ÿ ]{2,50}$/";
         $regex_email = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
         $regex_password = "/^[a-zA-Z0-9]{8,10}$/";

         if (!preg_match($regex_name, $name)) {
            throw new Exception($this->message_error["name"]);
         }
         if (!preg_match($regex_email, $email)) {
            throw new Exception($this->message_error["email"]);
         }
         if (!preg_match($regex_password, $password)) {
            throw new Exception($this->message_error["password"]);
         }

         return $this->registerUserControllers->registerUser($request, $response);
      } catch (Exception $error) {
         $response->getBody()->write(json_encode(["error" => $error->getMessage()]));
         return $response->withHeader("Content-Type", "application/json")->withStatus(400);
      }
   }
}
