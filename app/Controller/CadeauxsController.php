<?php
class CadeauxsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('liste', 'view','getcadeauxformobile');
    }

    public function isAuthorized($user) {
        if($user['role_user'] == "mobile" && ($this->action != 'delete' && $this->action != 'add' && $this->action != 'edit') ) {
            return true;
        }else {
            if($user['role_user'] == "admin" && ($this->action === 'delete' || $this->action === 'add' || $this->action === 'edit' || $this->action === 'view' || $this->action === 'liste' || $this->action === 'afficher')) {
                return true;
            }
            return false;
        }
        return parent::isAuthorized($user);
    }


    public function index() {
    }

    public function afficher($idMagasin) {
        $cadeau = $this->Cadeaux->getCadeau($idMagasin);
        $this->set('cadeau', $cadeau);
    }

    public function add() {
        if ($this->request->is('post')) {
            $ext = strtolower(pathinfo($this->request->data['Cadeaux']['url_image']['name'], PATHINFO_EXTENSION ));
            if(!empty($this->request->data['Cadeaux']['url_image']['tmp_name'])
                    && in_array($ext, array('jpeg', 'jpg', 'png')))
            {
                $data = $this->Cadeaux->maxid();
                $nomFile = $data[0][0]['max']+1;
                move_uploaded_file($this->request->data['Cadeaux']['url_image']['tmp_name'], IMAGES.'cadeaux'.DS.$nomFile.'.'.$ext);
                $this->request->data['Cadeaux']['url_image'] = $nomFile.'.'.$ext;
                $this->fctredimimage(75, 75, '../webroot/img/cadeauxmobile/', '', '../webroot/img/cadeaux/', $this->request->data['Cadeaux']['url_image']);
                $this->Cadeaux->create();
                if ($this->Cadeaux->save($this->request->data)) {
                    $this->Session->setFlash(__('Le cadeau a été sauvegardé !'));
                    return $this->redirect(array('action' => 'index'));
                }
                else {
                    $this->Session->setFlash(__('Le cadeau n\'a pas été sauvegardé. Merci de réessayer.'));
                }

            }

        }

    }

    public function liste() {
        $cadeaux = $this->Cadeaux->find('all',array('conditions'=>array('Cadeaux.type_cadeau is null'),'order'=>"point_cadeau asc"));
        $this->set('cadeaux', $cadeaux);
    }

    public function view($idMagasin) {
        $cadeau = $this->Cadeaux->getCadeau($idMagasin);
        $this->set('cadeau', $cadeau);
        if ($this->request->is('post')) {
            $ext = strtolower(pathinfo($this->request->data['Cadeaux']['url_img']['name'], PATHINFO_EXTENSION ));
            if(!empty($this->request->data['Cadeaux']['url_img']['tmp_name'])
                    && in_array($ext, array('jpeg', 'jpg', 'png'))) {
                $nomFile = $cadeau[0]['cadeaux']['url_image']; //debug($cadeau); echo $nomFile; debug($this->request->data); die();
                move_uploaded_file($this->request->data['Cadeaux']['url_img']['tmp_name'], IMAGES.'cadeauxProjet'.DS.$nomFile);
                //$this->request->data['Cadeaux']['url_img'] = $nomFile.'.'.$ext;
            }

            if ($this->Cadeaux->save($this->request->data)) {
                $this->Session->setFlash(__('Cadeau a été modifié'));
                return $this->redirect(array('controller' => 'cadeauxs', 'action' => 'liste'));
            }else {
                $this->Session->setFlash(__('Cadeau n\'a pas été modifié'));
            }
        }
    }

    public function delete($id) {
        if($this->Cadeaux->delete($id, true))
            $this->Session->setFlash(__('Cadeau a été supprimé'));
        else
            $this->Session->setFlash(__('Cadeau n\'a pas été supprimé'));
        return $this->redirect(array('controller' => 'usergifts', 'action' => 'liste'));
    }

    public function edit($id, $idUser, $idUHC) {
        $cadeau = $this->Cadeaux->find("first", array("conditions" => array("id_cadeaux" => $id), "recursive" => -1));
        $this->set('cadeau', $cadeau);
        $uhc = $this->Cadeaux->UserHasCadeaux->find("first", array("conditions" => array("id" => $idUHC), "recursive" => -1));
        $this->set('uhc', $uhc);
        $user = $this->Cadeaux->getUser($idUser);
        $this->set('user', $user);
        if ($this->request->is('post')) {
            if ($this->Cadeaux->save($this->request->data)) {
                $this->loadModel('User');
                if($this->request->data['Cadeaux']['etat'] == -1 && $uhc['UserHasCadeaux']['etat'] != -1) {
                    $this->User->save(array("id_user" => $user[0]["User"]["id_user"], "point" => ($user[0]["User"]["point"]+$cadeau["Cadeaux"]["point_cadeau"])));
                }
                if(($this->request->data['Cadeaux']['etat'] == 1 || $this->request->data['Cadeaux']['etat'] == 2) && $uhc['UserHasCadeaux']['etat'] == -1) {
                    if($user[0]["User"]["point"] >= $cadeau["Cadeaux"]["point_cadeau"]) {
                        $this->User->save(array("id_user" => $user[0]["User"]["id_user"], "point" => ($user[0]["User"]["point"] - $cadeau["Cadeaux"]["point_cadeau"])));
                    }else {
                        $this->Session->setFlash(__('Utilisateur n\'a pas suffisamment de points pour gagner ce cadeau'));
                        return;
                    }
                }
                $this->Cadeaux->UserHasCadeaux->save(array("id" => $this->request->data['Cadeaux']['id_uhc'], "etat" => $this->request->data['Cadeaux']['etat']));

                $email = $user[0]["User"]["email"];
                ini_set("SMTP", "smtp.menara.ma");
                ini_set("smtp_port", "25");
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail();
                $Email->config('email');
                $Email->template('cadeau', 'default')
                        ->viewVars(array('message' => $this->request->data['Cadeaux']['message']))
                        ->emailFormat('html')
                        ->to($email)
                        ->from('no-replay@proveille.com')
                        ->subject('Notification')
                        ->send();
                $this->Session->setFlash(__('Cadeau a été modifié'));
                return $this->redirect(array('controller' => 'usergifts', 'action' => 'liste'));
            }else {
                $this->Session->setFlash(__('Cadeau n\'a pas été modifié'));
            }
        }
    }





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
        // ---------------------------------------------------
    }

    function getcadeauxformobile($tel=null)
    {
        $this->Cadeaux->recursive = -1;
        $cadeaux = $this->Cadeaux->find('all',
                array('conditions'=>array('Cadeaux.type_cadeau is null'),'order'=>"point_cadeau asc limit 10"));

         if($tel!=null)
             echo '[';
         else
         {
             header("Content-type: text/xml");
            echo '<cadeaux>
            ';
         }        
        foreach ($cadeaux as $cadeau)
        {
            if($tel!=null)
            {
                echo '{
                        "Titre": "'.$cadeau['Cadeaux']['label_cadeau'].'",
                         "description": "'.$cadeau['Cadeaux']['desc'].' ",
                         "image":"http://myblan.com/img/cadeauxmobile/'.$cadeau['Cadeaux']['url_image'].'",
                         "point":"'.$cadeau['Cadeaux']['point_cadeau'].'"
                      },
                     ';
            }
            else
            {
                echo '
                    <cadeau>
                        <titre>'.$cadeau['Cadeaux']['label_cadeau'].'</titre>
                        <description>'.$cadeau['Cadeaux']['desc'].'</description>
                        <image>http://myblan.com/img/cadeauxmobile/'.$cadeau['Cadeaux']['url_image'].'</image>
                        <point>'.$cadeau['Cadeaux']['point_cadeau'].'</point>
                    </cadeau>
               ';
            }
        }
        if($tel!=null)
             echo ']';
         else
            echo '
            </cadeaux>';
        exit();
    }



}
