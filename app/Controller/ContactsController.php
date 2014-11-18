<?php
App::uses('AppController', 'Controller');
/**
 * Contacts Controller
 *
 * @property Contact $Contact
 */
class ContactsController extends AppController {


 public function isAuthorized($user) {
        if($user['role_user'] != "admin") {
            if ($this->action === 'list' ) {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index');
    }
    public function liste() {
        $this->Contact->recursive = 0;
        $this->set('contacts', $this->paginate());
    }



    public function index() {
        if ($this->request->is('post')) {
            $this->Contact->create();
            if ($this->Contact->save($this->request->data)) {
                $this->Session->setFlash(__('Merci. Votre message a été bien envoyé.'));
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail();
                $Email->to("4goodmaroc@gmail.com");
                $Email->from("contact@myblan.com");
                $Email->subject('Nouveau contact ');
                $Email->send("Bonjour,Quel q'un nous a contacter
                    nom : ".$this->request->data['Contact']['nom']."Tel : ".$this->request->data['Contact']['telephone']
                        ." Message : ".$this->request->data['Contact']['message']
                        );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Erreur de navigation'));
            }
        }
    }

    
}
