<?php

App::uses('AppModel', 'Model');


class Mission extends AppModel {

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public $hasMany = array(
        'Scan' => array(
            'className' => 'Scan',
            'foreignKey' => 'mission_id',
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
        'titre' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'Titre obligatoire.'
            )
        ),
        'description' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'Description obligatoire.'
            )),
        'client' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'minimum  un client'
            ),
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'Sa doit avoir que des chifres',
            )),
        'point/client' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'minimum  une point par client'
            ),
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'Sa doit avoir que des chifres',
            ),
        ),
        'date' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'Vous devez choisir une date.'
            )),
    );

    public function grapheMission($date1, $date2, $idMission) {
        return $this->query("SELECT count(*) as nb FROM `scans` WHERE `date_scan1` < '$date1' and `date_scan1` > '$date2' and `mission_id` = $idMission ");
    }

    public function detailsParMission($idMission) {
        return $this->query("SELECT scans.*, user.* FROM `scans` JOIN user ON user.id = scans.user_id WHERE `mission_id` = $idMission order by 	date_scan1 desc");
    }

}
