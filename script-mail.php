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
    inner join personnes on personnes.id_personne = etudiants.id_personne";

    $table = $sql->query($request);
    
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
   
    print_r($users);

    /// Creation du fichier csv

    $f = __DIR__.'/connexion.csv';
    $file = fopen($f, 'w');
    
    foreach ($users as $row) {
        fputcsv($file, $row);
    }

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

    $mail->Subject = "Liste des connexions du ".date('Y-m-d',time());

    $mail->Body = "Monsieur, Voici le fichier joint qui contient la liste des connexions à ce jour.";

    $mail->addAttachment($f);

    // Envoi du mail

    if (!$mail->send()) echo "Erreur d'envoi";
    else $mail->send();

    fclose($file);

}
catch(Exception $exception){
    print_r($exception);
    echo "\nErreur";
}

?>
