<?php




function imgCATg($idcat){global $v;


$inf=DBselect("select superiores from skf_cats where id=$idcat;");

$sup=$inf[1]['superiores']; $sup=substr($sup, 1); $sup=str_replace('|', ',', $sup) .  $idcat; 	

$catsup[0]= array_reverse(explode(",",$sup));
	


$res=DBselect("SELECT rel_idc FROM skf_relCatsPort WHERE idc=$idcat;");	
foreach ($res as $key => $value) {$idcc=$value['rel_idc']; 

$inf=DBselect("select superiores from skf_cats where id=$idcc;");

if(array_key_exists(1,$inf)){
$sup=$inf[1]['superiores']; $sup=substr($sup, 1); $sup=str_replace('|', ',', $sup) .  $idcc;
} 	

$catsup[]= array_reverse(explode(",",$sup));	
}

$catsup=array_reverse($catsup);



foreach ($catsup as $key => $cats) { foreach ($cats as $ikey => $idimg) {

$donde=$v['path']['img'] . "/cats/g-idc-" . $idimg . ".*";		
$list = glob($donde); 
//echo $donde . "\n";	print_r($list); echo "\n";
if(count($list)>0){$opt[$ikey]=$idimg; $urls[$idimg]=str_replace($v['path']['img'], '', $list[0]); };	
}}
ksort($opt);
//print_r($catsup);
//print_r($opt);
//print_r($urls);
$first_value = reset($opt);
return $v['path']['baseURLskin'][$v['conf']['mode']] . '/img' . $urls[$first_value];
}

?>