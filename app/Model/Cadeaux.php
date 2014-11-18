<?php

class Cadeaux extends AppModel {

    public $useTable = 'cadeaux';
    public $primaryKey = 'id_cadeaux';
    public $hasMany = array(
    'UserHasCadeaux' => array(
    'className' => 'UserHasCadeaux',
    'foreignKey' => 'id_cadeaux',
    'dependent'=> true,
    )
    );

     public $validate = array(
        'label_cadeau' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'le Label est requis'
            )
        ),
        'dateExpiration' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'la date d\'expiration est un champ obligatoire'
            )
        )
    );

     public function liste(){
         return $this->query("SELECT * FROM cadeaux");
     }

     public function getCadeau($id){
          return $this->query("SELECT * FROM cadeaux where id_cadeaux = $id");
     }
      public function maxid(){
	return $this->query("SELECT max(id_cadeaux) as max FROM cadeaux");
      }

      public function getUser($idUser){
	return $this->query("SELECT id, nom, prenom,point, email From User where id=$idUser");
      }

}
