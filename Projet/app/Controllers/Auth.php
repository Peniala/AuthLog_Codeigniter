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

    public function connected($cond=0):string
    {
        $auth = new AuthLog();
	
        $session = [];
        $date = $this->request->getVar("date");
        if($date === null) $date = date("Y-m-d");

        $l = $this->request->getVar("level");
        $level = explode("i",$l);
        if(empty($l)) $level = ['',''];

        $user = $this->request->getVar("user");
        if($user === null) $user = "";

        $page = $this->request->getVar("page");
        if($page === null) $page = 1;

        $session = [ 
            'date' => $date,
            'user' => $user,
            'page' => $page,
            'level' => $l,
            'session' => ($cond==0) ? $auth->like('inscription.grade',$level[0])->like('inscription.niveau',$level[1])->like('session.user',$user)->getConnected($date)->paginate(10) : $auth->getConnected($date)->findAll(),
            // 'session' => $auth->getConnected($date)->findAll(),
            'pager' => $auth->getConnected($date)->pager,
	        'cond' => $cond		
	];

        for($i=0 ; $i<count($session["session"]) ; $i++)
        {
            $session["session"][$i]["status"] = "connected";
        }

        return view('connected',$session);
    }

    public function actualize(){
        $h=(isset($_GET['hostname']))?$_GET['hostname']:null;
        $d=(isset($_GET['date']))?$_GET['date']:null;
        $t=(isset($_GET['type']))?$_GET['type']:null;
        $pr=(isset($_GET['process']))?$_GET['process']:null;
        $u=(isset($_GET['user']))?$_GET['user']:null;
        $p=(isset($_GET['page']))?$_GET['page']:1;

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
            'Apr'=>'04',
            'May'=>'05',
            'Jun'=>'06',
            'Jul'=>'07',
            'Aug'=>'08',
            'Sep'=>'09',
            'Oct'=>'10',
            'Nov'=>'11',
            'Des'=>'12',
        );

        while($line=fgets($all)){
            $year=date('Y',time());
            $moisDate=date('m',time());
            if(strstr($line,"session closed") || strstr($line,"session opened")){
                sscanf($line,"%[^ ] %[^ ] %[^ ] %[^ ] %[^:]: %*[^ ] session %[^ ] for user %[^\n]",$mois,$jour,$heure,$hostname,$process,$typeSession,$user);
                if(strcmp($typeSession,"opened")==0){
                    $tmp=explode("(",$user);
                    $user=$tmp[0];
                }

                if(strcmp($mois,"Dec")==0 && strcmp($moisDate,"Jan")==0){
                    $year--;
                }
                
                $data[$i]=array(
                    'date'=>$year."-".$numMois[$mois]."-0".$jour." ".$heure,
                    'hostname'=>$hostname,
                    'process'=>$process,
                    'type'=>$typeSession,
                    'user'=>$user,
                );	
                
                if($data[$i]['date'] > $lastDate && $data[$i]['user']!="root" && $data[$i]['user']!="gdm"){
                    $auth->insert($data[$i]);
                }    

                $i++;
            }
        }
        fclose($all);
        $page = $this->request->getVar("p");
        if($page == null) $page = "Auth";

        if(isset($page)) return redirect()->to($page."?date=".$d."&hostname=".$h."&type=".$t."&process=".$pr."&user=".$u."&page=".$p);
        else return redirect()->to($page);

    }
    public function export($cond):string{
	
        //generation de l'html a exporter
        
        $start="<table>";
        $end="</table>";	
        
        $width="table{width:90%;height:auto;cellpadding : 5px;}";
        $css="<style>".file_get_contents("./style.css").$width."</style>";
            
        $str=($cond==0)?$this->index():$this->connected(0);

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
