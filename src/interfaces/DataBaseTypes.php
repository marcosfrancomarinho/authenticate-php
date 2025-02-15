<?php

namespace App\interfaces;

use PDO;

interface DataBaseTypes
{
   function  connection(): PDO;
}
