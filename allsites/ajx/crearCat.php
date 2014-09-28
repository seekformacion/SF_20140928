<?php

$cat="";$url="";$codTittle="";$pagTittleC="";$crsTittle="";

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=$cat; 
require_once ('iniAJX.php');



if(($cat)&&($url)&&($codTittle)&&($pagTittleC)&&($crsTittle)){

$res=DBselect("SELECT superiores FROM skf_cats WHERE id_sup=$cat limit 1;");	
$superiores=$res[1]['superiores'];		
	
$res=DBUpIns("INSERT INTO skf_cats (idp,nom,id_sup,superiores) VALUES ($idp,'$pagTittleC',$cat,'$superiores');");	


$res3=DBselect("SELECT max(id) as lid from skf_cats;");	
$lid=$res3[1]['lid'];	

$res=DBUpIns("INSERT INTO skf_urls (idp,url,tipo,t_id,codTittle,pagTittle,pagTittleC,crsTittle) VALUES ($idp,'$url',1,$lid,'$codTittle','$pagTittleC','$pagTittleC','$crsTittle');");	

echo "INSERT INTO skf_urls (idp,url,tipo,t_id,codTittle,pagTittle,pagTittleC,crsTittle) VALUES ($idp,'$url',1,$lid,'$codTittle','$pagTittleC','$pagTittleC','$crsTittle');";	
}


 
