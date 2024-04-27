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

    public function actualize(){

        $all=fopen("/var/log/auth.log","r");
        $data=[];
        $i=0;

        $auth = new AuthLog();

        $lastDate = $auth->selectMax('date')->get()->getResultArray()[0]['date'];

        if(empty($lastDate) || $lastDate == null){
            $lastDate="2000-01-10 00:00:00";
        }

        $numMois=array(
            'Jan'=>'01',
            'Feb'=>'02',
            'Mar'=>'03',
            'Apr'=>'04',
            'Mey'=>'05',
            'Jon'=>'06',
            'Jol'=>'07',
            'Aog'=>'08',
            'Sep'=>'09',
            'Okt'=>'10',
            'Nov'=>'11',
            'Dec'=>'12',
        );

        while($line=fgets($all)){
            $year=date('Y',time());
            if(strstr($line,"session closed") || strstr($line,"session opened")){
                sscanf($line,"%[^ ] %[^ ] %[^ ] %[^ ] %[^:]: %*[^ ] session %[^ ] for user %[^\n]",$mois,$jour,$heure,$hostname,$process,$typeSession,$user);
                if(strcmp($typeSession,"opened")==0){
                    $tmp=explode(" ",$user);
                    $user=$tmp[0];
                }

                if(strcmp($mois,"Dec")==0 && strcmp($moisDate,"Jan")==0){
                    $year--;
                }
                
                $data[$i]=array(
                    'date'=>$year."-".$numMois[$mois]."-".$jour." ".$heure,
                    'hostname'=>$hostname,
                    'process'=>$process,
                    'type'=>$typeSession,
                    'user'=>$user,
                );	
                
                if($data[$i]['date'] > $lastDate){
                    $auth->insert($data[$i]);
                }    

                $i++;
            }
        }
        fclose($all);

        return redirect()->to('Auth/');
    }
}
