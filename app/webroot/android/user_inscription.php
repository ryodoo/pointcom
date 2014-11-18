<?php


if(isset($_POST) && !empty($_POST))
{

extract($_POST);

		
		header("Location: myblan.com/users/addformmobile");
		exit();
header("Location: myblan.com/users/addfrommobile?nom_complet=$nom_complet&email=$email&password=$password&sexe=$sexe&age=$age&ville=$ville&id_user=$id_user");

}

?>