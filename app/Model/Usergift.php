<?php

class Usergift extends AppModel {

    public $useTable = 'user_has_cadeaux';
    public $belongsTo = array('Recharge','User'=> array(
                'className' => 'User',
                'foreignKey' => 'id_user',
                'dependent'=> true),
                'Cadeaux' => array(
                'className' => 'Cadeaux',
                'foreignKey' => 'id_cadeaux',
                'dependent'=> true),
        
        );
    


    public function miens($idUser){
         return $this->query("SELECT uhc.id, uhc.created, uhc.etat, cadeaux.* FROM user_has_cadeaux uhc JOIN cadeaux ON cadeaux.id_cadeaux = uhc.id_cadeaux WHERE uhc.id_user = $idUser order by uhc.created desc");
    }

    public function miens2($idUser){
         return $this->query("SELECT uhc.id, uhc.created, uhc.etat, cadeaux.* FROM user_has_cadeaux uhc JOIN cadeaux ON cadeaux.id_cadeaux = uhc.id_cadeaux WHERE uhc.id_user = $idUser and uhc.etat not in (2,-1) order by uhc.created desc");
    }

    public function enCours(){
         return $this->query("SELECT uhc.id, uhc.created, uhc.etat, cadeaux.*, user.id, user.nom_complet FROM user_has_cadeaux uhc JOIN user ON uhc.id_user = user.id JOIN cadeaux ON cadeaux.id_cadeaux = uhc.id_cadeaux where uhc.etat = 0 order by cadeaux.id_cadeaux, uhc.created desc");
    }
}
