<?php
App::uses('AppModel', 'Model');
/**
 * Paiement Model
 *
 * @property Personne $Personne
 */
class Paiement extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'paiements';
	
	public $belongsTo = 'User';
        
        public $validate = array(
        'nom' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'Lien obligatoire.'
            )
        ),
        'prix' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'minimum  un client'
            ),
            'maxlength' => array(
                'rule' => array('numeric'),
                'message' => 'Sa doit avoir que des chifres',
            )),
        'point' => array(
            'required' => array(
                'rule' => array('notempty'),
                'message' => 'minimum  une point par client'
                ),
            )
        );
	public function maxid(){
		return $this->query("SELECT max(id) as max FROM paiements");
         }

	
	
}
