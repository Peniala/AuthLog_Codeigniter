<?php

namespace App\Models;
use CodeIgniter\Model;

class Inscrits extends Model
{
    protected $table = "Inscrits";
    protected $primarykey = "id";
    protected $allowedFields = ['id','name',"first_name","date_birth","place_birth","address","mention"];

   
}