<?php

include 'connection.php';
extract($_GET);

$user_id=$_GET["q"];

function get_mission_used($id_mission) {
    $sql=mysql_query("SELECT count(*) as Used FROM scan_qr
	      WHERE _id_mission='$id_mission' AND valider=1");
    $used=0;

    while($row = mysql_fetch_assoc($sql)) {

        $used=$row['Used'];

    }

    return $used;
}



$sql=mysql_query("SELECT * FROM mission,magasin 
	              WHERE mission._id_magasin = magasin.id_magasin 
	              AND etat_mission='Pending' and mission.date_offre <= CURRENT_DATE ORDER BY points_par_user DESC");

$json=null;
while($resultat=mysql_fetch_assoc($sql)) {
    $re=mysql_query("select count(*) as a from scan_qr where id_user=$user_id and _id_mission=".$resultat['id_mission']." and valider=1");
    $resulta=mysql_fetch_assoc($re);
    if($resulta["a"]==0) {
        $id_mission=$resultat['id_mission'];
        $used=get_mission_used($id_mission);
        $max_use=$resultat['max_use'];
        if($max_use>$used) {


            $desc_mission=$resultat['description'];
            $url_image="http://myblan.com/img/missionmobile/".$resultat['image'];
            $points=$resultat['points_par_user'];
            $type_mission=$resultat['type_offre'];


            $id_magasin=$resultat['_id_magasin'];
            $nom_mag=$resultat['nom_mag'];
            $type_mag=$resultat['type_mag'];
            $latitude_mag=$resultat['latitude_mag'];
            $longitude_mag=$resultat['longitude_mag'];
            $ville_mag=$resultat['ville'];

            $array_info[] = array('id_mission'=>$id_mission,'points' => $points,'desc_mission'=>$desc_mission,
                    'type_mission' => $type_mission,'max_use' => $max_use, 'used'=> $used,
                    'id_magasin'=>$id_magasin,'nom_mag'=>$nom_mag,'type_mag'=>$type_mag,'latitude_mag'=>$latitude_mag,
                    'longitude_mag'=>$longitude_mag,'ville_mag'=>$ville_mag, 'url_image'=>$url_image);
            $json=json_encode($array_info);


        }else if($max_use==$used) {
            $sql_update="UPDATE mission SET etat_mission='Finish' WHERE id_mission='$id_mission'";
            mysql_query($sql_update);
        }
    }

}                       
if($json!=null) {
    print($json);
}
else {
    $array_info[] = array('id_mission'=>"0",'points' =>"",'desc_mission'=>"",
            'type_mission' => "",'max_use' => "", 'used'=> "",
            'id_magasin'=>"",'nom_mag'=>"",'type_mag'=>"",'latitude_mag'=>"",
            'longitude_mag'=>"",'ville_mag'=>"", 'url_image'=>"");
    $json=json_encode($array_info);
    print($json);
}



?>