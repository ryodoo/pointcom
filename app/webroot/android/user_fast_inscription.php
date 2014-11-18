<?php
//reception :
if(isset($_GET) && !empty($_GET)){

extract($_GET);

$id_mobile=$_GET["q"];
$type_mobile=$_GET["type_mobile"];

include 'connection.php';
$today = date("Y-m-d H:i:s");
$sql="INSERT INTO user (id_mobile,role_user,point,active,created,type_mobile) VALUES ('$id_mobile','Mobile',0,0,'$today','$type_mobile')";

mysql_query($sql);
$array_info[] = array('message'=>"True");
$json=json_encode($array_info);
print($json);



}




?>