<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthLog extends Model
{
    protected $table = "session";
    protected $primarykey = "id";
    protected $allowedFields = ["id","date","hostname","process","type","user"];

    public function getConnected($date)
    {
        $sub = "(select user from session where date like '".$date."%' and type = 'opened') t";
        $this->db->table('session');
        $this->builder()->distinct()->select('t.user')->from($sub);
        return $this;
    }
}