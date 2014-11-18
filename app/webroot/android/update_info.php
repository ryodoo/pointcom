<?php
include 'connection.php';
 echo 'eje';
mysql_query("SET NAMES UTF8");
$sql=mysql_query("SELECT * FROM maj");

$json=null;
while($resultat=mysql_fetch_assoc($sql)){
	$sortie[]=$resultat;
	$json=json_encode($sortie);
	echo $json;

}                       
echo ($json);



?>