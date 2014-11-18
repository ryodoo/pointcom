<?php
class UsergiftsController extends AppController {

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile") {
            if ($this->action === 'add' || $this->action === 'miens') {
                return true;
            }else return false;
        }else {
            if($user['role_user'] == "admin") {
                if ($this->action === 'liste') {
                    return true;
                }else return false;
            }else return false;
        }
        return false;
    }
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('addrecharge');
   }

    public function add($cadeau_id=null) 
    {
        $cad=$this->Usergift->Cadeaux->findByIdCadeaux($cadeau_id);
        if($cad['Cadeaux']['point_cadeau']>$this->Session->read('Auth.User.point')) {
            $this->Session->setFlash(__('Vous n\'avez pas suffisamment de points pour gagner ce cadeau '));
            return $this->redirect(array('controller' => 'cadeauxs', 'action' => 'liste'));
        }
        $this->Usergift->create();
        $this->request->data['Usergift']['id_user'] = $this->Session->read('Auth.User.id');
        $this->request->data['Usergift']['id_cadeaux']=$cadeau_id;
        $this->request->data['Usergift']['etat']=0;
        $this->request->data['Usergift']['point']=$cad['Cadeaux']['point_cadeau'];
        $this->Usergift->save($this->request->data);
        $this->Usergift->User->save(array("id" => $this->Session->read('Auth.User.id'), "point" =>($this->Session->read('Auth.User.point')- $cad['Cadeaux']['point_cadeau'])));
        $this->Session->write('Auth.User.point', ($this->Session->read('Auth.User.point')- $cad['Cadeaux']['point_cadeau']));
        $this->Session->setFlash('Le cadeau demander est reservé pour vous Filicitation');
        return $this->redirect(array('controller' => 'cadeauxs', 'action' => 'liste'));
    }

    public function liste($type=null) {
        if ($this->request->is('post'))
        {
            $this->Usergift->id=$this->request->data['Cadeaux']['idUhc'];
            $this->Usergift->saveField('etat', $this->request->data['Cadeaux']['etat']);
            $this->Usergift->saveField('message', $this->request->data['Cadeaux']['message']);
        }
        if($type==null)
            $type="0,1,2,-1";
        $gifts = $this->Usergift->find('all',array('conditions'=>array('Usergift.recharge_id is null',"Usergift.etat in($type)")));
        $this->set(compact('gifts'));
    }

    public function miens() {
        $gifts = $this->Usergift->miens($this->Session->read('Auth.User.id'));
        $this->set(compact('gifts'));
    }


    function addrecharge($id,$emmu=null,$user_id=null)//$user_id c'est emmu de tel qui envoie la requete
    {
        if($user_id==null || $emmu==null )
        {
            $iduser=$this->Session->read('Auth.User.id');
            $point=$this->Session->read('Auth.User.point');
            $user['User']['email']=$this->Session->read('Auth.User.email');
        }
        else
        {
            $iduser=$user_id;
            $this->loadModel('User');
            $this->User->recursive = -1;
            $user=$this->User->find("all",array('conditions'=>array('User.id'=> $user_id,'User.id_mobile'=>$emmu)));
            if(empty($user))
            {
                $array_info[] = array('envoi_msg'=>'Fatal Error 404');
                $json=json_encode($array_info);
                print($json);
                //echo 'erreur de navigation';
                exit ();
            }
            $point=$user[0]['User']['point'];
            $iduser=$user[0]['User']['id'];
        }
 
        $this->loadModel('Recharge');
        $re=$this->Recharge->findById($id);
        if($re['Recharge']['point']>$point)
        {
            $this->Session->setFlash(__('Vous n\'avez pas suffisamment de points pour gagner ce cadeau '));
            if($user_id!=null)
            {
                echo 'Vous n\'avez pas suffisamment de points pour gagner ce cadeau';
                exit();
            }
            return $this->redirect(array('controller' => 'recharges', 'action' => 'index'));
        }
        $recharge=$this->Recharge->find('first',array('conditions'=>
            array('Recharge.operateur'=>$re['Recharge']['operateur'],'Recharge.prix'=>$re['Recharge']['prix'],'Recharge.user_id is null')));
        if(empty ($recharge))
        {
            App::uses('CakeEmail', 'Network/Email');
            $Email = new CakeEmail();
            $Email->to("godsneek@hotmail.com");
            $Email->from('cadeau@myblan.com');
            $Email->subject('Stock sala de recherge id '.$id);
            $Email->send("Bonjour, stock sala de http://myblan.com/recharges/view/$id ");
            if($user_id!=null)
            {
                echo 'Stock épuisé redemander ce cadeau dans une heure';
                exit();
            }
            $this->Session->setFlash(__('Stock épuisé redemander ce cadeau dans une heure'));
            return $this->redirect(array('controller' => 'recharges', 'action' => 'cadeau'));
        }
        
        
        $this->Usergift->create();
        $this->request->data['Usergift']['id_user'] = $iduser;
        $this->request->data['Usergift']['recharge_id']=$id;
        $this->request->data['Usergift']['etat']=2;
        $this->request->data['Usergift']['point']=$recharge['Recharge']['point'];

        $this->Usergift->save($this->request->data);
        $this->Usergift->User->save(array("id" =>$iduser, "point" =>($point- $recharge['Recharge']['point'])));
        $this->Session->write('Auth.User.point', ($point-$recharge['Recharge']['point']));

        $this->Recharge->save(array("id" =>$recharge['Recharge']['id'], "user_id" =>$iduser));
        $this->Session->setFlash('La recharge demander a été envoyer a votre mail '.$user[0]['User']['email']);
        App::uses('CakeEmail', 'Network/Email');
        $Email = new CakeEmail();
        $Email->to($user[0]['User']['email']);
        $Email->from('cadeau@myblan.com');
        $Email->subject('Myblan : Recharge de  : '.$recharge['Recharge']['prix'].' DH de '.$recharge['Recharge']['operateur']);
        $code=($recharge['Recharge']['hachage+']+$recharge['Recharge']['hachage'])/$recharge['Recharge']['hachage'];

        $Email->send("Bonjour, voila le code de recharge : $code");
        if($user_id!=null)
        {
            echo 'La recharge demander a été envoyer a votre mail '.$user[0]['User']['email'];
            exit();
        }
        return $this->redirect(array('controller' => 'cadeauxs', 'action' => 'liste'));
    }


}
