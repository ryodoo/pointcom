<?php

App::uses('AppModel', 'Model');

class Questionnaire extends AppModel {

    public $displayField = 'name';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Entre votre nom et prenom',
            ),
        ),
        'image' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'L\'image est obligatoire.',
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
    public $hasMany = array(
        'Question' => array(
            'className' => 'Question',
            'foreignKey' => 'questionnaire_id',
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

}
