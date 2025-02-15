<?php

namespace App\routers;

use App\config\DataBase;
use App\controllers\LoginUserControllers;
use App\controllers\RegisterUserControllers;
use App\controllers\VerifyDatasLoginControllers;
use App\controllers\VerifyDatasRegisterControllers;
use App\interfaces\DataBaseTypes;
use App\interfaces\InsertUserAdapterTypes;
use App\interfaces\LoginUserControllersTypes;
use App\interfaces\LoginUserServicesTypes;
use App\interfaces\RegisterUserControllersTypes;
use App\interfaces\RegisterUserServicesTypes;
use App\interfaces\SearchUserAdapterTypes;
use App\repository\InsertUserAdapter;
use App\repository\SearchUserAdapter;
use App\services\LoginUserServices;
use App\services\RegisterUserServices;
use Slim\App;


class Router
{
   private static DataBaseTypes $database;
   private static InsertUserAdapterTypes $insertUserAdapter;
   private static RegisterUserServicesTypes $registerUserServices;
   private static RegisterUserControllersTypes $registerUserControllers;
   private static SearchUserAdapterTypes $searchUserAdapter;
   private static LoginUserServicesTypes $loginUserServices;
   private static LoginUserControllersTypes $loginUserControllers;

   private static function init()
   {
      self::$database = new DataBase();
      self::$insertUserAdapter = new InsertUserAdapter(self::$database);
      self::$searchUserAdapter = new SearchUserAdapter(self::$database);
      self::$registerUserServices = new RegisterUserServices(self::$insertUserAdapter);
      self::$loginUserServices = new LoginUserServices(self::$searchUserAdapter);
      self::$registerUserControllers = new RegisterUserControllers(self::$registerUserServices);
      self::$loginUserControllers = new LoginUserControllers(self::$loginUserServices);
      self::$registerUserControllers = new VerifyDatasRegisterControllers(self::$registerUserControllers);
      self::$loginUserControllers = new VerifyDatasLoginControllers(self::$loginUserControllers);
   }


   public static function registerRoutes(App $app)
   {
      self::init();
      $app->post("/register", [self::$registerUserControllers, "registerUser"]);
      $app->post("/login", [self::$loginUserControllers, "loginUser"]);
   }
}
