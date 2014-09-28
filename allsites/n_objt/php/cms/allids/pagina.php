<?php 

$appid[1]="676600425716555";
$appid[2]="586283288126818";
$appid[3]="726238200741616";
$appid[4]="1468920489988724";

$idcms=$v['where']['id'];


$inf=DBselect("select html from skf_cms where t_id=$idcms;");
if(array_key_exists(1, $inf)){$cms=$inf[1]['html'];}

$Datos['cms']=$cms;



$Datos['idp']=$v['where']['idp'];
$Datos['fbAPP']=$appid[$v['where']['idp']];
$Datos['pagTittle']=$v['where']['pagTittle'];
$Datos['imgLogo']=loadIMG("logo.png");
$Datos['home']="http://" . $v['where']['site'];
$Datos['homet']=$v['vars']['purlT'][$v['where']['idp']];

$Datos['footer']=loadChild('n_objt','footer');
$Datos['metas']=loadChild('n_objt','metas');
if($v['debugIN']>0){$Datos['dbi']="<div>" . $v['dbi'] . "</div>";}else{$Datos['dbi']="";}






?>