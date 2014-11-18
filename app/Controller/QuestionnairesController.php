<?php

App::uses('AppController', 'Controller');


class QuestionnairesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getquestionnaire','fctredimimage');
    }

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile"){
            return false;
        }if($user['role_user'] == "admin") {
                return true;
        }else {
            if ($user['role_user'] == "vendeur" && ($this->action === 'cedit' ||$this->action === 'cadd' ||$this->action === 'credit' || $this->action === 'add' || $this->action === 'index' || $this->action === 'view' || $this->action === 'delete' || $this->action === 'edit') ) {
                return true;
            }else return false;
        }
        return parent::isAuthorized($user);
    }
    //le type c'est pour l'adminitration
    //type mission c'est pour destangé entre quetionnaire et client mystere
    public function index($type=null,$type_mission=null) 
    {
        $this->Questionnaire->recursive = 0;
        if(AuthComponent::user('role_user')=='admin')
        {
            if($type!=null &&$type_mission==null)
            {
                if($type=='pro')
                    $annonces=$this->paginate(array('Questionnaire.date > CURRENT_DATE end type is null'));
                else if($type=='cour')
                    $annonces=$this->paginate(array('Questionnaire.reste>0','Questionnaire.date < CURRENT_DATE end type is null'));
                else if($type=='fin')
                    $annonces=$this->paginate(array('Questionnaire.reste<1 end type is null'));
            }
            else if($type!=null &&$type_mission!=null)
            {
                if($type=='pro')
                    $annonces=$this->paginate(array('Questionnaire.date > CURRENT_DATE and type is not null'));
                else if($type=='cour')
                    $annonces=$this->paginate(array('Questionnaire.reste>0','Questionnaire.date < CURRENT_DATE and type is not null'));
                else if($type=='fin')
                    $annonces=$this->paginate(array('Questionnaire.reste<1 and type is not null'));
            }
            else if($type==null &&$type_mission==null)
            {
                $annonces=$this->paginate(array('type is null'));
            }
            else if($type==null &&$type_mission!=null)
            {
                $annonces=$this->paginate(array('type is not null'));
            }
            $this->set('questionnaires',$annonces );
        }
        else
        {
            if($type_mission!=null)
                $annonces=$this->paginate(array('Questionnaire.user_id ' => $this->Auth->user('id'),'type is not null'));
            if($type_mission==null)
                $annonces=$this->paginate(array('Questionnaire.user_id ' => $this->Auth->user('id'),'type is null'));
            $this->set('questionnaires',$annonces );
        }
    }

    public function view($id = null) 
    {
        $quest=$this->Questionnaire->findById($id);
        if($quest['Questionnaire']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->redirect(array('action' => 'index'));
        }
        $this->Questionnaire->id = $id;
        if (!$this->Questionnaire->exists()) {
            throw new NotFoundException(__('Invalid questionnaire'));
        }
        $this->set('questionnaire', $this->Questionnaire->read(null, $id));
    }

    //la function d'ajout pour le truc de client myster 
    //j'envoie tous les données a add pour contunué le traiement 
    //cette fonction c est juspe pour affiché la vue qui a plus de maps et de type qui est hidden
    public function cadd() {
    }
    public function add() {
        if ($this->request->is('post')) 
        {
            $ville="";
            foreach ($this->request->data['ville'] as $id=>$value)
            {
                if($value=='tous')
                {
                    $ville=','.$value;
                    break;
                }
                $ville =$ville.','.$value;
            }
            $this->request->data['Questionnaire']['ville']= $ville;
            $this->Questionnaire->create();
            $this->request->data['Questionnaire']['user_id'] = $this->Auth->user('id');
            $this->request->data['Questionnaire']['points'] = $this->request->data['Questionnaire']['nombreuser'] * $this->request->data['Questionnaire']['pointparuser'];
            $this->request->data['Questionnaire']['reste']=$this->request->data['Questionnaire']['nombreuser'];
            $file=@$this->request->data['Questionnaire']['image']['tmp_name'];
            if(!empty($file)) {
                $date=date('H-i-s');
                $this->request->data['Questionnaire']['image']=$date.''.$this->request->data['Questionnaire']['image']['name'];
                move_uploaded_file($file,'img/questionnaire/'.$this->request->data['Questionnaire']['image']);
                $this->fctredimimage(75, 75, '../webroot/img/questionnaire/qmobile/', '', '../webroot/img/questionnaire/', $this->request->data['Questionnaire']['image']);
            }
            else
                $this->request->data['Questionnaire']['image']="";
            $this->request->data['Questionnaire']['date'] = date('Y-m-d', strtotime($this->request->data['Questionnaire']['date']));
            $nbpointstotal=$this->request->data['Questionnaire']['points'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Questionnaire->User->id=AuthComponent::user('id');
                $this->Questionnaire->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Questionnaire->save($this->request->data)) {
                $this->Session->setFlash('Merci d\'entrer vos questions');
                $this->redirect(array('controller'=>'questions','action' => 'add',$this->Questionnaire->id));
            } else {
                $this->Session->setFlash(__('Imposible d\'ajouter la mission, Vous devez corriger les problèmes signalé'));
            }
        }
    }

    //la function d'ajout pour le truc de client myster 
    //j'envoie tous les données a add pour contunué le traiement 
    //cette fonction c est juspe pour affiché la vue qui a plus de maps et de type qui est hidden
    public function cedit($id = null) 
    {
        $this->Questionnaire->id = $id;
        $quest=$this->Questionnaire->findById($id);
        if($quest['Questionnaire']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier questionnaire ');
            $this->redirect(array('action' => 'index'));
        }
        if((strtotime($quest['Questionnaire']['date'])+600) < time())
        {
            $this->Session->setFlash('Impossible de modifier questionnaire ');
            $this->redirect(array('controller'=>'questionnaires','action' => 'view',$quest['Questionnaire']['id']));
        }
        $this->request->data = $this->Questionnaire->read(null, $id);
    }
    public function edit($id = null) {
        $this->Questionnaire->id = $id;
        $quest=$this->Questionnaire->findById($id);
        if($quest['Questionnaire']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier questionnaire ');
            $this->redirect(array('action' => 'index'));
        }
        if((strtotime($quest['Questionnaire']['date'])+600) < time())
        {
            $this->Session->setFlash('Impossible de modifier questionnaire ');
            $this->redirect(array('controller'=>'questionnaires','action' => 'view',$quest['Questionnaire']['id']));
        }
        if (!$this->Questionnaire->exists()) {
            throw new NotFoundException(__('Invalid questionnaire'));
        }
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            $ville="";
            foreach ($this->request->data['ville'] as $id=>$value)
            {
                if($value=='tous')
                {
                    $ville=','.$value;
                    break;
                }
                $ville =$ville.','.$value;
            }
            $this->request->data['Questionnaire']['ville']= $ville;
            $file=@$this->request->data['Questionnaire']['image']['tmp_name'];
            if(!empty($file)) 
            {
                $date=date('H-i-s');
                $this->request->data['Questionnaire']['image']=$date.''.$this->request->data['Questionnaire']['image']['name'];
                move_uploaded_file($file,'img/questionnaire/'.$this->request->data['Questionnaire']['image']);
                $this->fctredimimage(75, 75, '../webroot/img/questionnaire/qmobile/', '', '../webroot/img/questionnaire/', $this->request->data['Questionnaire']['image']);
            }
            else
                $this->request->data['Questionnaire']['image']=$quest['Questionnaire']['image'];
            $this->request->data['Questionnaire']['reste']=$this->request->data['Questionnaire']['nombreuser'];
            $this->request->data['Questionnaire']['points'] = $this->request->data['Questionnaire']['nombreuser'] * $this->request->data['Questionnaire']['pointparuser'];
            $this->request->data['Questionnaire']['date'] = date('Y-m-d', strtotime($this->request->data['Questionnaire']['date']));
            //La modificaion des points de user
            $nbpointstotal=$this->request->data['Questionnaire']['points'];
            $pointavant=$quest['Questionnaire']['points'];
            if((AuthComponent::user('point')+$pointavant)>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-($nbpointstotal-$pointavant);
                $this->Session->write('Auth.User.point',$point );
                $this->Questionnaire->User->id=AuthComponent::user('id');
                $this->Questionnaire->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            
            if ($this->Questionnaire->save($this->request->data)) {
                $this->Session->setFlash(__('Questionnaire est bien modifier'));
                $this->redirect(array('action' => 'view',$this->Questionnaire->id));
            } else {
                $this->Session->setFlash(__('Erreur Fatal'));
            }
        } else {
            $this->request->data = $this->Questionnaire->read(null, $id);
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
        $this->Questionnaire->id = $id;
        if (!$this->Questionnaire->exists()) {
            throw new NotFoundException(__('Invalid questionnaire'));
        }
        $pub=$this->Questionnaire->findById($id);
        if ((strtotime($pub['Questionnaire']['date']) + 600) >= time()) 
        {
            if ($this->Questionnaire->delete())
            {
                $point=$pub['User']['point']+$pub['Questionnaire']['reste']*$pub['Questionnaire']['pointparuser'];
                $this->Session->write('Auth.User.point', $point);
                $this->Questionnaire->User->id=$pub['User']['id'];
                $this->Questionnaire->User->saveField('point',$point);
                $this->Session->setFlash(__('Questionnaire supprimer'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->Session->setFlash(__('Questionnaire n\'ai pas supprimer'));
        $this->redirect(array('action' => 'index'));
    }
    
    function getquestionnaire()
    {
        $date=  date('Y-m-d');
        $mobile_id=$_POST["id_mobile"];
        $this->Questionnaire->User->recursive = -1;
        $user=$this->Questionnaire->User->findByIdMobile($mobile_id);
        if(empty($user))
        {
            $this->Questionnaire->User->create();
            $d['User']['id_mobile']=$mobile_id;
            $d['User']['role_user']='mobile';
            $this->Questionnaire->User->save($d);
            $user=$this->Questionnaire->User->findByIdMobile($mobile_id);
        }
        $user_id=$user['User']['id'];
        $questionnaires=$this->Questionnaire->find('all',array('conditions'=>array('Questionnaire.reste>0',"Questionnaire.date<='$date'")));
        echo '[';
        foreach ($questionnaires as $questionnaire) 
        {
            $this->loadModel('Repense');
            $exist=$this->Repense->find('count',array('conditions'=>array('Repense.user_id'=>$user_id,'Repense.question_id'=>$questionnaire['Question'][0]['id'])));
            $nbuserspasse=$this->Repense->find('count',array('conditions'=>array('Repense.question_id'=>$questionnaire['Question'][0]['id'])));
            if($exist==0 && ($user['User']['sexe']==$questionnaire['Questionnaire']['sexe'] || $questionnaire['Questionnaire']['sexe']=="tous"))
            {
                $age=  explode(',', $questionnaire['Questionnaire']['trancheage']);
                for($i=1;$i< count($age);$i++)
                {
                    if($user['User']['age']===null)
                        $user['User']['age']=1;
                    $tranche=  explode('-', $age[$i]);
                    if($user['User']['age']>=$tranche[0] && $user['User']['age']<=$tranche[1] )
                    {
                        $ville=  explode(',', $questionnaire['Questionnaire']['ville']);
                        $ok=0;
                        for($i=1;$i<count($ville);$i++)
                        {
                            if($user['User']['ville']==$ville[$i] || $ville[$i]=='tous' )
                            {
                                echo '{
                                        "id":"'.$questionnaire['Questionnaire']['id'].'",
                                        "titre":"'.$questionnaire['Questionnaire']['name'].'",
                                        "description":"'.$questionnaire['Questionnaire']['description'].'",
                                        "longitude":"'.$questionnaire['Questionnaire']['longitude'].'",
                                        "latitude":"'.$questionnaire['Questionnaire']['latitude'].'",
                                        "points":"'.$questionnaire['Questionnaire']['pointparuser'].'",
                                        "nbusers":"'.$questionnaire['Questionnaire']['nombreuser'].'",
                                        "nbuserspasse":"'.$nbuserspasse.'",
                                        "image":"'.$questionnaire['Questionnaire']['image'].'"
                                      },';
                            }
                        }
                    }
                }
            }
        }
        echo   '{}]';
        exit();
    }
    
    
    //function qui permet d'ajouter des crédits a une compagne
    function credit($id)
    {
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            
            $this->Questionnaire->id=$id;
            $page=$this->Questionnaire->findById($id);
            $nbpointstotal=$this->request->data['Questionnaire']['nombreuser']*$page['Questionnaire']['pointparuser'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Questionnaire->User->id=AuthComponent::user('id');
                $this->Questionnaire->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            
            $this->Questionnaire->saveField('nombreuser',$page['Questionnaire']['nombreuser']+$this->request->data['Questionnaire']['nombreuser']);
            $this->Questionnaire->saveField('reste',$page['Questionnaire']['reste']+$this->request->data['Questionnaire']['nombreuser']);
            $this->Session->setFlash(__('Clients ajouter'));
            $this->redirect(array('action' => 'index'));
        }
    }
    
    
    
    //fonction pour redémentionné l'image
    function fctredimimage($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
        $condition = 0;
        if ($rep_Dst=='') {
            $rep_Dst = $rep_Src;
        } // (même répertoire)
        if ($img_Dst=='') {
            $img_Dst = $img_Src;
        } // (même nom)
        if (file_exists($rep_Src.$img_Src) && ($W_max!=0 || $H_max!=0)) {
            $extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
            $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
            if(in_array($extension_Src, explode(',', $extension_Allowed))) {
                $img_size = getimagesize($rep_Src.$img_Src);
                $W_Src = $img_size[0]; // largeur
                $H_Src = $img_size[1]; // hauteur
                if ($W_max!=0 && $H_max!=0) {
                    $ratiox = $W_Src / $W_max; // ratio en largeur
                    $ratioy = $H_Src / $H_max; // ratio en hauteur
                    $ratio = max($ratiox,$ratioy); // le plus grand
                    $W = $W_Src/$ratio;
                    $H = $H_Src/$ratio;
                    $condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
                }
                if ($W_max==0 && $H_max!=0) {
                    $H = $H_max;
                    $W = $H * ($W_Src / $H_Src);
                    $condition = ($H_Src > $H_max); // 1 si vrai (true)
                }
                if ($W_max!=0 && $H_max==0) {
                    $W = $W_max;
                    $H = $W * ($H_Src / $W_Src);
                    $condition = ($W_Src > $W_max); // 1 si vrai (true)
                }
                if ($condition==1) {
                    switch($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
                            break;
                        case 'png':
                            $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
                            break;
                    }
                    switch($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            $Ress_Dst = imagecreatetruecolor($W,$H);
                            break;
                        case 'png':
                            $Ress_Dst = imagecreatetruecolor($W,$H);
                            // fond transparent (pour les png avec transparence)
                            imagesavealpha($Ress_Dst, true);
                            $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                            imagefill($Ress_Dst, 0, 0, $trans_color);
                            break;
                    }
                    imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
                    switch ($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
                            break;
                        case 'png':
                            imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                            break;
                    }
                    imagedestroy ($Ress_Src);
                    imagedestroy ($Ress_Dst);
                }
            }
        }
        if ($condition==1 && file_exists($rep_Dst.$img_Dst)) {
            return true;
        }
        else {
            return false;
        }
    }
}
