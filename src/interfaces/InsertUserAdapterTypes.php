<?php

namespace App\interfaces;

interface InsertUserAdapterTypes
{
   function create(string $name, string $email, string $password): int;
}
