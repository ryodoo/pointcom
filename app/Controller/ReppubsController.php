<?php
App::uses('AppController', 'Controller');

class ReppubsController extends AppController 
{
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getrepense');
    }
    function getrepense($data=null) {
        //$data="9_5-3";
        //$data=$_POST['repense'];
        $data=  explode("_", $data);
        $user_id=$data[0];
        for($i=1;$i<=count($data)-1;$i++) 
        {
            $info=explode("-", $data[$i]);
            //Test si déja vous avez rependre a ce questionnaire
            $exist=$this->Reppub->find('count',array('conditions'=>array('Reppub.user_id'=>$user_id,'Reppub.pub_id'=>$info[0])));
            if($exist!=0)
            {
                echo "Erreur, vous avez déja fais ce questionnaire!!";
                exit();
            }
            $this->Reppub->create();
            $d['Reppub']['user_id']=$user_id;
            $d['Reppub']['choix']=$info[1];
            $d['Reppub']['pub_id']=$info[0];
            $this->Reppub->save($d);
        }
        $question =$this->Reppub->Pub->findById($info[0]);
        $this->Reppub->Pub->id=$question['Pub']['id'];
        $this->Reppub->Pub->saveField('reste', ($question['Pub']['reste']-1));
         $this->Reppub->User->recursive = -1;
        $user =$this->Reppub->User->findById($user_id);
        $this->Reppub->User->id=$user_id;
        $this->Reppub->User->saveField('point', $user['User']['point']+$question['Pub']['point/user']);
        echo "Merci,Vous avez gangez : ".$question['Pub']['point/user'].' Points';
        exit();
    }
}
