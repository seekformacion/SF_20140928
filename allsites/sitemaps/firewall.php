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


$dcats=DBselectSDB("select * from rules WHERE tipo='d' AND done=0;",'frwrules');

if(count($dcats)>0){
    foreach ($dcats as $kk => $vals){
        $ip=$vals['ip']; $done=$vals['done']; $id=$vals['id'];
        echo "\n" . exec("ufw allow from $ip") . "\n" ;

        $dcats2=DBselectSDB("select * from rules WHERE tipo='d' AND done=1;",'frwrules');
        if(count($dcats2)>0) {
            foreach ($dcats2 as $kk => $vals) {
                $ip2=$vals['ip']; $done2=$vals['done']; $id2=$vals['id'];
                echo "\n" . exec("ufw delete allow from $ip2") . "\n" ;
                DBUpInsSDB("DELETE FROM rules WHERE id=$id2;",'frwrules');
            }
        }

        DBUpInsSDB("UPDATE rules SET done=1 WHERE id=$id;",'frwrules');
    }
}

echo "\n" . exec("ufw status") . "\n" ;


?>