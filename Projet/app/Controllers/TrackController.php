<?php
namespace App\Controllers;
use App\Models\TrackModels;
use App\Models\UserModel;


class TrackController extends BaseController {
  private $trackModel;
  private $userModel;
  public function __construct(){
    $this->trackModel = new TrackModels();
  }
  public function track_change(string $tableName, string $action) {
    $session = \Config\Services::session();
    $sessionData = $session->get('UserConnecter');
    $now = date('Y-m-d H:i:s', now());
    $data = array('id' => $sessionData['id'], 'action' => $action, 'table_name' => $tableName, 'date' => $now);
    $this->trackModel->insertTrack($data);
  }

}
