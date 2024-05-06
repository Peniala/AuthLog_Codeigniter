<?php

    $all=fopen("/var/log/auth.log","r");
    $data=[];
    $i=0;
    
    $flux=new mysqli("localhost","faneva","123456","project");
    $query="select max(date) as max from session";

    $lastDate=mysqli_fetch_assoc($flux->query($query))['max'];
    if(empty($lastDate)){
        $lastDate="2000-01-10 00:00:00";
    }

    $numMois=array(
        'Jan'=>'01',
        'Feb'=>'02',
        'Mar'=>'03',
        'Apr'=>'04',
        'Mey'=>'05','May'=>'05',
        'Jon'=>'06','Jun'=>'06',
        'Jol'=>'07','Jul'=>'07',
        'Aog'=>'08','Aug'=>'08',
        'Sep'=>'09',
        'Okt'=>'10','Oct'=>'10',
        'Nov'=>'11',
        'Dec'=>'12',
    );

    while($line=fgets($all)){
        $year=date('Y',time());
        if(strstr($line,"session closed") || strstr($line,"session opened")){
            sscanf($line,"%[^ ] %[^ ] %[^ ] %[^ ] %[^:]: %*[^ ] session %[^ ] for user %[^\n]",$mois,$jour,$heure,$hostname,$process,$typeSession,$user);
            if(strcmp($typeSession,"opened")==0){
                $tmp=explode(" ",$user);
                $user=explode("(",$tmp[0]);
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

            //echo $year;
            
            if($data[$i]['date'] > $lastDate && $data[$i]['user']!="root" && $data[$i]['user']!="gdm"){
                echo $lastDate."\t";
		echo $data[$i]['date']."\n";
		        $query="insert into session (date,hostname,process,type,user) values ('".$data[$i]['date']."','".$data[$i]['hostname']."','".$data[$i]['process']."','".$data[$i]['type']."','".$data[$i]['user']."')";
                //echo $query."\n";
                $flux->query($query);
            }    

            $i++;
        }
    }

    $flux->close();
?>
