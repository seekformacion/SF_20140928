<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


global $v;
global $curs; global $sqlI; $sqlI=array();

include('/www/dbA.php');

$idp=$argv[1];

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



$urls=GetURLtoCACHE($idp);



?>