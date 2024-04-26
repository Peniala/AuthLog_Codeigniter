<?php

namespace App\Controllers;
use App\Models\AuthLog;

class Auth extends BaseController
{
    public function index(): string{
        $auth = new AuthLog();

        $session = [];
                    
        $date = $this->request->getVar("date");
        if($date === null) $date = "";
        $hostname = $this->request->getVar("hostname");
        if($hostname === null) $hostname = "";
        $process = $this->request->getVar("process");
        if($process === null) $process = "";
        $type = $this->request->getVar("type");
        if($type === null) $type = "";
        $user = $this->request->getVar("user");
        if($user === null) $user = "";

        $session = [ 
            'date' => $date,
            'hostname' => $hostname,
            'process' => $process,
            'type' => $type,
            'user' => $user,
            'session' => $auth->like("date",$date)->like("hostname",$hostname)->like("process",$process)->like("type",$type)->like("user",$user)->paginate(10),
            'pager' => $auth->pager
        ];

        return view('view.php',$session);
    }
}
