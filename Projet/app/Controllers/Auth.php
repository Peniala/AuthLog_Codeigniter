<?php

namespace App\Controllers;
use App\Models\AuthLog;
use App\Controllers\UserController;

class Auth extends BaseController
{
    // private $s;
    // public function __construct() {
    //     $this->s = new \App\Controllers\UserController();
    // }
    public function index($cond=0){
        // $this->s->accueil();

        ////////////// Session utilisateur /////////////////

        $s = \Config\Services::session();
        $data = $s->get('UserConnecter');
        if($data == null) return redirect()->to('/');

        ////////////////////////////////////////////////////
        
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
            // 'session' => $auth->getList()->like("date",$date)->like("hostname",$hostname)->like("process",$process)->like("type",$type)->groupStart()->like("nom",$user)->orLike("prenoms",$user)->groupEnd()->orderBy("date")->paginate(10),
            'session' =>($cond==0) ? $auth->like("date",$date)->like("hostname",$hostname)->like("process",$process)->like("type",$type)->like("COALESCE(CONCAT(personnes.nom,' ',personnes.prenoms),'unknown')",$user)->getList()->orderBy('date')->paginate(9):$auth->like("date",$date)->like("hostname",$hostname)->like("process",$process)->like("type",$type)->like("COALESCE(CONCAT(personnes.nom,' ',personnes.prenoms),'unknown')",$user)->getList()->orderBy('date')->findAll(),
	    'cond' => $cond,	
            'pager' => $auth->pager
        ];

