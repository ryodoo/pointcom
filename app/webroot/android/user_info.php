<?php

//reception :
include 'connection.php';
if(isset($_GET) && !empty($_GET)){

extract($_GET);

$id_mob=$_GET["id_mobile"];

//$id_mob='000000000000000';
if($id_mob!=null){

$sql=mysql_query("SELECT id,active,nom_complet,point FROM user WHERE id_mobile='$id_mob'");
$json=null;
$array_info[] = array('id_user'=>"null");
while($resultat=mysql_fetch_assoc($sql))
{
	$array_info=null;
	$array_info[] = array('id_user'=>$resultat['id'],'nom_complet' => $resultat['nom_complet'],'active' => 		   	$resultat['active'],'point' => $resultat['point']);
}
$json=json_encode($array_info);
print($json);

}
}





?>