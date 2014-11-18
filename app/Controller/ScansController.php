<?php
App::uses('AppController', 'Controller');

class ScansController extends AppController 
{
    public function isAuthorized($user) {
        if($user['role_user'] != "mobile") {
            return false;
        }
        return parent::isAuthorized($user);
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('scancodeqr');
    }
    
    public function scancodeqr()
    {
        $x=$_POST["x"];
        $y=$_POST["y"];
        $mobile_id=$_POST["mobile_id"];
        $codeQr=$_POST["codeQr"];
        $this->loadModel('Mission');
        $this->Mission->recursive = -1;
        $mission=$this->Mission->find('all',array('conditions'=>array("Mission.qr1='$codeQr' OR Mission.qr2='$codeQr'")));
        if(empty ($mission))
        {
            echo "Mission n'existe pas ";
            exit ();
        }
        
        $this->loadmodel('User');
        $this->User->recursive = -1;
        $user=$this->User->findByIdMobile($mobile_id);
        $user_id=$user['User']['id'];
        $this->Scan->recursive = -1;
        $qr=$this->Scan->find('all',array('conditions'=>array('Scan.user_id'=>$user_id,'Scan.mission_id'=>$mission[0]['Mission']['id'])));
        if(!empty ($qr) && $qr[0]['Scan']['valider']==1)
        {
            echo 'vous avez déjà fais cette mission';
            exit();
        }
        if($mission[0]['Mission']['reste']<1)
        {
            echo 'Mission Terminer';
            exit();
        }
        //caluler la destance entre deux point le point de le scan et le point de la mission
        $destance=$this->calculedestance($y,$x,$mission[0]['Mission']['longitude'] , $mission[0]['Mission']['latitude']);
        if($destance>200)
        {
            echo "Vous n'étes pas dans le bon endroit pour scané cette mission";
            exit();
        }
        //(Mission Achat) Ajout de point pour user ,demunier les points pour mission ajout dans scans 
        if($mission[0]['Mission']['type']=='achat')
        {
            $data['Scan']['date_scan1']=date("Y-m-d H:i:s");
            $data['Scan']['scan1']=1;
            $data['Scan']['valider']=1;
            $data['Scan']['user_id']=$user_id;
            $data['Scan']['mission_id']=$mission[0]['Mission']['id'];
            $this->Scan->save($data);
            $point=$mission[0]['Mission']['point/client']+$user['User']['point'];
            $this->User->id=$user_id;
            $this->User->saveField('point',$point);
            $point=$mission[0]['Mission']['reste']-1;
            $this->Mission->id=$mission[0]['Mission']['id'];
            $this->Mission->saveField('reste',$point);
            echo 'Filicitation Mission Valider';
            exit();
        }
        //(Mission Visite) Ajout de point pour user ,demunier les points pour mission ajout dans scans 
        if(empty ($qr))
        {
            $data['Scan']['date_scan1']=date("Y-m-d H:i:s");
            $data['Scan']['scan1']=1;
            $data['Scan']['valider']=0;
            $data['Scan']['user_id']=$user_id;
            $data['Scan']['mission_id']=$mission[0]['Mission']['id'];
            $this->Scan->save($data);
            echo $mission[0]['Mission']['temps'];
            exit();
        }
        $mission=$this->Mission->find('all',array('conditions'=>array("Mission.qr2"=>$codeQr)));
        if(empty ($mission))
        {
            echo 'Vous devez scané QR2';
            exit();
        }
        if(!empty ($qr))
        {
            $duree=$this->nbmin($qr[0]['Scan']['date_scan1'], date("Y-m-d H:i:s"));
            if($duree<$mission[0]['Mission']['temps'])
            {
                $reste=$duree - $mission[0]['Mission']['temps'];
                echo "Il vous reste $reste min avant la validation du mission";
                exit();
            }
            $qrId=$this->Scan->find('first',array('conditions'=>array("Scan.user_id"=>$user_id,
                "Scan.mission_id"=>$mission[0]['Mission']['id'])));
            $this->Scan->id=$qrId['Scan']['id'];
            $data['Scan']['date_scan2']=date("Y-m-d H:i:s");
            $data['Scan']['scan2']=1;
            $data['Scan']['valider']=1;
            $this->Scan->save($data);
            $point=$mission[0]['Mission']['point/client']+$user['User']['point'];
            $this->User->id=$user_id;
            $this->User->saveField('point',$point);
            $point=$mission[0]['Mission']['reste']-1;
            $this->Mission->id=$mission[0]['Mission']['id'];
            $this->Mission->saveField('reste',$point);
            echo 'Filicitation Mission Valider';
            exit();
        }
        exit();
    }


    function calculedestance($lat1,$lng1,$lat2,$lng2)
    {
          $earthRadius = 3958.75;
          $dLat = deg2rad($lat2-$lat1);
          $dLng = deg2rad($lng2-$lng1);
          $a = sin($dLat/2) * sin($dLat/2) +
          cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
          sin($dLng/2) * sin($dLng/2);
          $c = 2 * atan2(sqrt($a), sqrt(1-$a));
          $dist = $earthRadius * $c;
          $meterConversion = 1609;
          return ($dist * $meterConversion);
    }

    function nbmin($datedebut,$datefin)
    {
        $date1 = strtotime($datefin);
        $date2 = strtotime($datedebut);
        $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        return round(($diff / 60), 2);

    }


}
