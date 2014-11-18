<?php
App::uses('AppController', 'Controller');

class RechargesController extends AppController {

   public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('cadeau','view','rachargesformobile');
   }

   public function isAuthorized($user)
   {
        if($user['role_user'] == "mobile" )
        {
            if ($this->action === 'view' || $this->action === 'index')
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
    public function index($type=null) {
        $this->Recharge->recursive = 0;
        if(AuthComponent::user('role_user')=='admin')
        {
            if($type!=null)
            {
                if($type=='1')
                    $annonces=$this->paginate(array('Recharge.user_id is null'));
                else 
                    $annonces=$this->paginate(array('Recharge.user_id is not null'));
            }
            else
                $annonces=$this->paginate();
            $this->set('recharges',$annonces );
        }
        else
        {
            $annonces=$this->paginate(array('Recharge.user_id'=>$this->Auth->user('id')));
            $this->set('recharges',$annonces );
        }
    }

    function view($id)
    {
        $this->Recharge->recursive = -1;
        $recharge=$this->Recharge->findById($id);
        $this->set('recharge', $recharge);
    }




    public function add() {
        if ($this->request->is('post'))
        {
            $this->Recharge->create();
            $this->request->data['Recharge']['hachage']=rand(1, 40);
            $this->request->data['Recharge']['hachage+']=$this->request->data['Recharge']['hachage']*$this->request->data['Recharge']['hachage+']-$this->request->data['Recharge']['hachage'];
            $this->request->data['Recharge']['recharge']=9*$this->request->data['Recharge']['hachage']*$this->request->data['Recharge']['hachage+'];
            
            if ($this->Recharge->save($this->request->data)) {
                $this->Session->setFlash(__(' Recharge Ajouter'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__(' Recharge ne veux pas s\'ajouter a la base?'));
            }
        }
    }

    public function edit($id = null)
    {
        $this->Recharge->id = $id;
        if (!$this->Recharge->exists()) {
            throw new NotFoundException(__('Invalide recharge'));
        }
        if ($this->request->is('post') || $this->request->is('put'))
        {
            $this->request->data['Recharge']['hachage']=rand(1, 40);
            $this->request->data['Recharge']['hachage+']=$this->request->data['Recharge']['hachage']*$this->request->data['Recharge']['hachage+']-$this->request->data['Recharge']['hachage'];
            $this->request->data['Recharge']['recharge']=9*$this->request->data['Recharge']['hachage']*$this->request->data['Recharge']['hachage+'];
            
            if ($this->Recharge->save($this->request->data)) {
                $this->Session->setFlash(__('The recharge Modifier'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Erreur a chef.'));
            }
        } else {
            $this->request->data = $this->Recharge->read(null, $id);
        }
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
        $this->Recharge->id = $id;
        if (!$this->Recharge->exists()) {
            throw new NotFoundException(__('Invalid recharge'));
        }
        if ($this->Recharge->delete()) {
            $this->Session->setFlash(__('Recharge deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Recharge was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    function cadeau($type=null)
    {
         $this->Recharge->recursive = -1;
         $cadeau=$this->Recharge->find('all', array('group' => 'point,operateur'));
         if($type!=null)
         {
             $array_info[] = array('id'=>$cadeau['Recharge']['id'],'point' => $cadeau['Recharge']['point']
                 , 'prix'=>$cadeau['Recharge']['prix'],'operateur'=>$cadeau['Recharge']['operateur'],
                 'image'=>"http://myblan.com/img/cadeaux/".$cadeau['Recharge']['operateur'].'_'.$cadeau['Recharge']['prix'].'jpg'
             );
           $json=json_encode($array_info);
           exit();
         }
         $this->set('cads', $cadeau);
    }

    //for Iphone
    function rachargesformobile($tel=null)
    {
         $this->Recharge->recursive = -1;
         $recharges=$this->Recharge->find('all', array('group' => 'point,operateur'));
         
         if($tel!=null)
             echo '[';
         else
         {
             header("Content-type: text/xml");
            echo '<recharges>
                ';
         }
         foreach ($recharges as $recharge)
         {
             if($tel!=null)
             {
                 echo '{
                        "idrecharge":"'.$recharge['Recharge']['id'].'",
                        "titre":"Recharge '.$recharge['Recharge']['prix'].' DH",
                        "operateur":"'.$recharge['Recharge']['operateur'].'",
                        "point":"'.$recharge['Recharge']['point'].'",
                        "dh":"'.$recharge['Recharge']['prix'].'"
                        },
                      ';
             }
             else
             {
                 echo '
                    <recharge>
                        <idrecharge>'.$recharge['Recharge']['id'].'</idrecharge>
                        <titre>Recharge '.$recharge['Recharge']['prix'].' DH</titre>
                        <operateur>'.$recharge['Recharge']['operateur'].'</operateur>
                        <point>'.$recharge['Recharge']['point'].'</point>
                        <dh>'.$recharge['Recharge']['prix'].'</dh>
                    </recharge>
                    ';
             }
         }
          if($tel!=null)
             echo ']';
         else
            echo '
                </recharges>';
         exit();
    }
}
