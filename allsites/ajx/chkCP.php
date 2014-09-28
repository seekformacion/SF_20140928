<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');


if($cp){
	
$res=DBselect("SELECT id FROM skv_user_sessions WHERE seekforID='$uid';");
if(count($res)>0){	
DBUpIns("UPDATE skv_user_sessions SET cp='$cp' WHERE seekforID='$uid';");		
$result['ok']=1;
echo json_encode($result);
}

}
?>