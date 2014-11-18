<?php
App::uses('AppModel', 'Model');
/**
 * Pag Model
 *
 * @property User $User
 * @property Jaime $Jaime
 */
class Pag extends AppModel {

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Jaime' => array(
			'className' => 'Jaime',
			'foreignKey' => 'pag_id',
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
        'lien' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'Lien obligatoire.'
            )
        ),
        'user' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'minimum  un client'
            ),
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'Sa doit avoir que des chifres',
            )),
        'point/user' => array(
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

}
