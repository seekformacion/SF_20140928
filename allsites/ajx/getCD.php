<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');



$res=DBselect("SELECT id_campo, valor FROM skv_user_data WHERE seekforID='$uid';");	
if(count($res)>0){foreach($res as $pp => $vals){
$val[$vals['id_campo']]=$vals['valor']; 

}}else{
$val['none']=1;	
}

echo json_encode($val);


?>	