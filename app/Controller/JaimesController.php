<?php

App::uses('AppController', 'Controller');

/**
 * Jaimes Controller
 *
 * @property Jaime $Jaime
 */
class JaimesController extends AppController {

    
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getinfo');
    }
    
    
    //la fonction qui valide j'aime sur la page
    function getinfo()
    {
        $mobile_id=$_GET['mobile_id'];
        $token=$_GET['token'];
        $page_id=$_GET['page_id'];
//        $mobile_id=22;
//        $token="aa";
//        $page_id=2;
        $user=$this->Jaime->User->findByIdMobile($mobile_id);
        $count=$this->Jaime->find('count',array('conditions'=>array('Jaime.user_id'=>$user['User']['id'],'Jaime.Pag_id'=>$page_id)));
        if($count==0)
        {
            $this->Jaime->Pag->recursive = -1;
            $page=$this->Jaime->Pag->findById($page_id);
            $url="https://graph.facebook.com/me/likes/".$page['Pag']['fb_id']."?access_token=$token";
            //$url="https://graph.facebook.com/me/likes/386980914754832?access_token=CAALKG0VzdzoBAAOn149j9VPEa0BPKrQKpg0PZAcXgeX0n1MNYgYJ5jlkNkFx2h51DZBF6Dg85x0eXxZBGCl8xz1D6azYisTMD8FVhfrqJYNuvw5BtoAmVnmzpZB6IdIHMVVmIoC2lFUse8IFQdEnK0DEQ0z7tbbGuHPHZAQfpsKotokHvoBvBMgFzLng14ZAoPtaqBcNNg6Sh30AZAikKlC";
            $homepage = file_get_contents($url);
            if($homepage=='{"data":[]}')
                echo 'Vous n\'avez pas aimer la page, Merci de réessayer';
            else
            {
                $this->Jaime->create();
                $d['Jaime']['user_id']=$user['User']['id'];
                $d['Jaime']['pag_id']=$page_id;
                $this->Jaime->save($d);
                $page=$this->Jaime->Pag->findById($page_id);
                $this->Jaime->Pag->id=$page_id;
                $this->Jaime->Pag->saveField('reste', $page['Pag']['reste']-1);
                $this->Jaime->User->id=$user['User']['id'];
                $this->Jaime->User->saveField('point', $user['User']['point']+$page['Pag']['point/user']);
                echo "Merci,Vous avez gangez : ".$page['Pag']['point/user'].' Points';          
            }              
        }
        else
            echo 'Vous avez déja aimer cette page.';
        exit();
    }
}
