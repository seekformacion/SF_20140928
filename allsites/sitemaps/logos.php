<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


global $v;
include('/www/dbA.php');

$excludes['seekformacion.com']=1;
$excludes['publiactive.es']=1;
$excludes['publiactive.net']=1;
$excludes['skin.php']=1;
$excludes['sitemap.xml']=1;


######### portales
$myDirectory=str_replace("/" . $v['where']['site'],'',$v['path']['httpd']);
echo "\n";
foreach(glob("$myDirectory/*") as $file) {
$file=str_replace($myDirectory . "/", '', $file);
if(!array_key_exists($file, $excludes)){$sites[]=$file;}
}

//print_r($sites);


######### img p
$myDirectory=$v['path']['repo'] .	"/SeekFormacion_images/global/logos/p";
echo "\n";
foreach(glob("$myDirectory/*") as $file) {
$file=str_replace($myDirectory, '/img/global/logos/p', $file);
$logos[]=$file;
}




######### img G
$myDirectory=$v['path']['repo'] .	"/SeekFormacion_images/global/logos/g";
echo "\n";
foreach(glob("$myDirectory/*") as $file) {
$file=str_replace($myDirectory, '/img/global/logos/g', $file);
$logos[]=$file;
}

//print_r($logos);



foreach ($sites as $key => $dom) {foreach ($logos as $key2 => $path) {
		
exec("varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $dom && req.url == $path\"") . "\n";
echo "varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $dom && req.url == $path\"" . "\n";

usleep(400000);
//echo "GET: \n";
$url="http://" . $dom . $path;	
$content = file_get_contents($url);			
echo $url. "\n";		
	
}}


?>