<?php

namespace App\services;

use App\interfaces\RegisterUserServicesTypes;
use App\repository\InsertUserAdapter;
use Exception;

class RegisterUserServices implements RegisterUserServicesTypes
{
   private InsertUserAdapter $insertUserAdapter;

   public function __construct(InsertUserAdapter $insertUserAdapter)
   {
      $this->insertUserAdapter = $insertUserAdapter;
   }

   public function add(string $name, string $email, string $password): int
   {
      try {
         $id = $this->insertUserAdapter->create($name, $email, $password);
         return $id;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
}
