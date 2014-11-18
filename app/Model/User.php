<?php

App::uses('AppModel', 'Model');

class User extends AppModel {

    public $useTable = 'user';
    public $primaryKey = 'id';
    public $name = 'User';
    public $hasMany = array(
        'Change' => array(
            'className' => 'Change',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Jaime' => array(
            'className' => 'Jaime',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Mission' => array(
            'className' => 'Mission',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Pag' => array(
            'className' => 'Pag',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Paiement' => array(
            'className' => 'Paiement',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Questionnaire' => array(
            'className' => 'Questionnaire',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Recharge' => array(
            'className' => 'Recharge',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Repense' => array(
            'className' => 'Repense',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Scan' => array(
            'className' => 'Scan',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => array('email'),
                'message' => 'email invalide'
            ),
            'login' => array(
                'rule' => 'isUnique',
                'message' => 'Email existe déja.'
            ),
        ),
        'password' => array(
            'required' => array(
                'rule' => array('between', 5, 15),
                'message' => 'Le mot de passe doit avoir une longueur comprise entre 5 et 15 caractères.'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'vendeur', 'mobile')),
                'message' => 'Merci de rentrer un rôle valide',
                'allowEmpty' => false
            )
        ),
        'nom_complet' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Entre votre nom et prenom',
            ),
        ),
        'ville' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Entre votre ville',
            ),
        ),
        'adresse' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Entre votre adresse',
            ),
        ),
        'age' => array(
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'L\'âge doit avoir que des chifres',
            ),
            'mot_passe' => array(
                'rule' => array('between', 2, 2),
                'message' => 'L\'âge doit être compris entre 15 et 99 ans.'
            ),
        ),
        'tel' => array(
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'Le telephone doit avoir que des chifres',
            ),
            'mot_passe' => array(
                'rule' => array('between', 10, 10),
                'message' => 'Le telephone doit avoir une longueur de 10 chifres.'
            ),
        ),
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    public function paiementNb() {
        return $this->query("SELECT count(*) as  nb from paiements where admin_id = 0 and avatar != '' ");
    }

    public function newUsers() {
        $today = date("Y-m-d H:i:s", time());
        $avant1 = strtotime($today) - 86400;
        $avant = date("Y-m-d H:i:s", $avant1);
        return $this->query("SELECT * from user where created >= '$avant' and (role_user = 'vendeur' or role_user = 'mobile') ");
    }

    public function lastVisits($idUser, $limit = 10) {
        return $this->query("SELECT scan.*, mission.points_par_user, mission.code_QR1, mission.code_QR2, magasin.nom_mag, magasin.id_magasin FROM scan_qr scan JOIN mission ON scan._id_mission=mission.id_mission JOIN magasin ON magasin.id_magasin=mission._id_magasin WHERE scan.id_user = $idUser order by date_scan1 desc LIMIT $limit");
    }

    public function pointsGagnes($idUser, $today, $yesterday) {
        return $this->query("SELECT sum(point_offre) as nb from scan_qr JOIN mission ON mission.id_mission = scan_qr._id_mission where date_scan1 > '$yesterday' and date_scan1 <= '$today' and id_user = $idUser");
    }

    public function pointsCadeauxGagnes($idUser, $today, $yesterday) {
        return $this->query("SELECT sum(point_cadeau) as nb from cadeaux JOIN user_has_cadeaux ON cadeaux.id_cadeaux = user_has_cadeaux.id_cadeaux where user_has_cadeaux.created > '$yesterday' and user_has_cadeaux.created <= '$today' and user_has_cadeaux.id_user = $idUser and etat != 2");
    }

}
