<?php

namespace App\Controllers;
use App\Models\AuthLog;

class Connected extends BaseController
{
    public function index():string
    {
        $model = new AuthLog();
        return view('connected');
    }
}