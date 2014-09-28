<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=$cat; 
require_once ('iniAJX.php');


if($mov){

$res=DBselect("SELECT superiores FROM skf_cats WHERE id=$mov limit 1;");	
$superiores=$res[1]['superiores']; echo "SELECT superiores FROM skf_cats WHERE id_sup=$mov limit 1;" ."\n";	
$superiores=$superiores . $mov . "|";

$res=DBselect("SELECT superiores FROM skf_cats WHERE id=$cat;");	
$sps=$res[1]['superiores']; echo "SELECT superiores FROM skf_cats WHERE id=$cat;" ."\n";	

$res3=DBselect("SELECT id, superiores FROM skf_cats WHERE id_sup=$cat;");	echo "SELECT id, superiores FROM skf_cats WHERE id_sup=$cat;" ."\n";
if(count($res3)>0){
foreach ($res3 as $kk => $val){
$oldS=$val['superiores']; $idcc=$val['id'];

$oldS=str_replace($sps, $superiores, $oldS);
$res=DBUpIns("UPDATE skf_cats SET superiores='$oldS' WHERE id=$idcc;");	 echo "UPDATE skf_cats SET superiores='$oldS' WHERE id=$idcc;" ."\n";
	
}	
}

	
$res=DBUpIns("UPDATE skf_cats SET id_sup='$mov', superiores='$superiores' WHERE id=$cat;");	
echo "UPDATE skf_cats SET id_sup='$mov', superiores='$superiores' WHERE id=$cat;" ."\n";	
}