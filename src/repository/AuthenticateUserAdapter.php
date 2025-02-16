<?php

namespace App\repository;

use Firebase\JWT\JWT;
use App\interfaces\AuthenticateUserAdapterTypes;
use Dotenv\Dotenv;
use Exception;
use Firebase\JWT\Key;
use stdClass;


class AuthenticateUserAdapter implements AuthenticateUserAdapterTypes
{
   private string $KEY_SECRET;
   public function __construct()
   {
      // Dotenv::createImmutable(dirname(__DIR__, 2))->load();
      $this->KEY_SECRET = $_ENV["KEY_SECRET"] ?? getenv("KEY_SECRET");
   }
   public function genereteToken(int $id): string
   {
      try {
         $payload = [
            "iss" => "http://localhost:5173",
            "iat" => time(),
            "exp" => time(),
            "idUser" => $id
         ];
         if (!$this->KEY_SECRET) throw new Exception("KEY SECRET não informada");
         $token =  JWT::encode($payload, $this->KEY_SECRET, "HS256");
         return $token;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
   public function validateToken(string $token): stdClass
   {
      try {
         if (empty($token)) throw new Exception("Token inválido ou não informado.");
         $decode_content = JWT::decode($token, new Key($this->KEY_SECRET, "HS256"));
         return $decode_content;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
}