<?php

namespace App\interfaces;

interface LoginUserServicesTypes
{
   function login(string $email, string $password): int;
}
