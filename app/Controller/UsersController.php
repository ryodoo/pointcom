<?php
class UsersController extends AppController {

    public function isAuthorized($user) {
        if($user['role_user'] != "admin") {
            if ($this->action === 'view' || $this->action === 'admin' || $this->action === 'paiement' || $this->action === 'liste' || $this->action === 'modifier') {
                return false;
            }
            if ($user['role_user'] == "vendeur" && ($this->action === 'getuser' )) {
                return true;
            }else return false;
        }
        return parent::isAuthorized($user);
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('loginios','setReferer','countuser','getinfouserformobile','conditions','communaute','addfrommobile','vadd', 'logout', 'forgotten', 'valider', 'reinitialiser', 'accueil', 'apropos', 'vendeur', 'membre', 'contact');
    }

    public function index() 
    {
        if(AuthComponent::user('role_user')=='admin')
        {
            $this->User->Pag->recursive = -1;
            $pages=$this->User->Pag->find('all');
            $this->User->Questionnaire->recursive = -1;
            $questionnaires=$this->User->Questionnaire->find('all');
            $this->User->Mission->recursive = -1;
            $missions=$this->User->Mission->find('all');
            $this->User->Paiement->recursive = -1;
            $paiement=$this->User->Paiement->find('all');
            $this->User->Recharge->recursive = -1;
            $recharges=$this->User->Recharge->find('all');
            $this->loadModel('Usergift');
            $this->Usergift->recursive = -1;
            $cadeaux=$this->Usergift->find('all');
            $this->User->recursive = -1;
            $users=$this->User->find('all');
            $this->set(compact('pages','questionnaires','missions','paiement','recharges','cadeaux','users')); 
        }
        if(AuthComponent::user('role_user')=='vendeur')
        {
            $user=$this->User->findById(AuthComponent::user('id'));
            $this->set('info',$user); 
        }
        if(AuthComponent::user('role_user')=='mobile')
        {
            $scan=$this->User->Scan->find('all',array('conditions'=>array('Scan.user_id'=>AuthComponent::user('id'),'Scan.valider'=>'1','Scan.date_scan1 > (NOW() - INTERVAL 30 DAY)')));
            foreach ($scan as $value) 
            {
                $d['point']=$value['Mission']['point/client'];
                $date=explode(" ", $value['Scan']["date_scan1"]);
                $d['type']='Mission Terrain';
                $d['date']=$date[0];
                $d['cadeau']=0;
                $state[]=$d;
            }
            $scan=$this->User->Jaime->find('all',array('conditions'=>array('Jaime.user_id'=>AuthComponent::user('id'),'Jaime.created > (NOW() - INTERVAL 30 DAY)')));
            foreach ($scan as $value) 
            {
                $d['point']=$value['Pag']['point/user'];
                $date=explode(" ", $value['Jaime']["created"]);
                $d['date']=$date[0];
                $d['type']='Mission Facebook';
                $d['cadeau']=0;
                $state[]=$d;
            }
            $scan=$this->User->Repense->find('all',array('conditions'=>array('Repense.user_id'=>AuthComponent::user('id'),'Repense.created > (NOW() - INTERVAL 30 DAY)'),
                                                    'order'=>'`Question`.`questionnaire_id` ASC',
                                                    'group' => 'Question`.`questionnaire_id`'
                                            ));
            foreach ($scan as $value) 
            {
                $this->loadModel('Questionnaire');
                $this->Questionnaire->recursive = -1;
                $quest=$this->Questionnaire->findById($value['Question']['questionnaire_id']);
                $d['point']=$quest['Questionnaire']['pointparuser'];
                $date=explode(" ", $quest['Questionnaire']["created"]);
                $d['date']=$date[0];
                $d['type']='Mission Questionnaire';
                $d['cadeau']=0;
                $state[]=$d;
            }
            usort($state, array("UsersController", "sortByOrder"));
            $this->set('state',$state);
            $this->loadModel('Usergift');
            $gifts=$this->Usergift->find('all',array('conditions'=>array('Usergift.id_user'=>AuthComponent::user('id'),'Usergift.created > (NOW() - INTERVAL 30 DAY)')));
            foreach ($gifts as $value) 
            {
                $d['cadeau']=$value['Usergift']['point'];
                $d['point']=0;
                $date=explode(" ", $value['Usergift']["created"]);
                $d['date']=$date[0];
                $state[]=$d;
            }
            usort($state, array("UsersController", "sortByOrder"));
            $this->set('graph',$state);
            
        }
        
    }
    //function pour trié le tableau pour bien afficher les truc
    function sortByOrder($a, $b)
    {
        if ($a['date'] == $b['date']) {
            return 0;
        }
        return ($a['date'] < $b['date']) ? -1 : 1;
    }
    //function qui envoie la liste des points requi
    function infopoint()
    {
        $scan=$this->User->Scan->find('all',array('conditions'=>array('Scan.user_id'=>AuthComponent::user('id'),'Scan.valider'=>'1','Scan.date_scan1 > (NOW() - INTERVAL 30 DAY)')));
            foreach ($scan as $value) 
            {
                $d['point']=$value['Mission']['point/client'];
                $d['type']='Mission Terrain';
                $date=explode(" ", $value['Scan']["date_scan1"]);
                $d['date']=$date[0];
                $state[]=$d;
            }
            $scan=$this->User->Jaime->find('all',array('conditions'=>array('Jaime.user_id'=>AuthComponent::user('id'),'Jaime.created > (NOW() - INTERVAL 30 DAY)')));
            foreach ($scan as $value) 
            {
                $d['point']=$value['Pag']['point/user'];
                $d['type']='Mission Facebook';
                $date=explode(" ", $value['Jaime']["created"]);
                $d['date']=$date[0];
                $state[]=$d;
            }
            $scan=$this->User->Repense->find('all',array('conditions'=>array('Repense.user_id'=>AuthComponent::user('id'),'Repense.created > (NOW() - INTERVAL 30 DAY)'),
                                                    'order'=>'`Question`.`questionnaire_id` ASC',
                                                    'group' => 'Question`.`questionnaire_id`'
                                            ));
            foreach ($scan as $value) 
            {
                $this->loadModel('Questionnaire');
                $this->Questionnaire->recursive = -1;
                $quest=$this->Questionnaire->findById($value['Question']['questionnaire_id']);
                $d['point']=$quest['Questionnaire']['pointparuser'];
                $date=explode(" ", $quest['Questionnaire']["created"]);
                $d['type']='Mission Questionnaire';
                $d['date']=$date[0];
                $state[]=$d;
            }
            usort($state, array("UsersController", "sortByOrder"));
            $this->set(compact('state'));
    }
    public function view($id)
    {
        $user = $this->User->find('first', array('conditions' => array('id =' => $id)));
        $visits = $this->User->lastVisits($id,1000);
        $this->loadModel("Usergift");
        $gifts = $this->Usergift->miens2($id);
        $this->set(compact('gifts','visits','user'));

            // nb points today
            $points =$user['User']['point'];
            $avant = date("Y-m-d H:i:s", time());
            $T[date("Y-m-d", time())] = $points;

            for($t = 0; $t<30; $t++) {
                $now = $avant;
                $avant1=strtotime($avant)-86400;
                $avant=date("Y-m-d H:i:s",$avant1);
                $day=date("Y-m-d",$avant1);

                //points - points gagnés + points des cadeaux gagnés
                $points1 = $this->User->pointsGagnes($id, $now, $avant);
                $points_moins = $points1[0][0]["nb"];
                $points2 = $this->User->pointsCadeauxGagnes($id, $now, $avant);
                $points_plus = $points2[0][0]["nb"];

                $points = $points - $points_moins + $points_plus;
                $T[$day] = $points;
            }
            //print_r($T);
            if(!empty($T)) {
                $liste =  array_reverse($T);
                $this->set(compact('liste'));
            }
    }
    

