<?php 

namespace App\Models;

use CodeIgniter\Model;

class TrackModels extends Model {
  public $table = "track";
  public $allowedfields = ["id_personne","action","table_name","date"]; 
  public function getTrack() {
    return $this->findAll();
  }
  public function getTrackByID($id) {
    return $this->where('id_personne', $id)->get()->getResultArray();
  } 
  public function insertTrack($data) {
    return $this->insert($data);
  }
  
}
