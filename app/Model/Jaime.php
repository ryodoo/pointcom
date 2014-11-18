<?php
App::uses('AppModel', 'Model');
/**
 * Jaime Model
 *
 * @property User $User
 * @property Pag $Pag
 */
class Jaime extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pag' => array(
			'className' => 'Pag',
			'foreignKey' => 'pag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
