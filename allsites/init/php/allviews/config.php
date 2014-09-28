<?php

$v['dbi']=""; 
$v['conf']['resolution']['A']="1110";
$v['conf']['resolution']['B']="768";

$v['conf']['cpp']=10;
$v['conf']['limitENGINE']=50;

$v['path']['l_css']="/lskin/css"; #ruta httpd relativa para almacenar los css en test  (OJO CON LOS PERMISOS DE ESTOS DIRECTORIOS 777)
$v['path']['c_css']="/cskin/css"; #ruta httpd relativa para almacenar los css en produccion    (OJO CON LOS PERMISOS DE ESTOS DIRECTORIOS 777)

$v['path']['l_js']="/lskin/js"; #ruta httpd relativa para almacenar los js en test  (OJO CON LOS PERMISOS DE ESTOS DIRECTORIOS 777)
$v['path']['c_js']="/cskin/js"; #ruta httpd relativa para almacenar los js en produccion    (OJO CON LOS PERMISOS DE ESTOS DIRECTORIOS 777)


$v['path']['localBasePathimg']=	$v['path']['baseURLskin'][1] . "/img";
$v['path']['cloudBasePathimg']=	$v['path']['baseURLskin'][2] . "/img";

?>