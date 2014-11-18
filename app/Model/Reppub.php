<?php
App::uses('AppModel', 'Model');
/**
 * Reppub Model
 *
 * @property Pub $Pub
 * @property User $User
 */
class Reppub extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Pub' => array(
			'className' => 'Pub',
			'foreignKey' => 'pub_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
