<?php

$urlSinpag=str_replace('.html', '', $v['where']['urlSimple']);

$pag=$v['where']['pag'];

$npags=$v['where']['npags'];

if($_SERVER['HTTP_X_UA_DEVICE']=='M'){
$lm=7;
$a=$pag-3;	
}else{
$lm=26;
$a=$pag-13;
}

if($a<=0){$a=1;}
$fin=$lm+$a;

if($fin>$npags){$fin=$npags;}

while($a <= $fin){
$rDatos['pag'][$a]['nump']=$a; 	

if($a==$pag){
$rDatos['pag'][$a]['cls']=" class='ptSel' ";
$rDatos['pag'][$a]['lk']="";

}else{
$rDatos['pag'][$a]['cls']="";	
$rDatos['pag'][$a]['lk']="onclick='lK(\"" . $urlSinpag . "-pag" . $a . ".html\")'";

};


$a++;}









if(($pag-1) >= 1){
$v['where']['prevURL']=str_replace('.html', '-pag' . ($pag-1) . '.html', $urlSinpag);
	


if(($pag-1) > 1){
			$nT=$v['where']['pagTittle'] . " pagina " . ($pag-1);
			$nU=$v['where']['prevURL'];

}else{
			$nT=$v['where']['pagTittle'];
			$nU=$urlSinpag;
};

$Datos['ppag']="<div class='iconos ipagin ipP' onclick='bnav(0);'></div><a href='$nU' class='bANT' title='$nT'>Anterior</a>";



$v['where']['Hprev']="	<a href='$nU' title='$nT' class='color'>$nT</a>
						<script>window.top.urlP='$nU';</script>		";

}else{
$Datos['ppag']=""; 

$v['where']['prevURL']="";	
$nT=$v['where']['pagTittle'];
$nU=$urlSinpag;
$v['where']['Hprev']="<a href='$nU' title='$nT' class='color'>$nT</a>
						<script>window.top.urlP='$nU';</script>		";


}

if(($pag+1) <= $v['where']['npags']){
$v['where']['nextURL']=str_replace('.html', '-pag' . ($pag+1) . '.html', $urlSinpag);


$nT=$v['where']['pagTittle'] . " pagina " . ($pag+1);
$nU=$v['where']['nextURL'];


$Datos['npag']="<div class='iconos ipagin ipN' onclick='bnav(1);'></div><a href='$nU' class='bSIG' title='$nT'>Siguiente</a>";


$v['where']['Hnext']="<a href='$nU' title='$nT' class='color'>$nT</a>
						<script>window.top.urlN='$nU';</script>		";


}else{
$Datos['npag']="";$v['where']['nextURL']="";
$v['where']['Hnext']="";
}




if($v['where']['npags']>1){
$Datos['TXT']="Página " . $v['where']['pag'] . " de " . $v['where']['npags'];
}else{
$Datos['TXT']="";	
}
$Datos['pag']=$v['where']['pag'];
$Datos['npags']=$v['where']['npags'];






?>