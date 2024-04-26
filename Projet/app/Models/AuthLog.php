<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthLog extends Model
{
    protected $table = "session";
    protected $primarykey = "id";
    protected $allowedFields = ["id","date","hostname","process","type","user"];
   
}