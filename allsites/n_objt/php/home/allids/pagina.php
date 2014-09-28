<?php 

includeFUNC('categorias');
includeFUNC('sacaCursos');
includeFUNC('images');

$appid[1]="676600425716555";
$appid[2]="586283288126818";
$appid[3]="726238200741616";
$appid[4]="1468920489988724";


$lnda[1]="¿Qué tipo de curso estás buscando?";
$lnda[2]="¿Qué tipo de master te gustaría estudiar?";
$lnda[3]="¿Qué tipo de grado esás buscando?";
$lnda[4]="¿En que sector te gustaría opositar?";

$Datos['lnda']=$lnda[$v['where']['idp']];

$idcat=$v['where']['id'];
catsINF($idcat);


$Datos['idp']=$v['where']['idp'];
$Datos['fbAPP']=$appid[$v['where']['idp']];
$Datos['pagTittle']=$v['where']['pagTittle'];
$Datos['imgLogo']=loadIMG("logo.png");
$Datos['home']="http://" . $v['where']['site'];
$Datos['homet']=$v['vars']['purlT'][$v['where']['idp']];

$Datos['port']="";

$llK="onclick='lK(\"" . $v['vars']['purl'][1] . "\");'";
if($v['where']['idp']==1){$selP="sel";$llK="";}else{$selP="";}
$Datos['port'].="<div class='pTal $selP' $llK>Cursos</div>";

$llK="onclick='lK(\"" . $v['vars']['purl'][2] . "\");'";
if($v['where']['idp']==2){$selP="sel";$llK="";}else{$selP="";}
$Datos['port'].="<div class='pTal $selP' $llK>Masters</div>";

$llK="onclick='lK(\"" . $v['vars']['purl'][3] . "\");'";
if($v['where']['idp']==3){$selP="sel";$llK="";}else{$selP="";}
$Datos['port'].="<div class='pTal $selP' $llK>Grados</div>";

$llK="onclick='lK(\"" . $v['vars']['purl'][4] . "\");'";
if($v['where']['idp']==4){$selP="sel";$llK="";}else{$selP="";}
$Datos['port'].="<div class='pTal $selP' $llK>Oposiciones</div>";


$Datos['banner']=loadIMG("banner.jpg");

$Datos['catsinf']=loadChild('n_objt','catsinf');





//$Datos['listCursos']=loadChild('objt','listCursos');

//$Datos['topCurH']=loadChild('objt','topCurH');


//$Datos['descTXTcat']=loadChild('objt','descTXTcat');
//$Datos['adW_LD']=loadChild('objt','adW_LD');


//$Datos['tod_CUR']=loadChild('objt','tod_CUR');
//$Datos['bloqueGEO']=loadChild('objt','bloqueGEO');
//$Datos['bloqueONLINE']=loadChild('objt','bloqueONLINE');
//$Datos['bloqueDISTANCIA']=loadChild('objt','bloqueDISTANCIA');


//$Datos['masCATS']=loadChild('objt','masCATS');
//$Datos['fblike']=loadChild('objt','fblike');

//$Datos['navBAR']=loadChild('objt','navBAR');

//$Datos['header']=loadChild('objt','header');
//$Datos['footer']=loadChild('objt','footer');
//$Datos['emergentes']=loadChild('objt','emergentes');



$Datos['insignias']=loadChild('n_objt','insignias');
$Datos['footer']=loadChild('n_objt','footer');

$Datos['metas']=loadChild('n_objt','metas');
if($v['debugIN']>0){$Datos['dbi']="<div>" . $v['dbi'] . "</div>";}else{$Datos['dbi']="";}






?>