<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


include('/www/dbA.php');

$v['debug']=0;
$v['admin']=0;

$v['conf']['state']=1; # 1=test 2=produccion
$v['conf']['mode']=1; # 1=local 2=cloud

$v['path']['fw']=$v['path']['repo'] .	"/FrameW_1";
$v['path']['img']=$v['path']['repo'] .	"/img";

$v['path']['baseURLskin'][1]=""; ## baseURL del SKIN local
$v['path']['baseURLskin'][2]="http://s3-eu-west-1.amazonaws.com/seekf"; ## baseURL del SKIN en CLOUD


require_once $v['path']['fw'] . '/core/templates/paths.php';

includeCORE('db/dbfuncs');


$dcats=DBselectSDB("select * from rules",'frwrules');

print_r($dcats);

exec("ufw status");


?>