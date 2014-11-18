<?php
App::uses('AppController', 'Controller');

class PagsController extends AppController 
{
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getpages');
    }

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile"){
            return false;
        }if($user['role_user'] == "admin") {
                return true;
        }else {
            if ($user['role_user'] == "vendeur" && ($this->action === 'add' || $this->action === 'index' || $this->action === 'view' || $this->action === 'delete' || $this->action === 'edit' || $this->action === 'credit') ) {
                return true;
            }else return false;
        }
        return parent::isAuthorized($user);
    }
    

    public function index($type=null) {
        $this->Pag->recursive = 0;
        if(AuthComponent::user('role_user')=='admin')
        {
            if($type!=null)
            {
                if($type=='pro')
                    $annonces=$this->paginate(array('Pag.date > CURRENT_DATE'));
                else if($type=='cour')
                    $annonces=$this->paginate(array('Pag.reste>0','Pag.date < CURRENT_DATE'));
                else if($type=='fin')
                    $annonces=$this->paginate(array('Pag.reste<1'));
            }
            else
                $annonces=$this->paginate();
            $this->set('pags',$annonces );
        }
        else
        {
            $annonces=$this->paginate(array('Pag.user_id ' => $this->Auth->user('id')));
            $this->set('pags',$annonces );
        }
    }


    public function view($id = null) {
        $this->Pag->id = $id;
        $quest=$this->Pag->findById($id);
        if($quest['Pag']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->redirect(array('action' => 'index'));
        }
        if (!$this->Pag->exists()) {
            throw new NotFoundException(__('Invalid page'));
        }
        $this->set('pag', $this->Pag->read(null, $id));
        $jaime=$this->Pag->Jaime->find('all',array('conditions'=>array('Jaime.pag_id'=>$id)));
        $this->set('jaime',$jaime);
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
            $this->request->data['Pag']['ville']= $ville;
            include '../webroot/fb/facebook.php';
            $config = array(
                    'appId'  => '509648052460968',
                    'secret' => 'e6cbe41000d7a7cb104757884e54247c',
                    'cookie' => true);
            $facebook = new Facebook($config);
            $params = array('method' => 'fql.query',
                    'query' => "SELECT id FROM object_url WHERE url = '".$this->request->data['Pag']['lien']."'",);
            //Run Query
            $result = $facebook->api($params);
            $this->request->data['Pag']['fb_id']=$result[0]['id'];
            $params = array('method' => 'fql.query',
                    'query' =>  "SELECT pic,name FROM page WHERE page_id='".$result[0]['id']."'",);
            $result = $facebook->api($params);
            $this->request->data['Pag']['image']=$result[0]['pic'];
            $this->request->data['Pag']['titre']=$result[0]['name'];
            $this->request->data['Pag']['user_id'] = $this->Auth->user('id');
            $this->request->data['Pag']['reste']=$this->request->data['Pag']['user'];
            $this->request->data['Pag']['date'] = date('Y-m-d', strtotime($this->request->data['Pag']['date']));
            $nbpointstotal=$this->request->data['Pag']['user']*$this->request->data['Pag']['point/user'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Pag->User->id=AuthComponent::user('id');
                $this->Pag->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            $this->Pag->create();
            if ($this->Pag->save($this->request->data)) 
            {
                $this->Session->setFlash(__('La page facebook est bien enregestrer'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Erreur!!'));
            }
        }
    }


    public function edit($id = null) 
    {
        $this->Pag->id = $id;
        $quest=$this->Pag->findById($id);
        if($quest['Pag']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
        {
            $this->Session->setFlash('Impossible de modifier La page ');
            $this->redirect(array('action' => 'index'));
        }
        if((strtotime($quest['Pag']['date'])+600) < time())
        {
            $this->Session->setFlash('Impossible de modifier La page ');
            $this->redirect(array('action' => 'view',$quest['Pag']['id']));
        }
        if (!$this->Pag->exists()) {
            throw new NotFoundException(__('Invalid pag'));
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
            $this->request->data['Pag']['ville']= $ville;
            include '../webroot/fb/facebook.php';
            $config = array(
                    'appId'  => '509648052460968',
                    'secret' => 'e6cbe41000d7a7cb104757884e54247c',
                    'cookie' => true);
            $facebook = new Facebook($config);
            $params = array('method' => 'fql.query',
                    'query' => "SELECT id FROM object_url WHERE url = '".$this->request->data['Pag']['lien']."'",);
            $result = $facebook->api($params);
            $this->request->data['Pag']['fb_id']=$result[0]['id'];
            $params = array('method' => 'fql.query',
                    'query' =>  "SELECT pic,name FROM page WHERE page_id='".$result[0]['id']."'",);
            $result = $facebook->api($params);
            $this->request->data['Pag']['image']=$result[0]['pic'];
            $this->request->data['Pag']['titre']=$result[0]['name'];
            $this->request->data['Pag']['user_id'] = $this->Auth->user('id');
            $this->request->data['Pag']['reste']=$this->request->data['Pag']['user'];
            $this->request->data['Pag']['date'] = date('Y-m-d', strtotime($this->request->data['Pag']['date']));
            //La modificaion des points de user
            $nbpointstotal=$this->request->data['Pag']['user']*$this->request->data['Pag']['point/user'];
            $pointavant=$quest['Pag']['user']*$quest['Pag']['point/user'];
            if((AuthComponent::user('point')+$pointavant)>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-($nbpointstotal-$pointavant);
                $this->Session->write('Auth.User.point',$point );
                $this->Pag->User->id=AuthComponent::user('id');
                $this->Pag->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            if ($this->Pag->save($this->request->data)) {
                $this->Session->setFlash(__('Page modifier'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Erreur fatal'));
            }
        } else {
            $this->request->data = $this->Pag->read(null, $id);
        }
    }
    
    
    //function qui permet d'ajouter des crédits a une compagne
    function credit($id)
    {
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            
            $this->Pag->id=$id;
            $page=$this->Pag->findById($id);
            $nbpointstotal=$this->request->data['Pag']['user']*$page['Pag']['point/user'];
            if(AuthComponent::user('point')>=$nbpointstotal)
            {
                $point=AuthComponent::user('point')-$nbpointstotal;
                $this->Session->write('Auth.User.point', $point);
                $this->Pag->User->id=AuthComponent::user('id');
                $this->Pag->User->saveField('point',$point);
            }
            else
            {
                $this->Session->setFlash('Nombre de points de votre compte est insufisent ');
                $this->redirect(array('action' => 'index'));
            }
            
            $this->Pag->saveField('user',$page['Pag']['user']+$this->request->data['Pag']['user']);
            $this->Pag->saveField('reste',$page['Pag']['reste']+$this->request->data['Pag']['user']);
            $this->Session->setFlash(__('Clients ajouter'));
            $this->redirect(array('action' => 'index'));
        }
    }


    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Pag->id = $id;
        if (!$this->Pag->exists()) {
            throw new NotFoundException(__('Invalid pag'));
        }
        $pub=$this->Pag->findById($id);
        if ((strtotime($pub['Pag']['date']) + 600) >= time()) 
        {
            if ($this->Pag->delete())
            {
                $point=$pub['User']['point']+$pub['Pag']['reste']*$pub['Pag']['point/user'];
                $this->Session->write('Auth.User.point', $point);
                $this->Pag->User->id=$pub['User']['id'];
                $this->Pag->User->saveField('point',$point);
                $this->Session->setFlash(__('Page supprimer'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $this->Session->setFlash(__('Pag was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    
    //Function qui envoie les données a l'application mére
    function getpages()
    {
        $date=  date('Y-m-d');
        $mobile_id=$_POST["id_mobile"];
        //$mobile_id=22;
        $user=$this->Pag->User->findByIdMobile($mobile_id);
        if(empty($user))
        {
            $this->Pag->User->create();
            $d['User']['id_mobile']=$mobile_id;
            $d['User']['role_user']='mobile';
            $this->Pag->User->save($d);
            $user=$this->Pag->User->findByIdMobile($mobile_id);
        }
        $pages=$this->Pag->find('all',array('conditions'=>array("Pag.reste>0","Pag.date<='$date'")));
        echo '[';
        foreach ($pages as $page) 
        {
            $exist=0;
            foreach ($page['Jaime'] as $jaime) 
            {
                if($jaime['user_id']==$user['User']['id'])
                {
                    $exist++;
                    break;
                }
            }
            if($exist==0 && ($user['User']['sexe']==$page['Pag']['sexe'] || $page['Pag']['sexe']=="tous"))
            {
                $age=  explode(',', $page['Pag']['tranche']);
                for($ii=1;$i< count($age);$ii++)
                {
                    if($user['User']['age']===null)
                        $user['User']['age']=1;
                    $tranche=  explode('-', $age[$ii]);
                    if($user['User']['age']>=$tranche[0] && $user['User']['age']<=$tranche[1] )
                    {
                        $ville=  explode(',', $page['Pag']['ville']);
                        $ok=0;
                        for($i=1;$i<count($ville);$i++)
                        {
                            if($user['User']['ville']==$ville[$i] || $ville[$i]=='tous' )
                            {
                                $page['Pag']['lien']=  str_replace('https://www.','https://m.', $page['Pag']['lien']);
                                $passer=$page['Pag']['user']-$page['Pag']['reste'];
                                echo '{
                                        "id":"'.$page['Pag']['id'].'",
                                        "titre":"'.$page['Pag']['titre'].'",
                                        "points":"'.$page['Pag']['point/user'].'",
                                        "nbusers":"'.$page['Pag']['user'].'",
                                        "nbuserspasse":"'.$passer.'",
                                        "lien":"'.$page['Pag']['lien'].'",
                                        "image":"'.$page['Pag']['image'].'"
                                       },';
                                $ok++;
                                break;
                            }
                        }
                        if($ok!=0)
                            break;
                    }
                }
            }
        }
        echo "{}]";
        exit();
    }
}