    public function vadd()
    {
        if ($this->request->is('post')) {
            if($this->request->data['User']['password'] != $this->request->data['User']['re_password'] || $this->request->data['User']['password'] == "") {
                $this->Session->setFlash('Mot de passe invalide');
                return;
            }
            //generer code aleatoire
            $characts    = 'abcdefghijklmnopqrstuvwxyz';
            $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $characts   .= '1234567890';
            $code_aleatoire      = '';
            for($i=0;$i < 20;$i++) {
                $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
            }
            $this->request->data['User']['code_password']= $code_aleatoire;
            $this->User->create();
            $this->request->data['User']['id_mobile']=$this->request->data['User']['email'];
            $this->request->data['User']['role_user']='vendeur';
            $this->request->data['User']['point']=0;
            $this->request->data['User']['active']=1;

            if ($this->User->save($this->request->data)) {
                try {
                    $email = $this->request->data['User']['email'];
                    App::uses('CakeEmail', 'Network/Email');
                    $Email = new CakeEmail();
                    $Email->template('default', 'default')
                            ->viewVars(array('lien' => FULL_BASE_URL.'/nada/users/valider/'.$this->User->id.'/'.$code_aleatoire))
                            ->emailFormat('html')
                            ->to($email)
                            ->from('no-replay@myblan.com')
                            ->subject("Validation d'inscription")
                            ->send();
                }
                catch(Exception $e) {
                    $this->Session->setFlash(__($e->getMessage()));
                    return;
                }
                $this->Session->setFlash(__('L\'user a été sauvegardé, Vous avez reçu un email de validation de votre compte'));
                return $this->redirect(array('action' => 'index'));
            }
            else {
                $this->Session->setFlash(__('L\'user n\'a pas été sauvegardé. Merci de réessayer.'));
            }
        }
    }


