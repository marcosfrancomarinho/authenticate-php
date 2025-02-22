<?php

namespace App\repository;

use App\interfaces\DataBaseTypes;
use App\interfaces\SearchUserAdapterTypes;
use Exception;
use PDO;

class SearchUserAdapter implements SearchUserAdapterTypes
{
   private DataBaseTypes $database;

   public function __construct(DataBaseTypes $database)
   {
      $this->database = $database;
   }
   public function select(string $email, string $password): mixed
   {
      try {
         $sql =  $this->database->connection()->prepare("SELECT id, password FROM register_user WHERE email=:email");
         $sql->bindParam(":email", $email);
         $sql->execute();
         $response_query = $sql->fetch(PDO::FETCH_ASSOC);
         return $response_query;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
   public function selectId(int $id): mixed
   {
      try {
         $sql =  $this->database->connection()->prepare("SELECT name FROM register_user WHERE id=:id");
         $sql->bindParam(":id", $id);
         $sql->execute();
         $response_query = $sql->fetch(PDO::FETCH_ASSOC);
         return $response_query;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
}
