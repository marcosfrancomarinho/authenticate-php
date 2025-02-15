<?php

namespace App\config;

use App\interfaces\DataBaseTypes;
use Dotenv\Dotenv;
use Exception;
use PDO;
use PDOException;

class DataBase implements DataBaseTypes
{
   private string $host;
   private string $database;
   private string $port;
   private string $username;
   private string $password;

   public function __construct()
   {
      Dotenv::createImmutable(dirname(__DIR__, 2))->load();
      $this->host = $_ENV["HOST_DB"] ?? getenv("HOST_DB");
      $this->database = $_ENV["DBNAME_DB"] ?? getenv("DBNAME_DB");
      $this->username = $_ENV["USER_DB"] ?? getenv("USER_DB");
      $this->password = $_ENV["PASSWORD_DB"] ?? getenv("PASSWORD_DB");
      $this->port = $_ENV["PORT_DB"] ?? getenv("PORT_DB");
   }

   public function connection(): PDO
   {
      try {
         $database = new PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->database}", $this->username, $this->password);
         return $database;
      } catch (PDOException $error) {
         throw new Exception($error->getMessage());
      }
   }
}
