<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$datos=addslashes($datos); 
$res=DBUpIns("UPDATE skv_user_sessions SET datos='$datos' WHERE seekforID='$uid';");	

$cp="";
$darr=explode('|',$datos);
$cp=$darr[12];

if($cp){
$res=DBUpIns("UPDATE skv_user_sessions SET cp='$cp' WHERE seekforID='$uid';");		
}
?>