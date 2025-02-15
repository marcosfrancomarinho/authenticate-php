<?php

namespace App\interfaces;

interface RegisterUserServicesTypes
{
   function add(string $name, string $email, string $password): int;
}
