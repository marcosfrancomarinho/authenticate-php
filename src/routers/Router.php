<?php

namespace App\routers;

use App\config\DataBase;
use App\controllers\AuthenticateUserControllers;
use App\controllers\LoginUserControllers;
use App\controllers\RegisterUserControllers;
use App\controllers\VerifyDatasLoginControllers;
use App\controllers\VerifyDatasRegisterControllers;
use App\interfaces\AuthenticateRouterMiddlewaresTypes;
use App\interfaces\AuthenticateUserAdapterTypes;
use App\interfaces\AuthenticateUserControllersType;
use App\interfaces\DataBaseTypes;
use App\interfaces\InsertUserAdapterTypes;
use App\interfaces\LoginUserControllersTypes;
use App\interfaces\LoginUserServicesTypes;
use App\interfaces\RegisterUserControllersTypes;
use App\interfaces\RegisterUserServicesTypes;
use App\interfaces\SearchUserAdapterTypes;
use App\middlewares\AuthenticateRouterMiddlewares;
use App\repository\AuthenticateUserAdapter;
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
   private static AuthenticateUserAdapterTypes $authenticateUserAdapter;
   private static AuthenticateRouterMiddlewaresTypes $authenticateRouterMiddlewares;
   private static AuthenticateUserControllersType $authenticateUserControllers;

   private static function init()
   {
      self::$database = new DataBase();
      self::$insertUserAdapter = new InsertUserAdapter(self::$database);
      self::$searchUserAdapter = new SearchUserAdapter(self::$database);
      self::$authenticateUserAdapter = new AuthenticateUserAdapter();
      self::$registerUserServices = new RegisterUserServices(self::$insertUserAdapter);
      self::$loginUserServices = new LoginUserServices(self::$searchUserAdapter);
      self::$registerUserControllers = new RegisterUserControllers(self::$registerUserServices);
      self::$loginUserControllers = new LoginUserControllers(self::$loginUserServices, self::$authenticateUserAdapter);
      self::$registerUserControllers = new VerifyDatasRegisterControllers(self::$registerUserControllers);
      self::$loginUserControllers = new VerifyDatasLoginControllers(self::$loginUserControllers);
      self::$authenticateUserControllers = new AuthenticateUserControllers(self::$searchUserAdapter);
      self::$authenticateRouterMiddlewares = new AuthenticateRouterMiddlewares(self::$authenticateUserAdapter);
   }


   public static function allRouters(App $app)
   {
      self::init();
      $app->post("/register", [self::$registerUserControllers, "registerUser"]);
      $app->post("/login", [self::$loginUserControllers, "loginUser"]);
      $app->get(
         "/authenticate",
         [self::$authenticateUserControllers, "execute"]
      )->add([self::$authenticateRouterMiddlewares, "authenticate"]);
   }
}
