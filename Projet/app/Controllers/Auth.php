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

        return view('view',$session);
    }

    public function connected():string
    {
        $auth = new AuthLog();

        $session = [];
                    
        $date = $this->request->getVar("date");
        if($date === null) $date = date("Y-m-d");
        $user = $this->request->getVar("user");
        if($user === null) $user = "";

        $session = [ 
            'date' => $date,
            'user' => $user,
            'session' => $auth->getConnected($date)->paginate(10),
            'pager' => $auth->getConnected($date)->pager
        ];

        for($i=0 ; $i<count($session["session"]) ; $i++)
        {
            $session["session"][$i]["status"] = "connected";
        }

        return view('connected',$session);
    }

    public function actualize($p){

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
            $moisDate=date('m',time());
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
        $page = $this->request->getVar("page");
        if($page == null) $page = "Auth/";

        if(isset($p)) return redirect()->to($page."?page=".$p);
        else return redirect()->to($page);
    }
    public function export():string{
	
        //generation de l'html a exporter
        
        $start="<table>";
        $end="</table>";	
        
        $width="table{width:90%;height:70%;cellpadding : 5px;}";
        $css="<style>".file_get_contents("./style.css").$width."</style>";
            
        $str=$this->index();

        $indStart=strpos($str,$start);
        $indEnd=strpos($str,$end);	

        $html=substr($str,$indStart,$indEnd-$indStart+strlen($end));

        file_put_contents("./tmp.html",$html.$css);
        
        // //generation du pdf
        
        shell_exec("wkhtmltopdf http://projet.mit/tmp.html output.pdf");    

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment;filename=output.pdf");
        header("Content-Length: ".filesize("output.pdf"));    
    
        readfile("output.pdf");

         return $html.$css;
        //return "";
    }
}
