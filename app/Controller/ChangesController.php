<?php
App::uses('AppController', 'Controller');
/**
 * Changes Controller
 *
 * @property Change $Change
 */
class ChangesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
   }

   public function isAuthorized($user)
   {
        if($user['role_user'] == "mobile" )
        {
            if ($this->action === 'miens'||$this->action === 'add')
                return true;
            else
                return false;
        }
        else
        {
            if($user['role_user'] == "admin")
                    return true;
        }
        return false;
    }
    
    public function index() {
        $this->Change->recursive = 0;
        $this->set('changes', $this->paginate());
    }

    public function miens($id=null)
    {
        if(!empty($id) || AuthComponent::user('role_user')!="admin")
        {
            $id=$this->Auth->user('id');
        }
        $this->Change->recursive = -1;
        $changes=$this->Change->find('all',array('conditions'=>array('Change.user_id'=>$id)));
        $this->set('changes', $changes);
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Change->id = $id;
        if (!$this->Change->exists()) {
            throw new NotFoundException(__('Invalid change'));
        }
        $this->set('change', $this->Change->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post'))
        {
            $this->Change->create();
            if($this->Session->read('Auth.User.point')<$this->request->data['Change']['point'])
            {
                $this->Session->setFlash(__('Vous n\'avez pas les points transmis'));
                $this->redirect(array('action' => 'add'));
            }
            $this->request->data['Change']['user_id']=$this->Auth->user('id');
            $this->request->data['Change']['prix']=$this->request->data['Change']['point']*1.65;
            if($this->request->data['Change']['point']>=300)
            {
                $this->Change->User->id=$this->Auth->user('id');
                $this->Change->User->saveField('point',$this->Session->read('Auth.User.point')-$this->request->data['Change']['point']);
                $this->Session->write('Auth.User.point',$this->Session->read('Auth.User.point')-$this->request->data['Change']['point']);
            }
            else
            {
                $this->Session->setFlash(__('Vous n\'avez pas arrivé au seuil du transmission. '));
                $this->redirect(array('action' => 'add'));
            }

            if ($this->Change->save($this->request->data)) {
                $this->Session->setFlash(__('Votre transaction est bien transmie,'));
                $this->redirect(array('action' => 'miens'));
            } else {
                $this->Session->setFlash(__('Erreur.'));
            }
        }
        $users = $this->Change->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Change->id = $id;
        if (!$this->Change->exists()) {
            throw new NotFoundException(__('Invalid change'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Change->save($this->request->data)) {
                $this->Session->setFlash(__('The change has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The change could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Change->read(null, $id);
        }
        $users = $this->Change->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Change->id = $id;
        if (!$this->Change->exists()) {
            throw new NotFoundException(__('Invalid change'));
        }
        if ($this->Change->delete()) {
            $this->Session->setFlash(__('Change deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Change was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
