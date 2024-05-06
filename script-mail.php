<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/vendor/autoload.php';

$mail = new PHPMailer(true);

try{
    // Recuperation des donnees

    $sql = new mysqli('localhost','mit','123456','mit') or die("Erreur de connexion");
    
    $request = "select distinct ip,user,id_machine,grade,niveau,nom,prenoms,type,date from session 
    right join dhcp on hostname = ip and session.date like '".date('Y-m-d',time())."%' and type = 'opened' 
    left join machine_etudiants on id_machine_etudiant = id_machine 
    inner join inscription on machine_etudiants.id_inscription = inscription.id_inscription 
    inner join etudiants on etudiants.id_etudiant = inscription.id_etudiant 
    inner join personnes on personnes.id_personne = etudiants.id_personne ";

    $table = $sql->query($request);

    $r1 = mysqli_fetch_assoc($sql->query($request."where inscription.grade = 'L' and inscription.niveau = 1 and session.type is NULL"));
    $l1_nc = count(($r1 == null)? []: $r1);
    
    $r1 = mysqli_fetch_assoc($sql->query($request."where inscription.grade = 'L' and inscription.niveau = 2 and session.type is NULL"));
    $l2_nc = count(($r1 == null)? []: $r1);

    $r1 = mysqli_fetch_assoc($sql->query($request."where inscription.grade = 'L' and inscription.niveau = 3 and session.type is NULL"));
    $l3_nc = count(($r1 == null)? []: $r1);

    $r1 = mysqli_fetch_assoc($sql->query($request."where inscription.grade = 'L' and inscription.niveau = 1 and session.type is NULL"));
    $m1_nc = count(($r1 == null)? []: $r1);

    $r1 = mysqli_fetch_assoc($sql->query($request."where inscription.grade = 'L' and inscription.niveau = 2 and session.type is NULL"));
    $m2_nc = count(($r1 == null)? []: $r1);
    
    if($table == null) echo "null";

    $i = 1;
    
    $users[0]['name'] = "Nom";
    $users[0]['level'] = 'Niveau';
    $users[0]['ip'] = 'IP';
    $users[0]['status'] = 'Connexion';

    while($u = mysqli_fetch_assoc($table)){
        $users[$i]['name'] = $u['nom']." ".$u['prenoms'];
        $users[$i]['level'] = $u['grade'].$u['niveau'];
        $users[$i]['ip'] = $u['ip'];
        $users[$i]['status'] = ($u['type'] == null) ? 'Déconnecté' : 'Connecté'; 
        $i++;
    }

    $message = ''."<h4 style=\" margin: auto; padding: 1vw; width: 60%; border: 1px solid #040b47; text-align : center; \">Liste L1 non connectés : ".$l1_nc."</h4>";
    $message .= "<h4 style=\" margin: auto; padding: 1vw; width: 60%; border: 1px solid #040b47; text-align : center; \">Liste L2 non connectés : ".$l2_nc."</h4>";
    $message .= "<h4 style=\" margin: auto; padding: 1vw; width: 60%; border: 1px solid #040b47; text-align : center; \">Liste L3 non connectés : ".$l3_nc."</h4>";
    $message .= "<h4 style=\" margin: auto; padding: 1vw; width: 60%; border: 1px solid #040b47; text-align : center; \">Liste M1 non connectés : ".$m1_nc."</h4>";
    $message .= "<h4 style=\" margin: auto; padding: 1vw; width: 60%; border: 1px solid #040b47; text-align : center; \">Liste M2 non connectés : ".$m2_nc."</h4>";

    $message .= "<table style=\"width: 80%; text-align: center; margin: auto; margin-top: 3vh; border-collapse: collapse; border-spacing: 5vw; font-family: sans-serif\">";
    
    foreach($users as $index => $row):
        $color = ($index%2 == 0) ? "background-color: rgb(201, 204, 216);":"";
        if($index == 0){
            $message .= "<tr style=\"border: 1px solid #464141; background-color: #040b47; font-color = #ffffff;\">";
            $message .= "<th>".$users[$index]["name"]."</th>";
            $message .= "<th>".$users[$index]["level"]."</th>";
            $message .= "<th>".$users[$index]["ip"]."</th>";
            $message .= "<th>".$users[$index]["status"]."</th>";
            $message .= "</tr>";
        }
        else{
            $message .= "<tr style=\"border: 1px solid #464141; ".$color."\">";
            $message .= "<td>".$users[$index]["name"]."</td>";
            $message .= "<td>".$users[$index]["level"]."</td>";
            $message .= "<td>".$users[$index]["ip"]."</td>";
            $message .= "<td>".$users[$index]["status"]."</td>";
            $message .= "</tr>";
        }
    endforeach;

    $message .= "</table>";

    /// Config du Mail avec SMTP
    
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'mail.mit-ua.mg';
    $mail->Username = 'pranaivo@mit-ua.mg';
    $mail->Password = 'r2s4&2=7N@^q';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    /// Destinataire

    $mail->setFrom('pranaivo@mit-ua.mg');
    $mail->addReplyTo('pranaivo@mit-ua.mg');

    $mail->addAddress('pranaivo@mit-ua.mg');

    /// Rattacher un fichier

    $mail->isHTML(true);

    $mail->Subject = "Liste des connexions du ".date('Y-m-d',time());

    $mail->Body = ''.utf8_decode(''.$message);

    // Envoi du mail

    if (!$mail->send()) echo "Erreur d'envoi";
    // else $mail->send();

}
catch(Exception $exception){
    print_r($exception);
    echo "\nErreur";
}

?>
