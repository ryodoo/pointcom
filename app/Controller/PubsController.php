<?php
App::uses('AppController','Controller');
class PubsController extends AppController 
{
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
            if ($user['role_user'] == "vendeur" && ($this->action === 'fctredimimage' ||$this->action === 'credit' ||$this->action === 'index' ||$this->action === 'state' || $this->action === 'add' ||$this->action === 'view' || $this->action === 'delete' || $this->action === 'edit') ) {
                return true;
            }else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }

    public function index($type=null) {
        $this->Pub->recursive = 0;
        if(AuthComponent::user('role_user')=='admin')
        {
            if($type!=null)
            {
                if($type=='pro')
                    $annonces=$this->paginate(array('Pub.date > CURRENT_DATE'));
                else if($type=='cour')
                    $annonces=$this->paginate(array('Pub.reste>0','Pag.date < CURRENT_DATE'));
                else if($type=='fin')
                    $annonces=$this->paginate(array('Pub.reste<1'));
            }
            else
                $annonces=$this->paginate();
            $this->set('pubs',$annonces );
        }
        else
        {
            $annonces=$this->paginate(array('Pub.user_id ' => $this->Auth->user('id')));
            $this->set('pubs',$annonces );
        }
    }

    public function view($id = null) {
        $this->Pub->id = $id;
        $quest=$this->Pub->findById($id);
        if($quest['Pub']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->Pub->exists()) {
            throw new NotFoundException(__('Mission introvable'));
        }
        $this->set('pub', $this->Pub->read(null, $id));
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
            $this->request->data['Pub']['ville']= $ville;
            $this->request->data['Pub']['user_id'] = $this->Auth->user('id');
            $this->request->data['Pub']['reste']=$this->request->data['Pub']['user'];
            $this->request->data['Pub']['date'] = date('Y-m-d', strtotime($this->request->data['Pub']['date']));
            //----------------------------Valider des points sufisant------------------------//
            $nbpointstotal=$this->request->data['Pub']['user']*$this->request->data['Pub']['point/user'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Pub->User->id=AuthComponent::user('id');
                $this->Pub->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            //--------------------------------------Image--------------------------//
            $file=@$this->request->data['Pub']['image']['tmp_name'];
            if(!empty($file)) {
                $date=date('H-i-s');
                $this->request->data['Pub']['image']=$date.''.$this->request->data['Pub']['image']['name'];
                move_uploaded_file($file,'img/pub/'.$this->request->data['Pub']['image']);
                $this->fctredimimage(75, 75, '../webroot/img/pub/mobile/', '', '../webroot/img/pub/', $this->request->data['Pub']['image']);
            }
            else
                $this->request->data['Pub']['image']="";
            //----------------------------Ajout dans la base------------------------------//
            $this->Pub->create();
            if ($this->Pub->save($this->request->data)) 
            {
                //Ajout dans la table pubchoix
                if ($this->request->data['Pub']['type'] == 'text')
                {
                    $this->Pub->Choipub->create();
                    $choix['Choipub']['choix'] = 'texte';
                    $choix['Choipub']['pub_id'] = $this->Pub->id;
                    $this->Pub->Choipub->save($choix);
                }
                else if($this->request->data['Pub']['type']=='radio')
                {
                    foreach ($this->request->data['repense'] as $key=>$value) 
                    {
                        $choix="";
                        $this->Pub->Choipub->create();
                        $choix['Choipub']['choix'] = $value;
                        if($key==$this->request->data['radio1'])
                            $choix['Choipub']['valide'] = 1;
                        $choix['Choipub']['pub_id'] = $this->Pub->id;
                        $this->Pub->Choipub->save($choix);
                    }
                }
                else if($this->request->data['Pub']['type']=='case')
                {
                    foreach ($this->request->data['repense'] as $key=>$value) 
                    {
                        $choix="";
                        $this->Pub->Choipub->create();
                        $choix['Choipub']['choix'] = $value;
                        foreach ($this->request->data['case'] as $k=>$v)
                        {
                            if($key==$v)
                                $choix['Choipub']['valide'] = 1;
                        }
                        $choix['Choipub']['pub_id'] = $this->Pub->id;
                        $this->Pub->Choipub->save($choix);
                    }
                }
                $this->Session->setFlash(__('La mission est bien ajouter'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('La mission n\'ai pas ajouter contactez nous si le problème perssiste'));
            }
        }
        $users = $this->Pub->User->find('list');
        $this->set(compact('users'));
    }


    public function edit($id = null) 
    {
        $this->Pub->id = $id;
        $quest=$this->Pub->findById($id);
        if($quest['Pub']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier La mission ');
            $this->redirect(array('action' => 'index'));
        }
        if((strtotime($quest['Pub']['date'])+600) < time())
        {
            $this->Session->setFlash('Impossible de modifier la mission ');
            $this->redirect(array('action' => 'view',$id));
        }
        if (!$this->Pub->exists()) {
            throw new NotFoundException(__('Mission introvable'));
        }
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            if(empty($this->request->data['Pub']['type']))
                $this->request->data['Pub']['type']=$quest['Pub']['type'];
            if(!empty($this->request->data['repense']))
            {
                foreach ($quest['Choipub'] as $value) 
                {
                    $this->Pub->Choipub->id=$value['id'];
                    $this->Pub->Choipub->delete();
                }
            }
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
            $this->request->data['Pub']['ville']= $ville;
            $file=@$this->request->data['Pub']['image']['tmp_name'];
            if(!empty($file)) {
                $date=date('H-i-s');
                $this->request->data['Pub']['image']=$date.''.$this->request->data['Pub']['image']['name'];
                move_uploaded_file($file,'img/pub/'.$this->request->data['Pub']['image']);
                $this->fctredimimage(75, 75, '../webroot/img/pub/mobile/', '', '../webroot/img/pub/', $this->request->data['Pub']['image']);
            }
            else
                $this->request->data['Pub']['image']=$quest['Pub']['image'];
            $this->request->data['Pub']['date'] = date('Y-m-d', strtotime($this->request->data['Pub']['date']));
            //La modificaion des points de user
            $nbpointstotal=$this->request->data['Pub']['point/user']*$this->request->data['Pub']['user'];
            $pointavant=$quest['Pub']['point/user']*$quest['Pub']['user'];
            if((AuthComponent::user('point')+$pointavant)>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-($nbpointstotal-$pointavant);
                $this->Session->write('Auth.User.point',$point );
                $this->Pub->User->id=AuthComponent::user('id');
                $this->Pub->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Pub->save($this->request->data)) 
            {
                //Ajout dans la table pubchoix
                if(!empty($this->request->data['repense']))
                {
                    if ($this->request->data['Pub']['type'] == 'text')
                    {
                        $this->Pub->Choipub->create();
                        $choix['Choipub']['choix'] = 'texte';
                        $choix['Choipub']['pub_id'] = $this->Pub->id;
                        $this->Pub->Choipub->save($choix);
                    }
                    else if($this->request->data['Pub']['type']=='radio')
                    {
                        foreach ($this->request->data['repense'] as $key=>$value) 
                        {
                            $choix="";
                            $this->Pub->Choipub->create();
                            $choix['Choipub']['choix'] = $value;
                            if($key==$this->request->data['radio1'])
                                $choix['Choipub']['valide'] = 1;
                            $choix['Choipub']['pub_id'] = $this->Pub->id;
                            $this->Pub->Choipub->save($choix);
                        }
                    }
                    else if($this->request->data['Pub']['type']=='case')
                    {
                        foreach ($this->request->data['repense'] as $key=>$value) 
                        {
                            $choix="";
                            $this->Pub->Choipub->create();
                            $choix['Choipub']['choix'] = $value;
                            foreach ($this->request->data['case'] as $k=>$v)
                            {
                                if($key==$v)
                                    $choix['Choipub']['valide'] = 1;
                            }
                            $choix['Choipub']['pub_id'] = $this->Pub->id;
                            $this->Pub->Choipub->save($choix);
                        }
                    }
                }
                $this->Session->setFlash(__('Mission sauvegarder'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Problème de sauvegarder de la mission'));
            }
        } else {
            $this->request->data = $this->Pub->read(null, $id);
        }
        $users = $this->Pub->User->find('list');
        $this->set(compact('users'));
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) 
        {
            throw new MethodNotAllowedException();
        }
        $this->Pub->id = $id;
        if (!$this->Pub->exists()) {
            throw new NotFoundException(__('Invalid pub'));
        }
        $pub=$this->Pub->findById($id);
        if ((strtotime($pub['Pub']['date']) + 600) >= time()) 
        {
            if ($this->Pub->delete())
            {
                $point=$pub['User']['point']+$pub['Pub']['reste']*$pub['Pub']['point/user'];
                $this->Session->write('Auth.User.point', $point);
                $this->Pub->User->id=$pub['User']['id'];
                $this->Pub->User->saveField('point',$point);
                $this->Session->setFlash(__('Mission supprimer'));
                $this->redirect(array('action' => "index"));
            }
        }
        $this->Session->setFlash(__('Question n\'ai pas Supprimer'));
        $this->redirect(array('action' => 'indexx'));
    }
    
    //function qui permet d'ajouter des crédits a une compagne
    function credit($id)
    {
        $quest=$this->Pub->findById($id);
        if($quest['Pub']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier La mission ');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            $this->Pub->id=$id;
            $page=$this->Pub->findById($id);
            $nbpointstotal=$this->request->data['Pub']['user']*$page['Pub']['point/user'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Pub->User->id=AuthComponent::user('id');
                $this->Pub->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            $this->Pub->saveField('user',$page['Pub']['user']+$this->request->data['Pub']['user']);
            $this->Pub->saveField('reste',$page['Pub']['reste']+$this->request->data['Pub']['user']);
            $this->Session->setFlash(__('Clients ajouter'));
            $this->redirect(array('action' => 'index'));
        }
    }
    
    //function statistique simple et dettalier
    function state($id=null)
    {
        $quest=$this->Pub->findById($id);
        if($quest['Pub']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier La mission ');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->request->is('post')) 
        {
            $this->set('info',$this->request->data);
            $age=explode(',', $this->request->data['Pub']['tranche']);
            $age=explode('-',$age[1]);
            $age="User.age>$age[0] AND User.age<'$age[1]'";
            if($this->request->data['Pub']['sexe']!='tous')
                $age="$age AND User.sexe='".$this->request->data['Pub']['sexe']."'";
            $ville='AND User.ville in (';$k=0;
            foreach ($this->request->data['ville'] as $key => $value) 
            {
                if($value=='tous')
                {
                    $k++;
                    $ville='';
                    break;
                }
                $ville=$ville."'$value',";
            }
            if($k==0)
            {
                $ville= substr($ville, 0, -1);
                $ville=$ville.")";
            }
            $age="$age $ville ";
            $questions=$this->Pub->Reppub->find('all',array('conditions'=>array('Reppub.pub_id'=>$id,$age)));
        }
        else
            $questions=$this->Pub->Reppub->find('all',array('conditions'=>array('Reppub.pub_id'=>$id)));
        $this->set('pubs',$questions);
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