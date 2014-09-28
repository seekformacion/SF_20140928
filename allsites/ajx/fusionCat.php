<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=$cat; 
require_once ('iniAJX.php');


if($fus){
$res=DBUpIns("UPDATE skv_relCurCats SET id_cat='$fus' WHERE id_cat=$cat;");
$res=DBUpIns("UPDATE skf_relCatsPort SET rel_idc='$fus' WHERE rel_idc=$cat;");	


$res2=DBselect("SELECT rel_idc FROM skf_relCatsPort WHERE idc=$cat;");	
if(count($res2)>0){
$ins="INSERT INTO skf_relCatsPort (idc,rel_idc) VALUES ";		
foreach ($res2 as $ky => $val){$dcc=$val['rel_idc'];
$ins.="($fus,$dcc),";
}}	
$ins=substr($ins, 0,-1) . ";";

$res=DBUpIns($ins);		

$res=DBUpIns("DELETE FROM skf_cats WHERE id=$cat;");		
$res=DBUpIns("DELETE FROM skf_relCatsPort WHERE idc=$cat;");	
$res=DBUpIns("DELETE FROM skf_urls WHERE t_id=$cat AND tipo=1;");	
}