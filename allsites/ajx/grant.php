<?php


require_once ('iniAJX.php');

if(isset($_GET['ip'])) {if(strlen($_GET['ip'])>6){
    $ip=$_GET['ip'];

    $lastID=DBUpInsLSDB("INSERT INTO rules (tipo,ip) VALUES ('d','$ip');",'frwrules');

    echo $ip;
}}


?>