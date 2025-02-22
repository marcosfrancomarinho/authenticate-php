<?php

namespace App\controllers;

use App\interfaces\AuthenticateUserControllersType;
use App\repository\SearchUserAdapter;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthenticateUserControllers implements AuthenticateUserControllersType
{
   private SearchUserAdapter $searchUserAdapter;
   public function __construct(SearchUserAdapter $searchUserAdapter)
   {
      $this->searchUserAdapter = $searchUserAdapter;
   }
   public function execute(Request $request, Response $response)
   {
      $idUser = $request->getAttribute("idUser");
      $response_user = json_encode($this->searchUserAdapter->selectId($idUser));
      $response->getBody()->write($response_user);
      return $response->withHeader("Content-Type", "application/json")->withStatus(200);
   }
}
