<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model {
  protected $db;
  protected $builder;
  protected $table = 'personnes';
  protected $primaryKey = 'id_personne';
  protected $allowedFields = [
    'id_personne',
    'nom',
    'prenoms',
    'date_naissance',
    'lieu_naissance',
    'addresse',
    'CIN',
    'mail',
    'telephone',
    'genre',
    'nationalite',
    'id_statut'
  ];
  public function __construct() {
    $this->db = db_connect();
    $this->builder = $this->db->table($this->table); 
  }
  public function exist($n, $p) {
    $c = ['nom' => $n, 'prenoms' => $p];
    $count = $this->where($c)->countAllResults();
    return $count > 0;
  }
  public function getRelativeInfo($nom, $prenoms) {
    return $this->builder->select('id_personne, id_statut')->where(['nom'=> $nom, 'prenoms'=> $prenoms])->get()->getResultArray();
  }
}

