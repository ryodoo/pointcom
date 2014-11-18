<?php

App::uses('AppController', 'Controller');

/**
 * Missions Controller
 *
 * @property Mission $Mission
 */
class MissionsController extends AppController {
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('missionjson');
    }

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile"){
            return false;
        }if($user['role_user'] == "admin") {
                return true;
        }else {
            if ($user['role_user'] == "vendeur" && ($this->action === 'add' || $this->action === 'state' || $this->action === 'code' || $this->action === 'index' || $this->action === 'view' || $this->action === 'delete' || $this->action === 'edit' || $this->action === 'credit') ) {
                return true;
            }else return false;
        }
        return parent::isAuthorized($user);
    }
    
    public function index($type=null) {
        $this->Mission->recursive = 0;
        if(AuthComponent::user('role_user')=='admin')
        {
            if($type!=null)
            {
                if($type=='pro')
                    $annonces=$this->paginate(array('Mission.date > CURRENT_DATE'));
                else if($type=='cour')
                    $annonces=$this->paginate(array('Mission.reste>0','Mission.date < CURRENT_DATE'));
                else if($type=='fin')
                    $annonces=$this->paginate(array('Mission.reste<1'));
            }
            else
                $annonces=$this->paginate();
            $this->set('missions',$annonces );
        }
        else
        {
            $annonces=$this->paginate(array('Mission.user_id ' => $this->Auth->user('id')));
            $this->set('missions',$annonces );
        }
    }


    public function view($id = null) 
    {
        $quest=$this->Mission->findById($id);
        if($quest['Mission']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->redirect(array('action' => 'index'));
        }
        $this->Mission->id = $id;
        if (!$this->Mission->exists()) {
            throw new NotFoundException(__('Invalid Mission'));
        }
        $this->set('mission', $this->Mission->read(null, $id));
    }

    public function add() 
    {
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
            $this->request->data['Mission']['ville']= $ville;
            $this->request->data['Mission']['user_id'] = $this->Auth->user('id');
            $this->request->data['Mission']['reste']=$this->request->data['Mission']['client'];
            if($this->request->data['Mission']['longitude']==null)
            {
                $this->Session->setFlash('Vous devez ajouter la position de votre Magasin ');
                $this->redirect(array('action' => 'add'));
            }
            $this->request->data['Mission']['date'] = date('Y-m-d', strtotime($this->request->data['Mission']['date']));
            $nbpointstotal=$this->request->data['Mission']['point/client']*$this->request->data['Mission']['client'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Mission->User->id=AuthComponent::user('id');
                $this->Mission->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            $file=@$this->request->data['Mission']['image']['tmp_name'];
            if(!empty($file)) {
                $date=date('H-i-s');
                $this->request->data['Mission']['image']=$date.''.$this->request->data['Mission']['image']['name'];
                move_uploaded_file($file,'img/mission/'.$this->request->data['Mission']['image']);
                $this->fctredimimage(75, 75, '../webroot/img/mission/mobile/', '', '../webroot/img/mission/', $this->request->data['Mission']['image']);
            }
            else
                $this->request->data['Mission']['image']="";
            
            $this->Mission->create();
            $this->request->data['Mission']['created']=date('Y-m-d H:i:s');
            $this->request->data['Mission']['qr1'] =  md5($this->request->data['Mission']['user_id']."||".$this->request->data['Mission']['created']);
            if($this->request->data['Mission']['type'] == "visite")
                $this->request->data['Mission']['qr2'] = md5($this->request->data['Mission']['user_id']."||".$this->request->data['Mission']['created']."||".$this->request->data['Mission']['temps']);
            if ($this->Mission->save($this->request->data)) {
                $this->Session->setFlash(__('La mission est bien ajouter'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('La mission n\'ai pas ajouter contactez nous si le problème perssiste'));
            }
        }
    }


    public function edit($id = null) {
        $this->Mission->id = $id;
        $quest=$this->Mission->findById($id);
        if($quest['Mission']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier la mission ');
            $this->redirect(array('action' => 'index'));
        }
        if((strtotime($quest['Mission']['date'])+600) < time())
        {
            $this->Session->setFlash('Impossible de modifier la mission ');
            $this->redirect(array('action' => 'view',$quest['Mission']['id']));
        }
        if (!$this->Mission->exists()) {
            throw new NotFoundException(__('Invalid mission'));
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
            $this->request->data['Mission']['ville']= $ville;
            $this->request->data['Mission']['user_id'] = $this->Auth->user('id');
            $this->request->data['Mission']['reste']=$this->request->data['Mission']['client'];
            $file=@$this->request->data['Mission']['image']['tmp_name'];
            if(!empty($file)) {
                $date=date('H-i-s');
                $this->request->data['Mission']['image']=$date.''.$this->request->data['Mission']['image']['name'];
                move_uploaded_file($file,'img/mission/'.$this->request->data['Mission']['image']);
                $this->fctredimimage(75, 75, '../webroot/img/mission/mobile/', '', '../webroot/img/mission/', $this->request->data['Mission']['image']);
            }
            else
                $this->request->data['Mission']['image']=$quest['Mission']['image'];
            $this->request->data['Mission']['date'] = date('Y-m-d', strtotime($this->request->data['Mission']['date']));
            //La modificaion des points de user
            $nbpointstotal=$this->request->data['Mission']['point/client']*$this->request->data['Mission']['client'];
            $pointavant=$quest['Mission']['point/client']*$quest['Mission']['client'];
            if((AuthComponent::user('point')+$pointavant)>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-($nbpointstotal-$pointavant);
                $this->Session->write('Auth.User.point',$point );
                $this->Mission->User->id=AuthComponent::user('id');
                $this->Mission->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            $this->request->data['Mission']['qr1'] =  md5($this->request->data['Mission']['user_id']."||".$quest['Mission']['created']);
            if($this->request->data['Mission']['type'] == "visite")
                $this->request->data['Mission']['qr2'] = md5($this->request->data['Mission']['user_id']."||".$quest['Mission']['created']."||".$this->request->data['Mission']['temps']);
            if ($this->Mission->save($this->request->data)) {
                $this->Session->setFlash(__('La mission est bien modifier'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('La mission n\'ai pas ajouter contactez nous si le problème perssiste.'));
            }
        } else {
            $this->request->data = $this->Mission->read(null, $id);
        }
    }


    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Mission->id = $id;
        if (!$this->Mission->exists()) {
            throw new NotFoundException(__('Invalid mission'));
        }
        $pub=$this->Mission->findById($id);
        if ((strtotime($pub['Mission']['date']) + 600) >= time()) 
        {
            if ($this->Mission->delete()) 
            {
                $point=$pub['User']['point']+$pub['Mission']['reste']*$pub['Mission']['point/client'];
                $this->Session->write('Auth.User.point', $point);
                $this->Mission->User->id=$pub['User']['id'];
                $this->Mission->User->saveField('point',$point);
                $this->Session->setFlash(__('Mission Supprimer'));
                $this->redirect(array('action' => 'index'));
            }
        }
        
        $this->Session->setFlash(__('Mission was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    
    //Afficher le Qr pour l'imprimer 
    public function code($code,$chaine) {
        $this->set(compact('chaine','code'));
    }
    
    //Envoie les données de statistique pour chaque mission
    public function state($idMission) {
        $avant = date("Y-m-d H:i:s", time());
        for($t = 0; $t<10; $t++) {
            $now = $avant;
            $avant1=strtotime($avant)-3600;
            $avant=date("Y-m-d H:i:s",$avant1);
            $missions = $this->Mission->grapheMission($now, $avant, $idMission);
            $T[$now] = $missions[0][0]["nb"];
        }
        if(!empty($T)) {
            $liste =  array_reverse($T);
            $this->set(compact('liste'));
        }

        $qrs = $this->Mission->detailsParMission($idMission);
        $this->set(compact('qrs')); 
    }
    
    //function qui permet d'ajouter des crédits a une compagne
    function credit($id)
    {
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            $this->Mission->id=$id;
            $page=$this->Mission->findById($id);
            $nbpointstotal=$this->request->data['Mission']['client']*$page['Mission']['point/client'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Mission->User->id=AuthComponent::user('id');
                $this->Mission->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            
            $this->Mission->saveField('client',$page['Mission']['client']+$this->request->data['Mission']['client']);
            $this->Mission->saveField('reste',$page['Mission']['reste']+$this->request->data['Mission']['client']);
            $this->Session->setFlash($this->request->data['Mission']['client'].' Clients ajouter');
            $this->redirect(array('action' => 'index'));
        }
    }
    
    
    //function qui r'envoie le flux Json pour les mission en fonction de type envoyer
    function missionjson()
    {
      if ($this->request->is('post'))
      //if(1==1)
      {
          $mobile_id=$_POST["id_mobile"];
          $type=$_POST["type"];
          //$mobile_id=22;
          //$type='visite';
                echo '[
                    ';
            $this->Mission->User->recursive = -1;
            $user=$this->Mission->User->findByIdMobile($mobile_id);
            if(empty($user))
            {
                $this->Mission->User->create();
                $d['User']['id_mobile']=$mobile_id;
                $d['User']['role_user']='mobile';
                $this->Mission->User->save($d);
                $user=$this->Mission->User->findByIdMobile($mobile_id);
            }
            $user_id=$user['User']['id'];
            $this->Mission->recursive = -1;
            $missions=$this->Mission->find('all',array('conditions'=>array('reste!=0 and date <= CURRENT_DATE','Mission.type'=>$type),'order' => array('`point/client`' => 'desc')));
            
            foreach ($missions as $mission)
            {
                $test=$this->Mission->query("select count(*) as a from scans where user_id=$user_id and mission_id=".$mission['Mission']['id']." and valider=1");
                if($test[0][0]['a']==0 && ($user['User']['sexe']==$mission['Mission']['sexe'] || $mission['Mission']['sexe']=="tous"))
                {
                    $age=  explode(',', $mission['Mission']['tranche']);
                    for($i=1;$i< count($age);$i++)
                    {
                        if($user['User']['age']===null)
                            $user['User']['age']=1;
                        $tranche=  explode('-', $age[$i]);
                        if($user['User']['age']>=$tranche[0] && $user['User']['age']<=$tranche[1] )
                        {
                            $ville=  explode(',', $mission['Mission']['ville']);
                            $ok=0;
                            for($i=1;$i<count($ville);$i++)
                            {
                                if($user['User']['ville']==$ville[$i] || $ville[$i]=='tous' )
                                {
                                    echo '
                                        {
                                            "id":"'.$mission['Mission']['id'].'",
                                            "titre":"Mission '.$mission['Mission']['titre'].'",
                                            "description":"'.$mission['Mission']['description'].'",
                                            "x":"'.$mission['Mission']['latitude'].'",
                                            "y":"'.$mission['Mission']['longitude'].'",
                                            "image":"http://myblan.com/img/mission/mobile/'.$mission['Mission']['image'].'",
                                            "ville":"'.$mission['Mission']['ville'].'",
                                            "point":"'.$mission['Mission']['point/client'].'",
                                            "temps":"'.$mission['Mission']['temps'].'",
                                            "nbvisite":"'.($mission['Mission']['client']-$mission['Mission']['reste']).'",
                                            "nbvisitetotatal":"'.$mission['Mission']['client'].'"
                                        },';
                                }
                            }
                        }
                    }
                }
            }
                echo '
                    {}]';
            exit();
      }
    }
    //fonction pour redémentionné l'image
    function fctredimimage($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
        $condition = 0;
        // Si certains paramètres ont pour valeur '' :
        if ($rep_Dst=='') {
            $rep_Dst = $rep_Src;
        } // (même répertoire)
        if ($img_Dst=='') {
            $img_Dst = $img_Src;
        } // (même nom)
        // ---------------------
        // si le fichier existe dans le répertoire, on continue...
        if (file_exists($rep_Src.$img_Src) && ($W_max!=0 || $H_max!=0)) {
            // ----------------------
            // extensions acceptées :
            $extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
            // extension fichier Source
            $extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
            // ----------------------
            // extension OK ? on continue ...
            if(in_array($extension_Src, explode(',', $extension_Allowed))) {
                // ------------------------
                // récupération des dimensions de l'image Src
                $img_size = getimagesize($rep_Src.$img_Src);
                $W_Src = $img_size[0]; // largeur
                $H_Src = $img_size[1]; // hauteur
                // ------------------------
                // condition de redimensionnement et dimensions de l'image finale
                // ------------------------
                // A- LARGEUR ET HAUTEUR maxi fixes
                if ($W_max!=0 && $H_max!=0) {
                    $ratiox = $W_Src / $W_max; // ratio en largeur
                    $ratioy = $H_Src / $H_max; // ratio en hauteur
                    $ratio = max($ratiox,$ratioy); // le plus grand
                    $W = $W_Src/$ratio;
                    $H = $H_Src/$ratio;
                    $condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
                }
                // ------------------------
                // B- HAUTEUR maxi fixe
                if ($W_max==0 && $H_max!=0) {
                    $H = $H_max;
                    $W = $H * ($W_Src / $H_Src);
                    $condition = ($H_Src > $H_max); // 1 si vrai (true)
                }
                // ------------------------
                // C- LARGEUR maxi fixe
                if ($W_max!=0 && $H_max==0) {
                    $W = $W_max;
                    $H = $W * ($H_Src / $W_Src);
                    $condition = ($W_Src > $W_max); // 1 si vrai (true)
                }
                // ---------------------------------------------
                // REDIMENSIONNEMENT si la condition est vraie
                // ---------------------------------------------
                // - Si l'image Source est plus petite que les dimensions indiquées :
                // Par defaut : PAS de redimensionnement.
                // - Mais on peut "forcer" le redimensionnement en ajoutant ici :
                // $condition = 1; (risque de perte de qualité)
                if ($condition==1) {
                    // ---------------------
                    // creation de la ressource-image "Src" en fonction de l extension
                    switch($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
                            break;
                        case 'png':
                            $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
                            break;
                    }
                    // ---------------------
                    // creation d une ressource-image "Dst" aux dimensions finales
                    // fond noir (par defaut)
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
                    // ---------------------
                    // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
                    imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
                    // ---------------------
                    // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
                    switch ($extension_Src) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
                            break;
                        case 'png':
                            imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                            break;
                    }
                    // ------------------------
                    // liberation des ressources-image
                    imagedestroy ($Ress_Src);
                    imagedestroy ($Ress_Dst);
                }
                // ------------------------
            }
        }
        // ---------------------------------------------------
        // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
        if ($condition==1 && file_exists($rep_Dst.$img_Dst)) {
            return true;
        }
        else {
            return false;
        }
    }

}
