<?php

namespace App\interfaces;

use stdClass;

interface AuthenticateUserAdapterTypes
{
   function genereteToken(int $id): string;
   function validateToken(string $token): stdClass;
}
