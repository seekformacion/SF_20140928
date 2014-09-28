<?php
header("content-type: application/json"); 

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$cp="";$ct="";
$res=DBselect("SELECT cp, ct FROM skv_user_sessions WHERE seekforID='$uid';");
if(count($res)>0){
$cp=$res[1]['cp']; $ct=$res[1]['ct'];	
}

if(!$cp){
$ip=getRealIpAddr();
$res= geo_ip($ip);

$cp=$res['cp'];
$ct=$res['ct']; $val['ins']=1;
$res=DBUpIns("UPDATE skv_user_sessions SET cp='$cp', cpo='$cp', ct='$ct' WHERE seekforID='$uid';");	
}

$val['cp']=$cp;
$val['ct']=$ct;

echo json_encode($val);


function geo_ip($ipaddress)
{
$buf="";	
$license_key="TsbcQPRGZjU0";#e
#$license_key="g9wRUqbb76W3";#b

$query = "http://geoip.maxmind.com/e?l=" . $license_key . "&i=" . $ipaddress;
$url = parse_url($query); echo $query;
$host = $url["host"];
$path = $url["path"] . "?" . $url["query"];
$timeout = 1;
$fp = fsockopen ($host, 80, $errno, $errstr, $timeout)
	or die('Can not open connection to server.');
if ($fp) {
  fputs ($fp, "GET $path HTTP/1.0\nHost: " . $host . "\n\n");
  while (!feof($fp)) {
    $buf .= fgets($fp, 128);
  }
  $lines = explode("\n", $buf);
  $data = $lines[count($lines)-1];
  fclose($fp);
} else {
  # enter error handing code here
}



$valores=explode(',',$data);

$res['ct']=$valores[0];
$cordenadas=$valores[3] . "," . $valores[4];

$exludecords['40.0000,-4.0000']=1;



if(($valores[0]=="ES")&&(!array_key_exists($cordenadas,$exludecords))){
$c = curl_init("http://maps.googleapis.com/maps/api/geocode/json?latlng=$cordenadas&sensor=false");
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$geodatos=json_decode($page,TRUE);

foreach ($geodatos['results'][0]['address_components'] as $id => $vals) {
if(array_key_exists('types', $vals)){
foreach ($geodatos['results'][0]['address_components'][$id]['types'] as $key => $value) {
if($value=='postal_code'){$res['cp']=$geodatos['results'][0]['address_components'][$id]['long_name'];}	;
}}}




}

return $res;
	
}


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
	
	if(strpos($ip,'92.168.1')>0){$ip="37.11.40.103";};
	if($ip=="127.0.0.1"){$ip="37.11.40.103";};
    return $ip;
}