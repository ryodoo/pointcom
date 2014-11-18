<?php

include 'connection.php';

//reception :
if(isset($_GET) && !empty($_GET)){

extract($_GET);

$id_scan_qr=$_GET["id_scan"];

//$id_mob='000000000000000';
if($id_scan_qr!=null){




$sql=mysql_query("SELECT * FROM scan_qr WHERE id_scan_QR='$id_scan_qr'");
$json=null;
while($resultat=mysql_fetch_assoc($sql)){
	$sortie[]=$resultat;
	$json=json_encode($sortie);

}
if($json!=null){
	print($json);
}
else{
$array_info[] = array('scan1'=>"0");
$json=json_encode($array_info);
	print($json);
}


}
}



?>