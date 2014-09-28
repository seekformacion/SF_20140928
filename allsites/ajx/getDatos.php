<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$val['datos']="";

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');



$res=DBselect("SELECT datos FROM skv_user_sessions WHERE seekforID='$uid';");	
$val['datos']=$res[1]['datos']; 

echo json_encode($val);


?>	