<?php

App::uses('AppController', 'Controller');

class ChoipubsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getpubs');
    }
    
    public function isAuthorized($user) {
        if($user['role_user'] == "mobile"){
            return false;
        }if($user['role_user'] == "admin") {
                return true;
        }else {
            if ($user['role_user'] == "vendeur" && ($this->action === 'getchoises' || $this->action === 'del') ) {
                return true;
            }else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }
    
    
    public function del($pub_id = null) {
        $pubs=$this->Choipub->Pub->findById($pub_id);
        if($pubs['Pub']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier La mission ');
            $this->redirect(array('controller'=>'pubs','action' => 'index'));
        }
        foreach ($pubs['Choipub'] as $value) 
        {
            $this->Choipub->id=$value['id'];
            $this->Choipub->delete();
        }
        $this->Session->setFlash(__('La question est bien modifier'));
        $this->redirect(array('controller'=>'pubs','action' => 'edit',$pub_id));
    }
    function getpubs()
    {
        $date=  date('Y-m-d');
        $mobile_id=$_POST["id_mobile"];
        //$mobile_id=22;
        $this->loadModel('User');
        $user=$this->User->findByIdMobile($mobile_id);
        if(empty($user))
        {
            $this->User->create();
            $d['User']['id_mobile']=$mobile_id;
            $d['User']['role_user']='mobile';
            $this->User->save($d);
            $user=$this->User->findByIdMobile($mobile_id);
        }
        $pubs=$this->Choipub->Pub->find('all',array('conditions'=>array("Pub.reste>0","Pub.date<='$date'")));
        echo '[';
        foreach ($pubs as $pub) 
        {
            $exist=0;
            foreach ($pub['Reppub'] as $jaime) 
            {
                if($jaime['user_id']==$user['User']['id'])
                {
                    $exist++;
                    break;
                }
            }
            if($exist==0 && ($user['User']['sexe']==$pub['Pub']['sexe'] || $pub['Pub']['sexe']=="tous"))
            {
                $age=  explode(',', $pub['Pub']['tranche']);
                if($user['User']['age']===null)
                    $user['User']['age']=11;
                $tranche=  explode('-', $age[1]);
                if($user['User']['age']>=$tranche[0] && $user['User']['age']<=$tranche[1] )
                {
                    $ville=  explode(',', $pub['Pub']['ville']);
                    $ok=0;
                    for($i=1;$i<count($ville);$i++)
                    {
                        if($user['User']['ville']==$ville[$i] || $ville[$i]=='tous' )
                        {
                            $passer=$pub['Pub']['user']-$pub['Pub']['reste'];
                            $choixid1 = $choixid2 = $choixid3 = $choixid4 = $choixid5 = 'null';
                            $choix1 = $choix2 = $choix3 = $choix4 = $choix5 = 'null';
                            if (isset($pub['Choipub'][0]['id'])) {
                                $choixid1 = $pub['Choipub'][0]['id'];
                                $choix1 = $pub['Choipub'][0]['choix'];
                            }
                            if (isset($pub['Choipub'][1]['id'])) {
                                $choixid2 = $pub['Choipub'][1]['id'];
                                $choix2 = $pub['Choipub'][1]['choix'];
                            }
                            if (isset($pub['Choipub'][2]['id'])) {
                                $choixid3 = $pub['Choipub'][02]['id'];
                                $choix3 = $pub['Choipub'][2]['choix'];
                            }
                            if (isset($pub['Choipub'][3]['id'])) {
                                $choixid4 = $pub['Choipub'][3]['id'];
                                $choix4 = $pub['Choipub'][3]['choix'];
                            }
                            if (isset($pub['Choipub'][4]['id'])) {
                                $choixid5 = $pub['Choipub'][4]['id'];
                                $choix5 = $pub['Choipub'][4]['choix'];
                            }
                            echo '{
                                    "id": "'.$pub['Pub']['id'].'",
                                    "question": "'.$pub['Pub']['question'].'",
                                    "questionimage": "'.$pub['Pub']['image'].'",
                                    "point": "'.$pub['Pub']['point/user'].'",
                                    "image":"http://myblan.com/img/pub/mobile/'.$pub['Pub']['image'].'",
                                    "type": "'.$pub['Pub']['type'].'",
                                    "nbvisite": "'.$passer.'",
                                    "nbvisitetotatal": "'.$pub['Pub']['user'].'",
                                            "repense1id": "'.$choixid1.'",
                                    "repense1": "'.$choix1.'",
                                            "repense2id": "'.$choixid2.'",
                                    "repense2": "'.$choix2.'",
                                            "repense3id": "'.$choixid3.'",
                                    "repense3": "'.$choix3.'",
                                            "repense4id": "'.$choixid4.'",
                                    "repense4": "'.$choix4.'",
                                            "repense5id": "'.$choixid5.'",
                                    "repense5": "'.$choix5.'",
                                    "image": "'.$pub['Pub']['image'].'"
                                   },';
                            $ok++;
                            break;
                        }
                    }
                }
            }
        }
        echo "{}]";
        exit();
    }
    
    
    //fonction qui me retourn la listes des choix d'un seul pub pour les statistique 
    function getchoises($pub_id)
    {
        $this->Choipub->recursive = -1;
        $user=$this->Choipub->find('all',array('conditions'=>array('Choipub.pub_id'=>$pub_id)));
        return $user;
    }
}
