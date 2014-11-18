<?php

App::uses('AppController', 'Controller');


class ChoixesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('questionjson');
    }

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile"){
            return false;
        }if($user['role_user'] == "admin") {
                return true;
        }else {
            if ($user['role_user'] == "vendeur" && ($this->action === 'getname') ) {
                return true;
            }else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }
    //function qui m'envoie le nom du choix 
    function getname($id)
    {
        $this->Choix->recursive = -1;
        $user=$this->Choix->findById($id);
        return $user['Choix']['choix'];
    }

}