    public function forgotten() {
        if ($this->request->is('post')) {

            //generer code aleatoire
            $characts    = 'abcdefghijklmnopqrstuvwxyz';
            $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $characts   .= '1234567890';
            $code_aleatoire      = '';
            for($i=0;$i < 20;$i++) {
                $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
            }

            $email = $this->request->data['User']['email'];
            $utilisateur = $this->User->find('first', array('conditions' => array('email =' => $email)));

            if($utilisateur == null) return;

            $this->request->data['User']['id'] = $utilisateur['User']['id'];
            $this->request->data['User']['code_password'] = $code_aleatoire;

            try {
                $this->User->save($this->request->data['User'], array('fieldList' => array("code_password")));
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail();
                $Email->template('reinit', 'default')
                        ->viewVars(array('lien' => FULL_BASE_URL.'/users/reinitialiser/'.$utilisateur['User']['id'].'/'.$code_aleatoire))
                        ->emailFormat('html')
                        ->to($email)
                        ->from('no-replay@icoz.com')
                        ->subject('Réinitialisation du mot de passe proveille')
                        ->send();
            }catch(Exception $e) {
                $this->Session->setFlash(__($e->getMessage()));
                return;
            }

            $this->Session->setFlash('email envoyé !');
            //}

        }
    }


