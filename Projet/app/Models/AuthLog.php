<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthLog extends Model
{
    protected $table = "session";
    protected $primarykey = "id";
    protected $allowedFields = ["id","date","hostname","process","type","user"];
    
    public function getConnected()
    {
        $this->db->select('*')->distinct();
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}