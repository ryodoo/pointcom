<?php

include 'connection.php';

$sql=mysql_query("SELECT * FROM cadeaux ORDER BY point_cadeau ");

$json=null;
while($resultat=mysql_fetch_assoc($sql)){
	/*$sortie[]=$resultat;
	$json=json_encode($sortie);*/

	$id_cadeau=$resultat['id_cadeaux'];
	$label=$resultat['label_cadeau'];
	$url_image="http://myblan.com/img/cadeauxmobile/".$resultat['url_image'];
	$points=$resultat['point_cadeau'];
	$type_cadeau=$resultat['type_cadeau'];
	$recharge_id=$resultat['recharge_id'];
	
$array_info[] = array('id_cadeau'=>$id_cadeau,'label' => $label,'type_cadeau'=>$type_cadeau, 
	'recharge_id' => $recharge_id,'point' => $points,'url_image'=>$url_image);
   $json=json_encode($array_info);
	

}                       
if($json!=null){
	print($json);
}
else{
	echo "Cadeau not Existe !";
}



?>