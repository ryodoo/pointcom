<?php

class Magasin extends AppModel {

    public $useTable = 'magasin';
    public $primaryKey = 'id_magasin';
    public $hasMany = array('MagasinHasMission');

    public function liste(){
         return $this->query("SELECT Magasin.*, User.nom, User.prenom, User.email FROM Magasin JOIN User ON Magasin._id_user=User.id_user");
    }

     public function miens(){
        // echo "SELECT magasin.*, (select count(*) from magasin_has_mission mhm where mhm.`_id_magasin` = magasin.id_magasin) as nb_offres, (select count(*) from scan_qr where _id_mission in (select _id_mission from magasin_has_mission mhm where mhm._id_magasin = magasin.id_magasin)) as nb_clients FROM magasin where _id_user = $this->Session->read('Auth.User.id_user')"; exit();
         //SELECT magasin.*, (select count(*) from magasin_has_mission mhm where mhm.`_id_magasin` = magasin.id_magasin) as nb_offres, (select count(*) from scan_qr where _id_mission in (select _id_mission from magasin_has_mission mhm where mhm._id_magasin = magasin.id_magasin)) as nb_clients FROM magasin where _id_user = $idUser
         return $this->query("SELECT magasin.*, (select count(*) from mission where mission._id_magasin = magasin.id_magasin) as nb_offres, (select count(*) from scan_qr where _id_mission in (select id_mission from mission where mission._id_magasin = magasin.id_magasin)) as nb_clients FROM magasin where _id_user = $idUser");
    }

    public function magasinById($id){
         return $this->query("SELECT * FROM Magasin WHERE id_magasin = $id");
    }

}
