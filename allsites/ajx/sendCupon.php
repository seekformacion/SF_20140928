<?php

$uid=$_GET['uid'];
$cursos=$_GET['cursos'];

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$res=DBselect("SELECT id FROM skv_user_sessions WHERE seekforID='$uid';");
if(count($res)>0){

	
$res2=DBselect("SELECT id, id_centro FROM skv_cursos WHERE id IN ($cursos);");
if(count($res2)>0){foreach ($res2 as $point => $valc){$idc=$valc['id']; $idcent=$valc['id_centro'];
$resu[$idc]=$idcent;	
}}
	
$idcupon=DBUpInsL("INSERT INTO skf_datCupon (seekforID) VALUES ('$uid');");
$resu2['ok']=$idcupon;

foreach ($resu as $idcur => $idcent) {
DBUpIns("INSERT INTO skf_datCupon_cur (id_dat_cupon,cent,cur) VALUES ($idcupon,$idcent,$idcur);");	
}
	
echo json_encode($resu2);	
}