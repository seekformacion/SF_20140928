<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


include('/www/dbH.php');

$v['debug']=0;
$v['admin']=0;

$v['conf']['state']=1; # 1=test 2=produccion
$v['conf']['mode']=1; # 1=local 2=cloud

$v['path']['bin']=$v['path']['repo'] .	"/SF_20140928";
$v['path']['fw']=$v['path']['repo'] .	"/FrameW_1";

$v['where']['view']=					'sitemaps'; #### ID DEL PORTAL PARA TABLA urls
$v['where']['id']=					    '1';

$v['path']['baseURLskin'][1]=""; ## baseURL del SKIN local
$v['path']['baseURLskin'][2]="http://s3-eu-west-1.amazonaws.com/seekf"; ## baseURL del SKIN en CLOUD


require_once $v['path']['fw'] . '/core/templates/paths.php';

includeCORE('db/dbfuncs');
$server=gethostname();

$dcats=DBselectSDB("select * from rules WHERE tipo='d' AND server='$server';",'laiislac_frwrules');
if(count($dcats)==0){
    DBUpInsSDB("INSERT INTO rules (server,tipo,ip,done) VALUES ('$server','d','x.x.x.x',1)",'laiislac_frwrules');
}

$dcats=DBselectSDB("select * from rules WHERE tipo='d' AND done=0 AND server='$server' ORDER BY id DESC limit 1;",'laiislac_frwrules');

if(count($dcats)>0){
    foreach ($dcats as $kk => $vals){
        $ip=$vals['ip']; $done=$vals['done']; $id=$vals['id'];

        $dcats2=DBselectSDB("select * from rules WHERE tipo='d' AND done=1 AND server='$server';",'laiislac_frwrules');
        if(count($dcats2)>0) {
            foreach ($dcats2 as $kk => $vals) {
                $ip2=$vals['ip']; $done2=$vals['done']; $id2=$vals['id'];
                exec("sudo ufw delete allow from $ip2");
                DBUpInsSDB("DELETE FROM rules WHERE id=$id2;",'laiislac_frwrules');
            }
        }

        exec("sudo ufw allow from $ip");
        DBUpInsSDB("UPDATE rules SET done=1 WHERE id=$id;",'laiislac_frwrules');
    }
}




?>