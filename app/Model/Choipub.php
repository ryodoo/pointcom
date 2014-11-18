<?php
App::uses('AppModel', 'Model');
/**
 * Choipub Model
 *
 * @property Pub $Pub
 */
class Choipub extends AppModel {

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
		)
	);
}
