<?php
set_time_limit(0);
ini_set("memory_limit", "-1");
include('/www/dbA.php');

//$dorest=$argv[1];


$v['debug']=1;
$v['admin']=0;
$v['debugIN']=0;
$v['where']['cacheQ']=0;


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

 
require_once $v['path']['fw'] . '/core/templates/paths.php';

includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('funcs/general');
includeCORE('funcs/phrassCount');





$dvals=engine_CAT(0,'diseno',1);

print_r($dvals);
insert_STR(1,0,'diseno',json_encode($dvals));






?>