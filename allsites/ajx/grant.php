<?php


require_once ('iniAJX.php');

if(isset($_GET['ip'])) {
    $ip=$_SERVER['REMOTE_ADDR'];

    DBUpInsSDB("INSERT INTO rules (tipo,ip) VALUES ('d',$ip);",'frwrules');

    echo $ip;
}


?>