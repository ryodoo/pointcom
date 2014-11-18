<?php
App::uses('AppController', 'Controller');
/**
 * Paiements Controller
 *
 * @property Paiement $Paiement
 */
class PaiementsController extends AppController {

    public function isAuthorized($user) {
        return true;
        if($user['role_user'] == "mobile") {
            return false;
        }
        if($user['role_user'] == "admin") {
            if ($this->action === 'modifier') {
                return true;
            }else return false;
        }else {
            if ($this->action === 'add' || $this->action === 'index') {
                return true;
            }else return false;
        }
        return parent::isAuthorized($user);
    }


    public function index($type=null) 
    {
        $this->Paiement->recursive = 0;
        if($this->Session->read('Auth.User.role_user')!= "admin")
            $this->set('paiements', $this->paginate('Paiement', array(
                'Paiement.user_id' => $this->Auth->user('id'))));
        else
        {
            if($type!=null)
                $paiements=$this->paginate('Paiement', array('Paiement.valide' => $type));

            else
                $paiements=$this->paginate();
            $this->set('paiements',$paiements );
        }

    }

    /**
     * add method
     *
     * @return void
     */
    public function add($prix=null) {
        //if($prix == null) return $this->redirect(array('action' => 'index'));
        if ($this->request->is('post'))
        {
            $this->Paiement->create();
            $ext = strtolower(pathinfo($this->request->data['Paiement']['avatar_file']['name'], PATHINFO_EXTENSION ));
            if(!empty($this->request->data['Paiement']['avatar_file']['tmp_name'])
                    && in_array($ext, array('jpeg', 'jpg', 'png')))
            {
                $data = $this->Paiement->maxid();
                $nomFile = $data[0][0]['max']+1;

                move_uploaded_file($this->request->data['Paiement']['avatar_file']['tmp_name'], IMAGES.'paiement'.DS.$nomFile.'.'.$ext);
                $this->request->data['Paiement']['motif']='en cour de validation';
                $this->request->data['Paiement']['valide']=0;
                $this->request->data['Paiement']['avatar']=$nomFile.'.'.$ext;
                $this->request->data['Paiement']['user_id']=AuthComponent::user('id');
                $this->Paiement->save($this->request->data);
                $this->Session->setFlash(__('Paiement bien enregistré !'));
                return $this->redirect(array('action' => 'index'));
            }
            else
            {
                if(!empty($this->request->data['Paiement']['avatar_file']['tmp_name']))
                {
                    $this->Session->setFlash('Vous ne pouvez pas envoyer ce type de fichier');
                }
                else
                    $this->Session->setFlash('Copie de reçue de paiement est obligatoire.');
            }
        }
    }


    public function view($id=null) {
        $paiement = $this->Paiement->findById($id);
        $this->set(compact('paiement'));
        if ($this->request->is('post')) 
        {
            $this->request->data['Paiement']['id'] = $this->request->data['paiement_id'];
            $this->request->data['Paiement']['admin_id'] = $this->Session->read('Auth.User.id');
            $this->request->data['Paiement']['valide']=1;
            $this->Paiement->save($this->request->data['Paiement']);
            $user=$this->Paiement->findById( $this->request->data['Paiement']['id']);
            $this->Paiement->User->save(array('id' => $user['User']['id'], 'point' => $user['User']['point']+$this->request->data['Paiement']['point']));
            $this->Session->setFlash('Paiement bien validé');
            return $this->redirect(array('action' => 'index'));
        }
    }
}
