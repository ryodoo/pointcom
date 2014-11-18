<?php


include 'connection.php';

//verification scan 1 :
function  verification_scan($id_scan_qr){

$sql=mysql_query("SELECT scan1,scan2,valider FROM scan_qr 
                  WHERE id_scan_QR='$id_scan_qr' ");
$s1=0;
$s2=0;
$v=0;

$v_scan=$s1."_".$s2."_".$v;
while($row = mysql_fetch_assoc($sql))
  {
  
  $scan1=$row['scan1'];
  $scan2=$row['scan2'];
  $valider=$row['valider'];

   if($scan1==1){
    $s1="scan1";
   }else{
    $s1=0;
   }
   if($scan2==1){
    $s2="scan2";
   }else{
    $s2=0;
   }
   if($valider==1){
    $v="valider";
   }else{
    $v=0;
   }

  }


$v_scan=$s1."_".$s2."_".$v;


return $v_scan;

}



//reception :
if(isset($_GET) && !empty($_GET)){

extract($_GET);
//q=[iduser].[idmobile].[codeqr]
$q=$_GET["q"];
//q=28.359235049412991.2_1_2
$code=explode (".", $q);
$code_qr=$code[2];
$id_user=$code[0];
$id_mobile=$code[1];



if($code_qr!=null){


$sql=mysql_query("SELECT id_mission,type_offre,code_QR1,code_QR2,points_par_user,temps 
                  FROM mission WHERE code_QR1='$code_qr' OR code_QR2='$code_qr'");

$code_test=false;
$code=0;
$code_count=0;
$type_mission=0;
$points=0;
$v_s=0;
$temps=0;
while($row = mysql_fetch_assoc($sql))
  {
  $code_test=true;
  $type_mission=$row['type_offre'];
  $code_QR1=$row['code_QR1'];
  $code_QR2=$row['code_QR2'];
  $points=$row['points_par_user'];
  $id_mission=$row['id_mission'];
  $temps=$row['temps'];


  if($code_QR1==$code_qr){
  	$code=1;
  }else if($code_QR2==$code_qr){
  	$code=2;
  }

  if($type_mission=="visiter"){
  	$code_count=2;
    $type_mission="2";
  }else if($type_mission=="acheter"){
  	$code_count=1;
    $type_mission="1";
  }
  $id_scan_qr=$id_mission."_".$id_user."_".$id_mobile;
  $v_s=verification_scan($id_scan_qr);

  $array_info[] = array('id_mission'=>$id_mission,'code_test' => $code_test, 'type_mission' => $type_mission,
  	 'code_count' => $code_count, 'code'=> $code, 'points'=>$points,'temps'=>$temps, 'verification_scan'=>$v_s);
   $json=json_encode($array_info);



   
  }
  if($code_test){
  
   print ($json);
 

  }else {
  	 $array_info[] = array('id_mission'=>$id_mission,'code_test' => $code_test, 'type_mission' => $type_mission,
     'code_count' => $code_count, 'code'=> $code, 'points'=>$points,'temps'=>$temps, 'verification_scan'=>$v_s);
   $json=json_encode($array_info);
   print ($json);
  }


}
}



?>