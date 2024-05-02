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
        $sub = "(select user from session where date like '".$date."%' and type = 'opened') t";
        $this->db->table('session');
        $this->builder()->distinct()->select('t.user')->from($sub);
        return $this;
        
        //$this->select([
        //    'session.ip',
        //    'session.user',
        //    'session.id_machine',
        //    'session.grade',
        //    'session.niveau',
        //    'session.nom',
        //    'session.prenoms',
        //    'session.type',
        //    'session.date'
        //]);

        //$this->rightJoin('dhcp', 'dhcp.hostname = session.ip AND session.date LIKE "'.date('Y-m-d', time()).'% AND session.type = \'opened\'');
        //$this->leftJoin('machine_etudiants', 'machine_etudiants.id_machine_etudiant = session.id_machine');
        //$this->innerJoin('inscription', 'machine_etudiants.id_inscription = inscription.id_inscription');
        //$this->innerJoin('etudiants', 'etudiants.id_etudiant = inscription.id_etudiant');
        //$this->innerJoin('personnes', 'personnes.id_personne = etudiants.id_personne');

        //$query = $this->getCompiledSelect();

        //return $query->getResult();
    }
}
