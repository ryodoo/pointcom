<?php

class UserHasCadeaux extends AppModel{
	
	public $useTable = 'user_has_cadeaux';
        public $primaryKey = 'id';
        public $belongsTo = array('user'=> array(
                                    'foreignKey' => 'id_user')
                                ,'cadeaux'=> array(
                                    'foreignKey' => 'id_cadeaux')
            );
        
	
}