<?php

namespace App\repository;

use App\interfaces\DataBaseTypes;
use App\interfaces\InsertUserAdapterTypes;
use Exception;
use PDO;

class InsertUserAdapter implements InsertUserAdapterTypes
{
   private DataBaseTypes $database;

   public function __construct(DataBaseTypes $database)
   {
      $this->database = $database;
   }
   public function create(string $name, string $email, string $password): int
   {
      try {
         $password_crypt = password_hash($password, PASSWORD_DEFAULT);
         $sql =  $this->database->connection()->prepare(
            "INSERT INTO
               register_user
            (name, email, password)
               VALUES
            ( :name, :email, :password) RETURNING (id);"
         );
         $sql->bindParam(":name", $name, PDO::PARAM_STR);
         $sql->bindParam(":email", $email, PDO::PARAM_STR);
         $sql->bindParam(":password", $password_crypt, PDO::PARAM_STR);
         $sql->execute();
         $datas = $sql->fetch(PDO::FETCH_ASSOC);
         $id = $datas["id"];
         return $id;
      } catch (Exception $error) {
         throw new Exception($error->getMessage());
      }
   }
}
