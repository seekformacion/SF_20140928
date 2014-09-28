<?php


$idpro=$v['where']['id_provi'];
$online=$v['where']['online'];
$distancia=$v['where']['distancia'];

$c=0;

$bacKurl=$v['where']['urlSimple'];

$lk='onclick="lK(\'' . $bacKurl . '\')"';	


$c=1;

if(!array_key_exists('search',$v)){
$bkn=$v['where']['Catsin'];
$bkn="<h2>" . strtoupper(substr($bkn, 0,1)) . substr($bkn, 1) . "</h2>";
$bk=$v['where']['csup']['url'];
$bk2='onclick="lK(\'' . $bk . '\')"';	
}else{
$bkn="<h2>". $v['where']['pagTittle'] ."</h2>";
$bk2='onclick="window.history.back();"';	
}

$rDatos['cadaquito'][$c]['quito']=$bkn;	
$rDatos['cadaquito'][$c]['lk']=$bk2;


if($idpro){$quito="<h2>" . "Presenciales / " . $v['vars']['provN'][$idpro] . "</h2>";$c++;}
if($online){$quito="<h2>" . "Online" . "</h2>";$c++; }
if($distancia){$quito="<h2>" . "A distancia" . "</h2>";$c++; }

if($c>1){
	
$rDatos['cadaquito'][$c]['quito']=$quito;	
$rDatos['cadaquito'][$c]['lk']=$lk;	


}







?>