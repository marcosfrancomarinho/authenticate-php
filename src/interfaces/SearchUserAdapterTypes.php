<?php

namespace App\interfaces;

interface SearchUserAdapterTypes
{
   function select(string $email, string $password): mixed;
   function selectId(int $id): mixed;
}
