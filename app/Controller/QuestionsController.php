<?php

App::uses('AppController', 'Controller');

class QuestionsController extends AppController {

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
            if ($user['role_user'] == "vendeur" && ($this->action === 'avencer' ||$this->action === 'state' || $this->action === 'getchoix' || $this->action === 'add' || $this->action === 'delete' || $this->action === 'edit') ) {
                return true;
            }else {
                return false;
            }
        }
        return parent::isAuthorized($user);
    }


    public function add($questionnaire_id=null)
    {
        if ($this->request->is('post')) 
        {
            $d = $this->request->data;
            for ($i = 1; $i < 20; $i++) {
                if (isset($d["forminput$i"])) {
                    $dd['Question']['type'] = $d["type$i"];
                    $dd['Question']['question'] = $d["forminput$i"];
                    $dd['Question']['questionnaire_id'] = $d['Question']['questionnaire_id'];
                    $this->Question->create();
                    $this->Question->save($dd);
                    if ($dd['Question']['type'] == 'text') {
                        $this->Question->Choix->create();
                        $choix['Choix']['choix'] = 'texte';
                        $choix['Choix']['question_id'] = $this->Question->id;
                        $this->Question->Choix->save($choix);
                    }
                    for ($j = 1; $j < 20; $j++) {
                        if (isset($d["forminput$i-$j"])) {
                            $this->Question->Choix->create();
                            $choix['Choix']['choix'] = $d["forminput$i-$j"];
                            $choix['Choix']['question_id'] = $this->Question->id;
                            $this->Question->Choix->save($choix);
                        }
                    }
                }
            }
            $this->Session->setFlash(__('Les questions est bien enregestrer '));
            $this->redirect(array('controller'=>'questionnaires','action' => 'view',$d['Question']['questionnaire_id']));
            
        }
        if($questionnaire_id==null)
        {
            $this->Session->setFlash('Erreur fatal');
            $this->redirect(array('controller'=>'questionnaires','action' => 'index'));
        }
        $this->set(compact('questionnaire_id'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit() {
        if ($this->request->is('post') || $this->request->is('put')) 
        {
            $quest=$this->Question->findById($this->request->data['id']);
            if($quest['Questionnaire']['user_id']!=$this->Auth->user('id') && AuthComponent::user('role_user')!='admin')
            {
                $this->redirect(array('action' => 'index'));
            }
            if((strtotime($quest['Questionnaire']['date'])+600) < time())
            {
                $this->Session->setFlash('Impossible de modifier questionnaire ');
                $this->redirect(array('controller'=>'questionnaires','action' => 'view',$quest['Questionnaire']['id']));
            }
            $this->Question->id=$this->request->data['id'];
            $d['Question']['question']=$this->request->data['forminput'];
            $this->Question->save($d);
            $this->Question->Choix->recursive = -1;
            $choi=$this->Question->Choix->find('all',array('conditions'=>array('Choix.question_id'=>$this->request->data['id'])));
            foreach ($choi as $value) 
            {
                $this->Question->Choix->id=$value['Choix']['id'];
                $this->Question->Choix->delete();
            }
            for($i=0;$i<20;$i++)
            {
                if (isset($this->request->data["forminput$i"]))
                {
                    $this->Question->Choix->create();
                    $choix['Choix']['choix'] = $this->request->data["forminput$i"];
                    $choix['Choix']['question_id'] = $this->Question->id;
                    $this->Question->Choix->save($choix);
                }
            }
                $this->Session->setFlash('Question Modifier');
                $this->redirect(array('controller'=>'questionnaires','action' => 'view',$quest['Questionnaire']['id']));
            
        } else {
            $this->Session->setFlash('Question invalide!!');
                $this->redirect(array('controller'=>'questionnaires','action' => 'index'));
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
        $this->Question->id = $id;
        if (!$this->Question->exists()) {
            throw new NotFoundException(__('Invalid question'));
        }
        $question=$this->Question->findById($id);
        if ($this->Question->delete()) {
            $this->Session->setFlash(__('Question Supprimer'));
            $this->redirect(array('controller'=>'questionnaires','action' => 'view',$question['Question']['questionnaire_id']));
        }
        $this->Session->setFlash(__('Question n\'ai pas supprimer'));
        $this->redirect(array('controller'=>'questionnaires','action' => 'view',$question['Question']['questionnaire_id']));
    }

    //fonction pour afficher les information dans le view du questionnaire 
    function getchoix($question_id) {
        $this->Question->Choix->recursive = -1;
        $choix = $this->Question->Choix->find('all', array('conditions' => array('Choix.question_id' => $question_id)));
        return $choix;
    }

    //Les statistiques Simple d'une questionnaire + fichier pour sphinex
    function state($questionnaire_id=null)
    {
        $questions=$this->Question->find('all',array('conditions'=>array('Question.questionnaire_id'=>$questionnaire_id)));
        $this->set('questions',$questions);
    }
    //fnction qui return Json de toutes les questions de toutes les questionnaire 
    //sauf selui qui est deja remple par l'utilisateur 
    function questionjson($user_id = null) {
        $date=  date('Y-m-d');
        $this->loadModel('User');
        $user=$this->User->findById($user_id);
        $questionnaires = $this->Question->Questionnaire->find('all',array('conditions'=>array("Questionnaire.reste>0","Questionnaire.date<='$date'")));
        echo '[';
        foreach ($questionnaires as $questionnaire)
        {
            $this->loadModel('Repense');
            $exist = $this->Repense->find('count', array('conditions' => array('Repense.user_id' => $user_id, 'Repense.question_id' => $questionnaire['Question'][0]['id'])));
            if ($exist == 0 && ($user['User']['sexe']==$questionnaire['Questionnaire']['sexe'] || $questionnaire['Questionnaire']['sexe']=="tous")) 
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
                                $questions = $this->Question->find('all', array('conditions' => array('Question.questionnaire_id' => $questionnaire['Questionnaire']['id'])));
                                foreach ($questions as $question) 
                                {
                                    $choixid1 = $choixid2 = $choixid3 = $choixid4 = $choixid5 = 'null';
                                    $choix1 = $choix2 = $choix3 = $choix4 = $choix5 = 'null';
                                    if (isset($question['Choix'][0]['id'])) {
                                        $choixid1 = $question['Choix'][0]['id'];
                                        $choix1 = $question['Choix'][0]['choix'];
                                    }
                                    if (isset($question['Choix'][1]['id'])) {
                                        $choixid2 = $question['Choix'][1]['id'];
                                        $choix2 = $question['Choix'][1]['choix'];
                                    }
                                    if (isset($question['Choix'][2]['id'])) {
                                        $choixid3 = $question['Choix'][2]['id'];
                                        $choix3 = $question['Choix'][2]['choix'];
                                    }
                                    if (isset($question['Choix'][3]['id'])) {
                                        $choixid4 = $question['Choix'][3]['id'];
                                        $choix4 = $question['Choix'][3]['choix'];
                                    }
                                    if (isset($question['Choix'][4]['id'])) {
                                        $choixid5 = $question['Choix'][4]['id'];
                                        $choix5 = $question['Choix'][4]['choix'];
                                    }
                                    echo '{
                                    "questionnaire_id":"' . $questionnaire['Questionnaire']['id'] . '",
                                    "id":"' . $question['Question']['id'] . '",
                                    "question":"' . $question['Question']['question'] . '",
                                    "type":"' . $question['Question']['type'] . '",
                                    "choix1":"' . $choix1 . '",
                                    "choixid1":"' . $choixid1 . '",
                                    "choix2":"' . $choix2 . '",
                                    "choixid2":"' . $choixid2 . '",
                                    "choix3":"' . $choix3 . '",
                                    "choixid3":"' . $choixid3 . '",
                                    "choix4":"' . $choix4 . '",
                                    "choixid4":"' . $choixid4 . '",
                                    "choix5":"' . $choix5 . '",
                                    "choixid5":"' . $choixid5 . '"
                                        },
                                    ';
                                }
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
    
    //Les statistiques Simple d'une questionnaire + fichier pour sphinex
    function avencer($user_id,$questionnaire_id)
    {
        $questions=$this->Question->Repense->find('all',array('conditions'=>array('Question.questionnaire_id'=>$questionnaire_id,'Repense.user_id'=>$user_id),'order' => array('Question.id' => 'ASC')));
        if($questions[0]['User']['sexe']=='H')
            $sexe='Homme';
        else
            $sexe='Femme';
        echo '
                <div class="usersinfo">
                    <img src="'.$questions[0]['User']['image'].'" style="float:right;width: 82px;height: 76px;margin-right:30px;">
                    <strong style="float:left;width:auto;margin-left:30px;font-size: 19px;">'.$questions[0]['User']['nom_complet'].'</strong><br>
                    <span style="float:left;width:auto;margin-left:30px;font-size: 17px;">'.$questions[0]['User']['age'].' ans</span><br>
                    <b style="float:left;width: auto;margin-left:30px;font-size: 14px;">'.$sexe.'</b>
                </div>';
        $numquestion=0;
        for($i=0;$i<count($questions);$i++) 
        {
            $numquestion++;
            if($questions[$i]['Question']['type']=='radio')
            {
                $radio=$this->requestAction("/choixes/getname/".$questions[$i]['Repense']['choix']);
                echo '<div class="input required" id="radio1">
                    <label >'.$numquestion.') '.$questions[$i]['Question']['question'].'</label>									
                    <div class="repenseradio1-0 repense radio0">
                        <input type="radio" name="'.$questions[$i]['Repense']['id'].'"  readonly checked="checked"><b id="repradio1-0" value="Réponse 1"> '.$radio.'</b>
                    </div> 
                </div>';
            }
            if($questions[$i]['Question']['type']=='texte')
            {
                echo '<div class="input required" id="text1">
                    <label >'.$numquestion.') '.$questions[$i]['Question']['question'].'</label>						
                    <input  type="text"  readonly value="'.$questions[$i]['Repense']['choix'].'">
                </div>';
            }
            if($questions[$i]['Question']['type']=='image')
            {
                echo '<div class="input required" id="text1">
                    <label >'.$numquestion.') '.$questions[$i]['Question']['question'].'</label>						
                    <img src="/pointcom/img/client/'.$questions[$i]['Repense']['choix'].'" width="450px" height="530px"/>
                </div>';
            }
            if($questions[$i]['Question']['type']=='case')
            {
                $radio=$this->requestAction("/choixes/getname/".$questions[$i]['Repense']['choix']);
                $case='<input type="checkbox" readonly="" checked="checked"><b>'.$radio.'</b>';
                $k=0;
                while ($k==0)
                {
                    if($i+1==count($questions))
                        break;
                    if($questions[$i+1]['Question']['id']==$questions[$i]['Question']['id'])
                    {
                        $i++;
                        $radio=$this->requestAction("/choixes/getname/".$questions[$i]['Repense']['choix']);
                        $case=$case.'<input type="checkbox" readonly="" checked="checked"><b>'.$radio.'</b>';
                    }
                    else
                        $k++;
                }
                echo '<div class="input required">
                            <label >'.$numquestion.') '.$questions[$i]['Question']['question'].'</label>						
                            <div class="repense repensecheck1-0 check0">
                                '.$case.'
                            </div>
                        </div>';
            }
        }
        exit();
    }
}
