<?php


require_once ('iniAJX.php');

if(isset($_GET['ip'])) {
    $ip=($_GET['ip'];

    DBUpInsSDB("INSERT INTO rules (tipo,ip) VALUES ('d','$ip');",'frwrules');

    echo $ip;
}


?>