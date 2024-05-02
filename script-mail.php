<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try{

    $sql = new mysqli('localhost','mit','123456','mit');
    
    $table = $sql->query("select distinct s.hostname from session right join dhcp on s.hostname = d.ip where date like '".date('Y-m-d',time())."%'");

    while($u = mysqli_fetch_assoc($table)){
        $users[]['name'] = $u['hostname'];
        // $users[]['level'] = $u['level'];
        $users[]['status'] = ($u)'connected'; 
    }

    print_r($users);
    /// Config
    
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'mail.mit-ua.mg';
    $mail->Username = 'pranaivo@mit-ua.mg';
    $mail->Password = 'r2s4&2=7N@^q';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    /// Destinataire

    $mail->setFrom('pranaivo@mit-ua.mg');
    //$mail->addReplyTo('pranaivo@mit-ua.mg','Peniala');

    $mail->addAddress('arakotoarijaona@mit-ua.mg');

    /// Rattacher un fichier

    $mail->Subject = "Test 3 SendMail";

    $mail->Body = "Envoie du mail reussi";

    $mail->addAttachment("./auth.php");

    /// Envoi du mail

    // $mail->send();

}
catch(Exception $exception){
    echo "Erreur";
}

?>