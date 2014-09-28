<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


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







include('funcSitemaps.php');  
require_once $v['path']['fw'] . '/core/templates/paths.php';

includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('templates/templates');
includeCORE('funcs/general');
//includeCORE('mail/mail');
includeFUNC('sacaCursos');

$acentros[278]=1;
$acentros[303]=1;
$acentros[305]=1;
$acentros[245]=1;
$acentros[314]=1;
$acentros[315]=1;
$acentros[417]=1;
$acentros[452]=1;
$acentros[451]=1;

$Lcentros="278,303,305,245,314,315,417,452,451";

$DOp=DBselectSDB("select distinct cur_cat as cat from skv_cursos where pccur > 10 AND id_centro IN ($Lcentros);",'seekformacion'); 	
if(count($DOp)>0){ foreach ($DOp as $key => $values) {$idCAT=$values['cat'];

$lcursos="";	
$cur=DBselectSDB("select id_cur from skv_relCurCats where id_cat=$idCAT AND showC=1;",'seekformacion'); 
if(count($cur)>0){ foreach ($cur as $key => $val) {$id=$val['id_cur']; $lcursos .=$id . ","; $cats[$id]=$idCAT;
}} $lcursos=substr($lcursos,0,-1);

$curs=ordenaCURs($lcursos,0,4);

if(count($curs)>0){ foreach ($curs as $key => $idcc) {
$Dcurr=DBselectSDB("SELECT idp, pagTittle, url FROM skf_urls WHERE tipo=2 AND t_id=$idcc;",'seekformacion'); 			
$idp=$Dcurr[1]['idp'];
$nomc=$Dcurr[1]['pagTittle'];
$urlC=$v['vars']['purl'][$idp] . $Dcurr[1]['url'];


$Dpre=DBselectSDB("SELECT pccur, id_centro FROM skv_cursos WHERE id=$idcc;",'seekformacion'); 
$pre=$Dpre[1]['pccur'];
$idcentro=$Dpre[1]['id_centro'];

if(($pre > 5)&&(array_key_exists($idcentro, $acentros))){
$idccat=$cats[$idcc];		
$Dcat=DBselectSDB("SELECT url FROM skf_urls WHERE tipo=1 AND t_id=$idccat;",'seekformacion');
$urlCAT=$v['vars']['purl'][$idp] . $Dcat[1]['url'];
DBUpInsSDB("INSERT INTO urls (id_curso,idp,nom,urlca,urlcu,peso) VALUES ('$idcc',$idp,'$nomc','$urlCAT','$urlC','$pre');",'SeekforFB');
}	

}}

}}


//$err=DBUpInsSDB("INSERT INTO skP_cupones (id_cent,id_cupon,fecha,id_curso,CPL) VALUES ($idcent,$idcupon,$date,$idcurso,'$CPL');",'seekpanel');		

?>