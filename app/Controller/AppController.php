<?php


App::uses('Controller', 'Controller');


class AppController extends Controller {
     public $components = array('Session',
    'Auth' => array(
        'loginAction' => array(
            'controller' => 'users',
            'action' => 'login'
        ),
        'authorize' => array('Controller'),
        'authError' => 'Nom d\'user et  mot de passe svp!',
        'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email')
            )
        ),
        'loginRedirect' => array('controller' => 'users', 'action' => 'index')
        
     )
 );

   public function beforeFilter() {
       
       parent::beforeFilter();
   }

public function isAuthorized($user) {
    return true;
}

}
