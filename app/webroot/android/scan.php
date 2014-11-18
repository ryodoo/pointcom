<?php

include 'connection.php';

function get_mission_used($id_mission) {
    $sql=mysql_query("SELECT count(*) as Used FROM scan_qr
	      WHERE _id_mission='$id_mission' AND valider=1");
    $used=0;

    while($row = mysql_fetch_assoc($sql)) {

        $used=$row['Used'];

    }

    return $used;
}


//upadate le chemps point de mission
function updatemission($mission_id) {
    $sql=mysql_query("SELECT * FROM mission
	                  WHERE id_mission='$mission_id' ");
    while($resultat=mysql_fetch_assoc($sql)) {
        $credit=$resultat['point_offre'];
        $credit=$credit-$resultat['points_par_user'];
        $sql_update="UPDATE mission SET point_offre='$credit' WHERE id_mission='$mission_id'";
        mysql_query($sql_update);
    }
}

//fonction verification de etat de mission :
function Verification_mission($id_mission) {

    $sql=mysql_query("SELECT max_use,etat_mission FROM mission
	                  WHERE id_mission='$id_mission' ");

    while($resultat=mysql_fetch_assoc($sql)) {


        $used=get_mission_used($id_mission);
        $max_use=$resultat['max_use'];


    }
    if($max_use>$used) {
        return true;
    }else {
        return false;
    }

}


//fonction verification de validation :
function  Verification_Valider($id_scan_QR) {

    $sql=mysql_query("SELECT valider FROM scan_qr WHERE id_scan_QR='$id_scan_QR'");
    $valider=0;
    while($row = mysql_fetch_assoc($sql)) {

        $valider=$row['valider'];

    }

    return $valider;
}

function  Get_Point($id_user) {

    $sql=mysql_query("SELECT point FROM user WHERE id='$id_user'");
    $point=0;
    while($row = mysql_fetch_assoc($sql)) {

        $point=$row['point'];

    }

    return $point;
}
function Add_Point($id_user,$pts) {
    $point=Get_Point($id_user);
    $point=$point+$pts;
    $sql_update="UPDATE user SET point='$point' WHERE id='$id_user'";
    mysql_query($sql_update);

}

function GetMissionPoint($id_mission) {
    $sql=mysql_query("SELECT points_par_user FROM mission WHERE id_mission='$id_mission'");


    while($row = mysql_fetch_assoc($sql)) {

        $pts=$row['points_par_user'];

    }

    return $pts;
}

function Inbox($id_user,$date_envoi,$message,$vue) {
    $sql_insert="INSERT INTO inbox (id_user,date_envoi,message,vue)
	         VALUES ('$id_user','$date_envoi','$message','$vue')";
    mysql_query($sql_insert);
}

//reception :
if(isset($_POST) && !empty($_POST)) {

    extract($_POST);
    $id_scan_QR=$_POST["id_scan_QR"];
    $date_scan1=$_POST["date_scan1"];
    $_id_mission=$_POST["_id_mission"];
    $id_user=$_POST["id_user"];
    $sql_req=$_POST["sql_req"]; //1=> scan_code1 or 2=> scan_code2
    $type_mission=$_POST["type_mission"];
    $point=GetMissionPoint($_id_mission);
    $array_info[] = array('message'=>"True");
    $json=json_encode($array_info);
    print($json);


    if(Verification_mission($_id_mission)) {/////VERIFICATION ETAT MISSION BEGIN IF



        if($type_mission=="2") {//(2)TYPE MISSION = VISITER
            if($sql_req==1) {
                //SCAN CODE 1 :

                $sql_insert="INSERT INTO scan_qr (id_scan_QR,scan1,date_scan1,_id_mission,id_user)
	VALUES ('$id_scan_QR',1,'$date_scan1','$_id_mission','$id_user')";
                mysql_query($sql_insert);
            }else if($sql_req==2) {
                //SCAN CODE 2 :

                $sql_update="UPDATE scan_qr SET scan2='1', date_scan2='$date_scan1', valider='1'
	 WHERE id_scan_QR='$id_scan_QR'";
                mysql_query($sql_update);

                $valider=Verification_Valider($id_scan_QR);

                if($valider==1) {
                    Add_Point($id_user,$point);
                    $message="Bravo , vous avez gagner ".$point." pts";
                    updatemission($_id_mission);
                }
            }

        }else if($type_mission=="1" && $sql_req==1) {//(1)TYPE MISSION = ACHETER

//SCAN CODE 1 : 
            $sql_insert="INSERT INTO scan_qr (id_scan_QR,scan1,date_scan1,_id_mission,id_user,valider)
                    VALUES ('$id_scan_QR',1,'$date_scan1','$_id_mission','$id_user',1)";
            mysql_query($sql_insert);

            $valider=Verification_Valider($id_scan_QR);

            if($valider==1) {
                Add_Point($id_user,$point);
                $message="Bravo , vous avez gagner ".$point." pts";
                updatemission($_id_mission);

            }

        }

    }/////VERIFICATION ETAT MISSION FIN IF

}

?>