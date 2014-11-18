<?php

App::uses('AppModel', 'Model');

/**
 * Contact Model
 *
 */
class Contact extends AppModel {

    /**
     * Use table
     *
     * @var mixed False or table name
     */
    public $useTable = 'contact';
    public $validate = array(
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'email invalide',
            ),
        ),
        'nom' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Entre votre nom et prenom',
            ),
        ),
        'telephone' => array(
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'Le telephone doit avoir que des chifres',
            ),
            'mot_passe' => array(
                'rule' => array('between', 10, 10),
                'message' => 'Le telephone doit avoir une longueur de 10 chifres.'
            ),
        ),
        'message' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Entre votre nom et prenom',
            ),
        ),
    );

}