        return view('view',$session);
    }

    public function connected($cond=0):string
    {
        ////////////// Session utilisateur /////////////////

        $s = \Config\Services::session();
        $data = $s->get('UserConnecter');
        if($data == null) return redirect()->to('/');

        ////////////////////////////////////////////////////

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
            'session' => ($cond==0) ? $auth->like('inscription.grade',$level[0])->like('inscription.niveau',$level[1])->groupStart()->like('personnes.nom',$user)->orlike('personnes.prenoms',$user)->groupEnd()->getConnected($date)->paginate(10) : $auth->getConnected($date)->findAll(),
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
        $l=(isset($_GET['level']))?$_GET['level']:null;
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

        // echo $lastDate;

        while($line=fgets($all)){
            $year=date('Y',time());
            $moisDate=date('m',time());
            if(strstr($line,"session closed") || strstr($line,"session opened")){
                sscanf($line,"%[^ ] %[^ ] %[^ ] %[^ ] %[^:]: %*[^ ] session %[^ ] for user %[^\n]",$mois,$jour,$heure,$hostname,$process,$typeSession,$user);
                if(strcmp($typeSession,"opened")==0){
                    $tmp=explode(" ",$user);
                    $user=explode("(",$tmp[0])[0];
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
                // echo $data[$i]['date'].' '.$user.' <br>';
                
                if($data[$i]['date'] > $lastDate && $data[$i]['user']!="root" && $data[$i]['user']!="gdm"){
                    $auth->insert($data[$i]);
                    
                    // print_r($data[$i])."<br>";
                }    

                $i++;
            }
        }
        fclose($all);

        $page = $this->request->getVar("p");
        if($page == null) $page = "Auth";

        /// ovaina fa misy erreur

        echo $page;
        if(isset($page)){
            if($page == 'Dashboard') return redirect()->to($page."?date=".$d);
            else  if($page == '/Connected') return redirect()->to($page."?date=".$d."&level=".$l."&user=".$u."&page=".$p);
            else return redirect()->to($page."?date=".$d."&hostname=".$h."&type=".$t."&process=".$pr."&user=".$u."&page=".$p);
        }
        else return redirect()->to($page);

    }
    public function export($cond):string{
	
        //generation de l'html a exporter
        
        $start="<table>";
        $end="</table>";	
        
        $width="table{width:90%;height:auto;cellpadding : 5px;} table td{padding:2px;}";
        $css="<style>".file_get_contents("./header.css").file_get_contents("./body.css").file_get_contents("./table.css").$width."</style>";
           
        if($cond == 0) $str = $this->index();
	else if ($cond == 3) $str = $this->index(1);
        else if($cond == 1) $str = $this->connected(0);
        else $str = $this->connected(1);

        $indStart=strpos($str,$start);
        $indEnd=strpos($str,$end);	

        $html=substr($str,$indStart,$indEnd-$indStart+strlen($end));

        $html = utf8_decode($html);
        file_put_contents("./tmp.html",$html.$css);
        
        // //generation du pdf
        
        shell_exec("rm output.pdf");
        shell_exec("wkhtmltopdf ".base_url()."tmp.html output.pdf");    

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment;filename=output.pdf");
        header("Content-Length: ".filesize("output.pdf"));    
    
        readfile("output.pdf");

         return $html.$css;
        //return "";
    }
    
    public function generateChart()
    {
        ////////////// Session utilisateur /////////////////

        $s = \Config\Services::session();
        $data = $s->get('UserConnecter');
        if($data == null) return redirect()->to('/');

        ////////////////////////////////////////////////////

        $auth = new AuthLog();
	
        $stat = [];
        $date = $this->request->getVar("date");
        if($date === null) $date = date("Y-m-d");

        $stat = [ 
            'date' => $date,
            'l1' => $auth->like('inscription.grade','L')->like('inscription.niveau','1')->getConnected($date)->findAll(),
            'l1_c' => $auth->like('inscription.grade','L')->like('inscription.niveau','1')->getConnected($date)->where('session.type','opened')->findAll(),
            'l2' => $auth->like('inscription.grade','L')->like('inscription.niveau','2')->getConnected($date)->findAll(),
            'l2_c' => $auth->like('inscription.grade','L')->like('inscription.niveau','2')->getConnected($date)->where('session.type','opened')->findAll(),
            'l3' => $auth->like('inscription.grade','L')->like('inscription.niveau','3')->getConnected($date)->findAll(),
            'l3_c' => $auth->like('inscription.grade','L')->like('inscription.niveau','3')->getConnected($date)->where('session.type','opened')->findAll(),
            'm1' => $auth->like('inscription.grade','M')->like('inscription.niveau','1')->getConnected($date)->findAll(),
            'm1_c' => $auth->like('inscription.grade','M')->like('inscription.niveau','1')->getConnected($date)->where('session.type','opened')->findAll(),
            'm2' => $auth->like('inscription.grade','M')->like('inscription.niveau','2')->getConnected($date)->findAll(),
            'm2_c' => $auth->like('inscription.grade','M')->like('inscription.niveau','2')->getConnected($date)->where('session.type','opened')->findAll(),
	    ];

        return view('chart',$stat);
    }
    
    public function personnalStat($index = 0)
    {
        ////////////// Session utilisateur /////////////////

        $s = \Config\Services::session();
        $data = $s->get('UserConnecter');
        if($data == null) return redirect()->to('/');

        ////////////////////////////////////////////////////

        $month = (int) $this->request->getVar("month");
        $year = (int) $this->request->getVar("year");
        $user = $this->request->getVar("user");

        $year += (int) (($month-1)/12);
        $month = $month%12;
        if($month == 0) $month = 12;

        $var = [
            "year" => (int) $year,
            "month" => (int) $month,
            "user" => $user,
            "index" => $index
        ];

        if($month == null) $month = date("m");
        if($year == null) $year = date("Y");
        if($user == null) return view("personnal_stat",$var);

        

        $date = $year."-".date("m",strtotime($year."-".$month));
        
        $model = new AuthLog();

        if($model->is_saved($user)) $data = $model->getConnected($date)->where("hostname",$user)->findAll();
        else $data = $model->like('date',$date)->where("hostname",$user)->findAll();

        $month = (int) $month;
        $year = (int) $year;
        $calendar = $this->generateCalendar($month,$year);
        $tab = $this->transformData($data);
        $this->mapCalendar($calendar,$tab);

        // print_r($data);

        if($model->is_saved($user)) $data = $model->getConnected("")->where("hostname",$user)->findAll();
        else $data = $model->like('date',"")->where("hostname",$user)->findAll();
        // $data = $model->getConnected("")->where("hostname",$user)->findAll();
        
        $var = [
            "year" => (int) $year,
            "month" => (int) $month,
            "user" => $user,
            "calendar" => $calendar,
            "tab" => $tab,
            "data" => $data,
            "index" => $index
        ];

        return view("personnal_stat",$var);
    }

    public function generateCalendar($month,$year)
    {
        $time = mktime(0,0,0,$month,1,$year);
        $today = explode(" ",date("d m Y"));
        $ref = [
            "Mon" => 0,
            "Tue" => 1,
            "Wed" => 2,
            "Thu" => 3,
            "Fri" => 4,
            "Sat" => 5,
            "Sun" => 6
        ];
        
        $day = date("D",$time);
        $daysNumber = (int) date("t",$time);
        $firstDay = $ref[$day];
        $lastDay = ($ref[$day]+$daysNumber-1)%7;
        
        $calendar = [];
        $calendar["startSpace"] = $firstDay;
        
        $week = [];
        $day = [];
        $d = $firstDay;
        for($i=1 ; $i<=$daysNumber ; $i++,$d++){
            if($d%7 === 0){
                $calendar["body"][] = $week;
                $week = [];
            }
            $day["value"] = $i;
            $day["state"] = 0;
            if($year == $today[2] && $month == $today[1] && $i == $today[0]) $day["state"] = 2;
            $week[] = $day;
        }
        $calendar["body"][] = $week;
        $calendar["endSpace"] = 6 - $lastDay;

        return $calendar;
    }

    public function transformData($data){
        $tab = [];
        foreach($data as $item){
            $date = explode(" ",$item["date"])[0];
            $day = (int) explode("-",$date)[2];
            $tab[$day] = 1;
        }
        return $tab;
    }

    public function mapCalendar(&$calendar,$data){
        foreach($calendar["body"] as &$week){
            foreach($week as &$day){
                if(isset($data[$day["value"]]) && $day["state"] != 2) $day["state"] = 1;
            }
        }
    }

    public function exportCalendar():string{
        //generation de l'html a exporter
        
        $start="<section class=\"container\">";
        $end="</section>";	
        
        $css="<head><style>".file_get_contents("./stat_pdf.css")."</style></head>";
        
        $str=$this->personnalStat(1);

        $indStart=strpos($str,$start);
        $indEnd=strpos($str,$end);	

        $html=substr($str,$indStart,$indEnd-$indStart+strlen($end));

        $pdf = "<html>".$css."<body>".$html."</body>"."</html>";
        $pdf = utf8_decode($pdf);

        file_put_contents("./tmp.html",$pdf);
        
        // //generation du pdf
        
        shell_exec("rm output.pdf");
        shell_exec("wkhtmltopdf ".base_url()."tmp.html output.pdf");    

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment;filename=output.pdf");
        header("Content-Length: ".filesize("output.pdf"));    
    
        readfile("output.pdf");

        //  return $html.$css;
        return "";
    }


    public function exportChart():string{
        //generation de l'html a exporter
       
        /// css
        $css="<head><style>".file_get_contents("./chart.css")."</style></head>";

        /// html
        $start="<section class=\"center charts\">";
        $end="</section>";	
        
        $str=$this->generateChart();

        $indStart=strpos($str,$start);
        $indEnd=strpos($str,$end);	

        $html=substr($str,$indStart,$indEnd-$indStart+strlen($end));

        /// js

        $start="<script>";
        $end="</script>";	
        
        $str=$this->generateChart();

        $indStart=strpos($str,$start);
        $indEnd=strpos($str,$end);	

        $js=substr($str,$indStart,$indEnd-$indStart+strlen($end));

        $js = "<script src=\"../chart.js-4.4.2/package/dist/chart.umd.js\">".$js;

        $pdf = "<html>".$css."<body>".$html.$js."</body>"."</html>";
        $pdf = utf8_decode($pdf);

        file_put_contents("./tmp.html",$pdf);
        
        // //generation du pdf
        
        shell_exec("rm output.pdf");
        shell_exec("wkhtmltopdf http://projet.mit/tmp.html output.pdf");    

        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment;filename=output.pdf");
        header("Content-Length: ".filesize("output.pdf"));    
    
        readfile("output.pdf");

        //  return $html.$css;
        return "";
    }
}   
