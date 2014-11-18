<?php

App::uses('AppController', 'Controller');

/**
 * Repenses Controller
 *
 * @property Repense $Repense
 */
class RepensesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
     public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('getrepense');
    }

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile"){
            return false;
        }if($user['role_user'] == "admin") {
                return true;
        }else {
            if ($user['role_user'] == "vendeur" && ($this->action === 'avencer'|| $this->action === 'index') ) {
                return true;
            }else return false;
        }
        return parent::isAuthorized($user);
    }
    
    public function index() {
        $this->Repense->recursive = 0;
        $this->set('repenses', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Repense->id = $id;
        if (!$this->Repense->exists()) {
            throw new NotFoundException(__('Invalid repense'));
        }
        $this->set('repense', $this->Repense->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Repense->create();
            if ($this->Repense->save($this->request->data)) {
                $this->Session->setFlash(__('The repense has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The repense could not be saved. Please, try again.'));
            }
        }
        $users = $this->Repense->User->find('list');
        $questions = $this->Repense->Question->find('list');
        $this->set(compact('users', 'questions'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Repense->id = $id;
        if (!$this->Repense->exists()) {
            throw new NotFoundException(__('Invalid repense'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Repense->save($this->request->data)) {
                $this->Session->setFlash(__('The repense has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The repense could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Repense->read(null, $id);
        }
        $users = $this->Repense->User->find('list');
        $questions = $this->Repense->Question->find('list');
        $this->set(compact('users', 'questions'));
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
        $this->Repense->id = $id;
        if (!$this->Repense->exists()) {
            throw new NotFoundException(__('Invalid repense'));
        }
        if ($this->Repense->delete()) {
            $this->Session->setFlash(__('Repense deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Repense was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    function getrepense() 
    {
        $data="31_25-3_28-14_29-4_30-text";
        //$data=$_POST['repense'];
        $data=  explode("_", $data);
        $user_id=$data[0];
        $info=explode("-", $data[1]);
        //Test si déja vous avez rependre a ce questionnaire
        // --------cherche id du questionnaire
        $question=$this->Repense->Question->findById($info[0]);
        $count=$this->Repense->Question->find('count',array('conditions'=>array('Question.questionnaire_id'=>$question['Questionnaire']['id'])));
        $countrep=$this->Repense->query("select count(id) from repenses where question_id in( select id from questions where questionnaire_id=".$question['Questionnaire']['id'].")");
        $countrep=$countrep[0][0]['count(id)'];
        //$exist=$this->Repense->find('count',array('conditions'=>array('Repense.user_id'=>$user_id,'Repense.question_id'=>$info[0])));
        if($count==$countrep)
        {
            echo "Erreur, vous avez déja fais ce questionnaire!!";
            exit();
        }
        
        for($i=1;$i<count($data);$i++) 
        {
            $info=explode("-", $data[$i]);
            if(strlen($info[1])>300)
            {
                $date=date('H-i-s');
                $image = $this->base64_to_jpeg( $info[1], "img/client/$user_id-$info[0]-$date.jpg" );
                $d['Repense']['choix']="$user_id-$info[0]-$date.jpg";
            }
            else
                $d['Repense']['choix']=$info[1];
            //savoir est que la données a été bien envoyer si oui on fais la mise a jour si non on l'ajoute :)
            $existeinfo=$this->Repense->find('first',array('conditions'=>
                        array('Repense.user_id'=>$user_id,'Repense.question_id'=>$info[0])));
            if(empty($existeinfo))
            {
                //si on ajoute donc c'est une repense pour une nouvel question non rependu donc je vais ajouter une autre repnse
                // a la liste pour voir aprés si il as terminer les questionnaire pour prendre c'est point et demunier le reste de questionnaire
                $countrep++;
                $this->Repense->create();
            }
            else 
            {
                $this->Repense->id=$existeinfo['Repense']['id'];
            }
            $d['Repense']['user_id']=$user_id;
            $d['Repense']['question_id']=$info[0];
            $this->Repense->save($d);
        }
        if($count==$countrep)
        {
            $this->loadModel('Questionnaire');
            $this->Questionnaire->id=$question['Questionnaire']['id'];
            $this->Questionnaire->saveField('reste', $question['Questionnaire']['reste']-1);
            $this->Repense->User->recursive = -1;
            $user =$this->Repense->User->findById($user_id);
            $this->Repense->User->id=$user_id;
            $this->Repense->User->saveField('point', $user['User']['point']+$question['Questionnaire']['pointparuser']);
            echo "Merci,Vous avez gangez : ".$question['Questionnaire']['pointparuser'].' Points';
            echo "Merci,La validation du mission prend 48 heure ";
        }
        exit("$count  -  $countrep");
    }
    
    //Les statistiques Simple d'une questionnaire + fichier pour sphinex
    function avencer($questionnaire_id=null)
    {
        $questions=$this->Repense->find('all',array('conditions'=>array('Question.questionnaire_id'=>$questionnaire_id)));
        $this->set('questions',$questions);
        $this->set('questionnaire_id',$questionnaire_id);
    }
    
    //convirtir une image provient de android a une image 
    function base64_to_jpeg( $base64_string, $output_file ) {
    $ifp = fopen( $output_file, "wb" ); 
    fwrite( $ifp, base64_decode( $base64_string) ); 
    fclose( $ifp ); 
    return( $output_file ); 
    }
}