    public function reinitialiser($id, $code) {
        if ($this->request->is('post')) {
            //echo $this->Session->read('user_id');
            //debug($this->request->data);
            if($this->request->data['User']['password'] != "" && $this->request->data['User']['password'] == $this->request->data['User']['re_password']) {
                $this->request->data['User']['id'] =  $this->Session->read('id');
                $this->request->data['User']['code_password'] = "";
                $this->User->save($this->request->data['User'], array('fieldList' => array("code_password","password")));
                return $this->redirect(
                        array('controller' => 'users', 'action' => 'login')
                );
            }else {
                $this->Session->setFlash('Erreur, Veuillez réessayez !');
                return;
            }
        }

        if(isset($id) && isset($code)) {
            $result = $this->User->find(('first'), array(
                    'conditions' => array('id =' => $id, 'code_password' => $code), 'recursive' => -1));
            //debug($result);
            if($result == null ) {
                return $this->redirect(
                        array('controller' => 'users', 'action' => 'login')
                );
            }else {
                $this->Session->write('user_id',$result['User']['id']);
            }
        }else {
            return $this->redirect(
                    array('controller' => 'users', 'action' => 'login')
            );
        }
    }


    public function edit() {
        $this->request->data = $this->User->read(null, $this->Session->read('Auth.User.id'));
        $this->request->data["User"]["id"]=$this->Session->read('Auth.User.id');
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            $this->User->recursive = -1;
            $conditions = array(
                'User.id' => $this->Session->read('Auth.User.id'),
                'User.password' => AuthComponent::password($this->request->data['User']['password']),
                'User.editer'=>"0"
            );
            if($this->User->hasAny($conditions))
            {
                $this->request->data["User"]["id_mobile"]=$this->Session->read('Auth.User.id_mobile');
                $this->request->data["User"]["point"]=$this->Session->read('Auth.User.point');
                $this->request->data["User"]["created"]=$this->Session->read('Auth.User.created');
                $this->request->data["User"]["role_user"]=$this->Session->read('Auth.User.role_user');
                $this->request->data["User"]["active"]=$this->Session->read('Auth.User.active');
                $this->request->data["User"]["editer"]='editer';
                if ($this->User->save($this->request->data))
                {
                    $this->Session->write('Auth.User.nom_complet', $this->request->data["User"]["nom_complet"]);
                    $this->Session->write('Auth.User.adresse', $this->request->data["User"]["adresse"]);
                    $this->Session->write('Auth.User.tel', $this->request->data["User"]["tel"]);
                    $this->Session->setFlash(__('L\'user a été modifié'));
                    return $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('L\'user n\'a pas été modifié. Merci de réessayer.'));
                }
            }
            else
            {
                $this->Session->setFlash(__('Desolé vous ne pouvez pas modifier votre compte'));
                return $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function login() {
        if ($this->request->is('post') ||$this->request->is('put'))
        {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());

            } else {
                $this->Session->setFlash(__("Nom d'user ou mot de passe invalide, réessayer"));
            }
        }
    }

    public function valider($id, $code) {
        if(isset($id) && isset($code)) {
            $result = $this->User->find(('first'), array(
                    'conditions' => array('id =' => $id, 'code_password' => $code), 'recursive' => -1));
            if($result != null ) {
                $this->request->data['User']['id'] = $result['User']['id'];
                $this->request->data['User']['active'] = 1;
                $this->request->data['User']['code_password'] = "";
                if($this->User->save($this->request->data['User'], array('fieldList' => array("active", "code_password"))))
                {
                    $this->Session->setFlash('Félicitation, Vous pouvez désormais vous connecter !');
                    $ref=$this->User->findByReferer($result['User']['referersource']);
                    $this->User->id=$ref['User']['id'];
                    $this->User->saveField('point',$ref['User']['point']+1);
                }
                else $this->Session->setFlash('Erreur, Veuillez réessayer !');
            }
            return $this->redirect(
                    array('controller' => 'users', 'action' => 'login')
            );
        }else {
            return $this->redirect(
                    array('controller' => 'users', 'action' => 'login')
            );
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function liste() {
        $users = $this->User->find('all');
        $this->set('users', $users);
    }

    public function delete($id) {
        if($this->User->delete($id, true))
            $this->Session->setFlash(__('L\'utilisateur a été supprimé'));
        else
            $this->Session->setFlash(__('L\'utilisateur n\'a pas été supprimé'));
        return $this->redirect($this->Auth->redirect());
    }

    public function modifier($idUser) {
        $user = $this->User->find("first", array("conditions" => array("id" => $idUser), "recursive" => -1));
        $this->set('user', $user);
        if ($this->request->is('post')) {
            if($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('L\'utilisateur a été modifié'));
            }else {
                $this->Session->setFlash(__('L\'utilisateur n\'a pas été modifié'));
            }
            return $this->redirect(array('controller' => 'users', 'action' => 'liste'));
        }
    }


    public function modifpassword()
    {
        if ($this->request->is('post'))
        {
            $this->User->id=$this->Auth->user('id');
            $this->Session->setFlash(__('Mot de passe éroné'));

            if($this->request->data['User']['ppassword'] == $this->request->data['User']['re_password'])
            {
                if(strlen($this->request->data['User']['ppassword'])<5)
                {
                    $this->Session->setFlash(__('Le mot de passe doit avoir une longueur comprise entre 5 et 15 caractères.'));
                    return $this->redirect(array('action' => 'modifpassword'));
                }
                $conditions = array(
                    'User.id' => $this->Session->read('Auth.User.id'),
                    'User.password' => AuthComponent::password($this->request->data['User']['password'])
                );
                if($this->User->hasAny($conditions))
                {
                    $this->User->saveField('password',$this->request->data['User']['ppassword']);
                    $this->Session->setFlash(__('Mot de passe modifier.'));
                    return $this->redirect(array('action' => 'index'));
                }
                else
                {
                    $this->Session->setFlash(__('Mot de passe éroné'));
                }
            }
            return $this->redirect(array('action' => 'modifpassword'));
        }
    }


    public function accueil() 
    {
        $this->layout = 'accuil';
    }

    public function vendeur() {
    }

    public function membre() {
    }

    public function contact() {
    }

    public function communaute() {
    }
    public function conditions() {
    }


    public function apropos()
    {
        //$this->layout = 'accuil';
    }


    function addfrommobile()
    {
        if ($this->request->is('post'))
        {
            $characts    = 'abcdefghijklmnopqrstuvwxyz';
            $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $characts   .= '1234567890';
            $code_aleatoire      = '';
            for($i=0;$i < 20;$i++)
            {
                $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
            }
            $this->request->data['User']['code_password']= $code_aleatoire;
            $this->request->data['User']['role_user']='mobile';
            if(isset ($_POST["referer"]))
            {
                if($_POST["referer"]!="")
                    $this->request->data['User']['referersource']=$_POST["referer"];
                else
                    $this->request->data['User']['referersource']=0;
            }
            else
                $this->request->data['User']['referersource']=0;
            $id=$_POST["id_user"];
            $this->User->id=$id;
            $user=$this->User->findById($id);
            if($user['User']['email']==null)
            {
                $this->request->data['User']['point']=1+$user['User']['point'];
            }
            $this->request->data['User']['active']=1;
            extract($_POST);
            $mobile_id=$_POST["id_mobile"];

            $nomcomplet=$_POST["nom_complet"];
            $this->request->data['User']['nom_complet']=$nomcomplet;
            $age=$_POST["age"];
            $this->request->data['User']['age']=$age;
            $token=$_POST["token"];
            $this->request->data['User']['token']=$token;
            //image
            $facebook_id=$_POST["facebook_id"];
            $headers = get_headers("https://graph.facebook.com/$facebook_id/picture",1);
            if(isset($headers['Location'])) {
                $url = $headers['Location']; // string
            } else {
                $url = $facebook_id; // nothing there? .. weird, but okay!
            }
            $this->request->data['User']['image']=$url;
            $sexe='';
            if(isset ($_POST["sexe"]))
                $sexe=$_POST["sexe"];
            $this->request->data['User']['sexe']=$sexe;
            $ville=$_POST["ville"];
            $this->request->data['User']['ville']=$ville;
            $email=$_POST["email"];
            $this->request->data['User']['email']=$email;
            $password=$_POST["password"];
            $this->request->data['User']['password']=$password;
            if ($this->User->save($this->request->data))
            {
                try {
                    $email = $this->request->data['User']['email'];

                    App::uses('CakeEmail', 'Network/Email');
                    $Email = new CakeEmail();
                    $Email->template('default', 'default')
                            ->viewVars(array('lien' => FULL_BASE_URL.'/users/valider/'.$this->User->id.'/'.$code_aleatoire))
                            ->emailFormat('html')
                            ->to($email)
                            ->from('no-replay@myblan.com')
                            ->subject("Validation d'inscription")
                            ->send();
                }
                catch(Exception $e) {
                    $this->Session->setFlash(__($e->getMessage()));
                    return;
                }
                echo 'Felicitation,Vous etes maintenant inscrit';
                exit();
            }
            else {
                echo 'Un probleme est survenu. Merci de reessayer.';
                exit();
            }
         }
    }


    function getinfouserformobile()
    {
        $this->User->recursive = -1;
        if ($this->request->is('post'))
        {
            $type='';
             if(isset ($_POST["type"]))
                $type=$_POST["type"];
            else
                header("Content-type: text/xml");
            $mobile_id=$_POST["id_mobile"];
            $user=$this->User->findByIdMobile($mobile_id);
            if(empty($user))
            {
                $this->User->create();
                $d['User']['id_mobile']=$mobile_id;
                $d['User']['role_user']='mobile';
                $this->User->save($d);
                $user=$this->User->findByIdMobile($mobile_id);
            }
            if($type!=null)
            {
                echo '
                    [
                      {
                        "id":"'.$user['User']['id'].'",
                        "nom_complet":"'.$user['User']['nom_complet'].'",
                        "email":"'.$user['User']['email'].'",
                        "mespoint":"'.$user['User']['point'].'",
                        "active":"'.$user['User']['active'].'",
                        "image":"'.$user['User']['image'].'",
                        "codereferer":"'.$user['User']['referer'].'"
                       }
                     ]
                    ';
            }
            else
            {
                echo '
                    <user>
                        <id>'.$user['User']['id'].'</id>
                        <nom_complet>'.$user['User']['nom_complet'].'</nom_complet>
                        <email>'.$user['User']['email'].'</email>
                        <mespoint>'.$user['User']['point'].'</mespoint>
                        <active>'.$user['User']['active'].'</active>
                        <referer>'.$user['User']['referer'].'</referer>
                    </user>
                        ';
            }
            exit();
        }
    }

    function countuser()
    {
        $count=$this->User->find('count');
        return $count;
        exit();
    }

    function setReferer()
    {
        $this->User->recursive = -1;
        $users=$this->User->find('all');
        foreach ($users as $user)
        {
            $this->User->id=$user['User']['id'];
            $refer=$user['User']['created'];
            $refer=explode(":", $refer);
            $refer=$user['User']['id'].''.$refer[1].''.$refer[2];
            $this->User->saveField('referer',$refer);
        }
        exit('fin');
    }

    function loginios()
    {
        if ($this->request->is('post') ||$this->request->is('put'))
        {
            $this->Auth->logout();
            $this->request->data['User']['email']=$_POST["mail"];
            $this->request->data['User']['password']=$_POST["password"];
            if ($this->Auth->login())
            {
                //$this->User->id=$this->Auth->user('id');
                //$this->User->saveField('id_mobile',$_POST["id_mobile"]);
                echo "Bienvennu";
            }
             else
             {
                echo"Nom d'user ou mot de passe invalide, réessayer";
             }
        }
        exit();
    }
    
    //function qui  me retourne luser pour les statistique avencer de client mysteres
    function getuser($id)
    {
        $this->User->recursive = -1;
        $user=$this->User->findById($id);
        return $user;
    }
}
?>