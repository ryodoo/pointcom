<?php
include 'connection.php';
//reception :
if(isset($_GET) && !empty($_GET)){

extract($_GET);

$id_mob=$_GET["id_mobile"];

if($id_mob!=null)
{

$sql=mysql_query("SELECT id,active FROM user WHERE id_mobile='$id_mob'");
$json=null;
$array_info[] = array('id_user'=>"null",'active' =>'0');
while($resultat=mysql_fetch_assoc($sql))
{
	$array_info=null;
	$array_info[] = array('id_user'=>$resultat['id'],'active' => $resultat['active']);
}
	$json=json_encode($array_info);
	print($json);
}
}
?>