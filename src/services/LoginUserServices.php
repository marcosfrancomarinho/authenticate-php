<?php

namespace App\services;

use App\interfaces\LoginUserServicesTypes;
use App\interfaces\SearchUserAdapterTypes;
use Exception;

class LoginUserServices implements LoginUserServicesTypes
{
   private SearchUserAdapterTypes $searchUserAdapter;
   private  $message_error = "Email ou Senha Inválida!";

   function __construct(SearchUserAdapterTypes $searchUserAdapter)
   {
      $this->searchUserAdapter = $searchUserAdapter;
   }
   function login(string $email, string $password): int
   {
      try {
         $response_db =  $this->searchUserAdapter->select($email, $password);
         if (!$response_db) throw new Exception($this->message_error);

         $password_crypt = $response_db["password"];
         $id = $response_db["id"];

         $response_verify_password = password_verify($password, $password_crypt);
         if (!$response_verify_password) throw new Exception($this->message_error);
         
         return $id;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
}
