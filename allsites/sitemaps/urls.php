<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


global $v;
global $curs; global $sqlI; $sqlI=array();

include('/www/dbA.php');

$homes[1]=1;
$homes[1183]=1;
$homes[2365]=1;
$homes[3547]=1;

$rvH[1]=1;
$rvH[2]=1183;
$rvH[3]=2365;
$rvH[4]=3547;

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

echo "\n\n";

######## homes

$dcats=DBselect("select idp, tipo, t_id, url, 
(select count(id) FROM skv_relCurCats WHERE id_cat=t_id AND showC=1) as C from skf_urls where tipo = 0 AND doSitemap=0 ORDER BY tipo, t_id ASC;");

if(count($dcats)>0){
foreach ($dcats as $key => $values) {
$mets=array();	
$c=$values['C']; $idc=$values['t_id']; $url=$values['url']; $tipo=$values['tipo']; $idp=$values['idp'];



if($c>0){$mets=getMET($idc,$idp);}
if($c==0){$c=getINF($idc);}

if($c>0){
if(!array_key_exists($idc, $homes)){	
doit($idp,$idc,$url,$c,$mets);	
}else{
$vvv=$v['vars']['purl'][$idp];$mets=array();	
doit($idp,$rvH[$idp],$vvv,0,$mets); 	
}}

}}
##################


$dcats=DBselect("select max(id) as M, min(id) as I from skf_urls where tipo=1;");

$min= $dcats[1]['I'];
$max= $dcats[1]['M'];

$a=$min;



while ($a <= $max){
$b=$a+200;
echo "recuperando hasta $b \n";
$dcats=DBselect("select idp, tipo, t_id, url, 
(select count(id) FROM skv_relCurCats WHERE id_cat=t_id AND showC=1) as C from skf_urls where id >= $a AND id < $b AND tipo=1 AND doSitemap=0 ORDER BY tipo, t_id ASC;");

if(count($dcats)>0){
foreach ($dcats as $key => $values) {
$mets=array();	
$c=$values['C']; $idc=$values['t_id']; $url=$values['url']; $tipo=$values['tipo']; $idp=$values['idp'];



if($c>0){$mets=getMET($idc,$idp);}
if($c==0){$c=getINF($idc);}

if($c>0){
if(!array_key_exists($idc, $homes)){	
doit($idp,$idc,$url,$c,$mets);	
}else{
$vvv=$v['vars']['purl'][$idp];$mets=array();	
doit($idp,$rvH[$idp],$vvv,0,$mets); 	
}}

}}
$a=$a+200;}


foreach ($curs as $idcur => $idp) {
$dcats=DBselect("select url from skf_urls where tipo=2 AND t_id=$idcur;");
if(array_key_exists('1', $dcats)){$url=$dcats[1]['url'];
		
doitC($idp,$idcur,$url);	
	
}}







DBUpIns("DELETE from util_sitemap;");

$maxI=count($sqlI);

$i=0;
while($i <= $maxI){
$b=0; $SQQ="";	
	while($b <= 500){
	if(array_key_exists($i, $sqlI)){$SQQ .=$sqlI[$i];};
	$b++;$i++;	
	}

$SQQ=substr($SQQ,0,-1);
echo "insertando hasta $i \n";
DBUpIns("INSERT INTO util_sitemap (tipo,idp,t_id,url,prior,date) VALUES $SQQ;");	
}



refressUCACHE();





?>