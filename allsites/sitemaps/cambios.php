<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


global $v;


include('/www/dbA.php');
$v['debug']=0;
$v['admin']=0;
$v['conf']['state']=1; # 1=test 2=produccion
$v['conf']['mode']=1; # 1=local 2=cloud
$v['where']['idp']=						1; #### ID DEL PORTAL PARA TABLA urls
$v['where']['view']=					'sitemaps'; #### ID DEL PORTAL PARA TABLA urls
$v['where']['id']=					    '1'; 
$v['where']['site']=					"cursodecursos.com";
$v['path']['bin']=$v['path']['repo'] .	"/SF_20121104";
$v['path']['fw']=$v['path']['repo'] .	"/FrameW_1";
$v['path']['img']=$v['path']['repo'] .	"/SeekFormacion_images";
$v['path']['baseURLskin'][1]=""; ## baseURL del SKIN local
$v['path']['baseURLskin'][2]="http://s3-eu-west-1.amazonaws.com/seekf"; ## baseURL del SKIN en CLOUD

include('funcCambios.php');  
require_once $v['path']['fw'] . '/core/templates/paths.php';

includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('templates/templates');
includeCORE('funcs/general');

echo "\n\n";


######## cursos nuevos
$nue=DBselectSDB("SELECT id, act_id from skP_actions WHERE accion=1 AND done=0 ORDER BY datestamp",'seekpanel');
if(count($nue)>0){
foreach ($nue as $key => $value) {
$ida=$value['id']; $idcur=$value['act_id'];$err="";$err2="";
$err=DBUpInsSDB("INSERT INTO skv_cursos (id) VALUES ($idcur);",'seekformacion');
$err2=DBUpInsSDB("INSERT INTO skf_urls (t_id,tipo) VALUES ($idcur,2);",'seekformacion');

echo "CREO $idcur" .  $err . " : \n";
	$eid="";
	if((!trim($err))&&(!trim($err2))){
	$eid=updtCUR($idcur);
	if(!$eid){
	$err=DBUpInsSDB("UPDATE skP_actions SET done=1 WHERE id=$ida;",'seekpanel');	
	}		
	}
}}

##############3


######## cursos modificados
$nue=DBselectSDB("SELECT id, act_id from skP_actions WHERE accion=5 AND done=0 ORDER BY datestamp",'seekpanel');
if(count($nue)>0){
foreach ($nue as $key => $value) {
$ida=$value['id']; $idcur=$value['act_id'];$err="";$err2="";
echo "Modif $idcur" .  $err . " : \n";
	$eid="";
	$eid=updtCUR($idcur);
	if(!$eid){
	$err=DBUpInsSDB("UPDATE skP_actions SET done=1 WHERE id=$ida;",'seekpanel');	
	}		
	
}}

##############3









######## cursos borrar
$nue=DBselectSDB("SELECT id, act_id from skP_actions WHERE accion=4 AND done=0 ORDER BY datestamp",'seekpanel');
if(count($nue)>0){
foreach ($nue as $key => $value) {
$ida=$value['id']; $idcur=$value['act_id'];$err="";$err2="";
echo "Borra $idcur" .  $err . " : \n";
	$eid="";
	$eid=borraCUR($idcur);
	if(!$eid){
	$err=DBUpInsSDB("UPDATE skP_actions SET done=1 WHERE id=$ida;",'seekpanel');	
	}		
	
}}

##############3



######## cursos showC
$nue=DBselectSDB("SELECT id, act_id from skP_actions WHERE accion=2 AND done=0 ORDER BY datestamp",'seekpanel');
if(count($nue)>0){
foreach ($nue as $key => $value) {
$ida=$value['id']; $idcur=$value['act_id'];$err="";$err2="";
echo "showC $idcur" .  $err . " : \n";
	$eid="";
	$eid=showCCUR($idcur);
	if(!$eid){
	$err=DBUpInsSDB("UPDATE skP_actions SET done=1 WHERE id=$ida;",'seekpanel');	
	}
	
	$urls=DBselectSDB("SELECT idp, url FROM skf_urls WHERE tipo=2 AND t_id=$idcur;",'seekformacion');
	if(count($urls)>0){$urlB=$urls[1]['url']; $idport=$urls[1]['idp'];
	
	$urlB=$v['vars']['purl'][$idport] . $urlB;
	
	$err=DBUpInsSDB("INSERT INTO util_sitemap (idp,tipo,t_id,url,prior,date) VALUES ($idport,2,$idcur,'$urlB',0,0);",'seekformacion');		
	}		
	
}}

##############3



?>