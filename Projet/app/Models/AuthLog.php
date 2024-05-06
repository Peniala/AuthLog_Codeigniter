<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthLog extends Model
{
    protected $table = "session";
    protected $primarykey = "id";
    protected $allowedFields = ["id","date","hostname","process","type","user"];

    public function getConnected($date)
    {
        // $sub = "(select user from session where date like '".$date."%' and type = 'opened') t";
        // $this->db->table('session');
        // $this->builder()->distinct()->select('t.user')->from($sub);
        // return $this;
        
        $this->builder()->distinct->select([
           'session.hostname',
           'session.user',
           'machine_etudiants.id_machine',
           'inscription.grade',
           'inscription.niveau',
           'personnes.nom',
           'personnes.prenoms',
           'session.type',
           'session.date'
        ]);

        $this->join('dhcp', "dhcp.ip = session.hostname AND session.date LIKE '".$date."%' AND session.type = 'opened'",'right');
        $this->join('machine_etudiants', 'machine_etudiants.id_machine = dhcp.id_machine_etudiant','left');
        $this->join('inscription', 'machine_etudiants.id_inscription = inscription.id_inscription','inner');
        $this->join('etudiants', 'etudiants.id_etudiant = inscription.id_etudiant','inner');
        $this->join('personnes', 'personnes.id_personne = etudiants.id_personne','inner');

    // $request = "select distinct ip,user,id_machine,grade,niveau,nom,prenoms,type,date from session 
    // right join dhcp on hostname = ip and session.date like '".date('Y-m-d',time())."%' and type = 'opened' 
    // left join machine_etudiants on id_machine_etudiant = id_machine 
    // inner join inscription on machine_etudiants.id_inscription = inscription.id_inscription 
    // inner join etudiants on etudiants.id_etudiant = inscription.id_etudiant 
    // inner join personnes on personnes.id_personne = etudiants.id_personne";

        return $this;
    }
}
