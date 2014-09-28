<?php

function cursinf($cat){
$C="";	
$res2=DBselect("select count(distinct id_cur) as c from skv_relCurCats where id_cat=$cat OR id_cat IN (select id from skf_cats where superiores like '%|$cat|%');");
if(count($res2)>0){$C=$res2[1]['c'];};
return $C;	
}



foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');


$dat=DBselect("select * from skf_urls where t_id=$cat AND tipo IN (0,1);");


//print_r($dat);

$res=DBselect("select id, (select pagTittleC from skf_urls WHERE tipo IN (0,1) AND t_id=skf_cats.id) as nom from skf_cats where id_sup=$cat AND idp=$idp;");


$res2=DBselect("select id_sup from skf_cats where id=$cat AND idp=$idp;");

$url=$dat[1]['url'];$duplis="";
$urlsDUP=DBselect("select pagTittleC, url, t_id from skf_urls WHERE tipo IN (0,1) AND idp=$idp AND url='$url' AND t_id NOT IN ($cat);");


if(count($urlsDUP)>0){
foreach ($urlsDUP as $key => $value) {
$go='/ajx/gestCAT.php?cat=' . $value['t_id'] . '&idp=' . $idp;
$duplis.="<div style='color:red;'><a href='$go'>" . $value['pagTittleC'] . "</a></div>";	
}	
}

//print_r($res);

$CATES="";
foreach ($res as $key => $values) {$ncat=$values['nom']; $idsc=$values['id'];
$C=cursinf($idsc);
$CATES.="<div class='cat' onclick='goto($idp,$idsc,$cat)' >$ncat ($C)</div>";	
	
}


$catsup=$res2[1]['id_sup'];

?>


<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body >

<style>
.cat { position: relative; float:left; width:200px; height:30px; font-size:10px; font-family:Arial;  background-color:#DDDDDD; margin:2px; cursor:pointer;}
</style>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

<script>
function goto(idp,idc,catsup){
window.location.href ='/ajx/gestCAT.php?cat=' + idc + '&idp=' + idp + '&catsup=' + catsup;	
}

function update(id){
var idc=<?php echo $cat;?>	
var val=document.getElementById(id).value;

url = "/ajx/update.php?table=skf_urls&campo=" + id + '&value=' + val + '&idc=' + idc;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

});
});
	
}	

function fus(){
var fus=document.getElementById('fus').value;
var cat=document.getElementById('cate').value;


url = "/ajx/fusionCat.php?fus=" + fus + '&cat=' + cat;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

});
});

	
}



function mov(){
var mov=document.getElementById('mov').value;
var cat=document.getElementById('cate').value;


url = "/ajx/moverCat.php?mov=" + mov + '&cat=' + cat;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

});
});

	
}

function creaCat(){
var cat=document.getElementById('cate').value;	
var url=document.getElementById('url2').value;
var codTittle=document.getElementById('codTittle2').value;	
var pagTittleC=document.getElementById('pagTittleC2').value;
var crsTittle=document.getElementById('crsTittle2').value;	

url = "/ajx/crearCat.php?idp=<?php echo $idp;?>&url=" + url 
+ '&cat=' + cat 
+ '&codTittle=' + codTittle 
+ '&pagTittleC=' + pagTittleC 
+ '&crsTittle=' + crsTittle 
;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {

});
});


	
}




</script>




	



<div style="position : absolute; width:620px; left:37px; ">
	
<div style="position:relative; float: left; margin-left: 5px; width:100px;" class="cat"><a href="http://cursodecursos.com/ajx/gestCAT.php?cat=1&idp=1&catsup=0">Cursos</a></div>
<div style="position:relative; float: left; margin-left: 5px; width:100px;" class="cat"><a href="http://cursodecursos.com/ajx/gestCAT.php?cat=1183&idp=2&catsup=0">Masters</a></div>
<div style="position:relative; float: left; margin-left: 5px; width:100px;" class="cat"><a href="http://cursodecursos.com/ajx/gestCAT.php?cat=2365&idp=3&catsup=0">FP</a></div>
<div style="position:relative; float: left; margin-left: 5px; width:100px;" class="cat"><a href="http://cursodecursos.com/ajx/gestCAT.php?cat=3547&idp=4&catsup=0">Oposiciones</a></div>

<div style="clear:both;"></div>	
	
<div id="vol" class="cat" onclick='goto(<?php echo $idp . ',' . $catsup ;?>)'>Volver << </div>
<div style="clear:both;"></div>



<?php echo $CATES; ?>	
<div style="clear:both;"></div>

<div id="lcur"></div>

</div>


<div style="position : absolute; width:420px; left:660px; height: 623px; background-color:#DDDDDD; padding: 10px;  ">

<input  type="text" style="width:50px; font-size:10px; font-family: Arial;" id="cate" value="<?php echo $cat; ?>">

<input onchange="update(this.id)" type="text" style="width:420px; font-size:10px; font-family: Arial;" id="url" value="<?php echo $dat[1]['url']; ?>">

<div style="position: relative; margin-top: 10px; font-size:10px; font-family: Arial; left:4px;">title:</div>
<input onchange="update(this.id)" type="text" style="width:420px; font-size:10px; font-family: Arial;" id="codTittle" value="<?php echo $dat[1]['codTittle']; ?>">

<div style="position: relative; margin-top: 10px; font-size:10px; font-family: Arial; left:4px;">title CORTO:</div>
<input onchange="update(this.id)" type="text" style="width:420px; font-size:10px; font-family: Arial;" id="pagTittleC" value="<?php echo $dat[1]['pagTittleC']; ?>">

<div style="position: relative; margin-top: 10px; font-size:10px; font-family: Arial; left:4px;">title para CROSS:</div>
<input onchange="update(this.id)" type="text" style="width:420px; font-size:10px; font-family: Arial;" id="crsTittle" value="<?php echo $dat[1]['crsTittle']; ?>">

<?php echo $duplis;?>

<div style="position: absolute; top:350px;">fusionar a: <input type="text" style="width:50px;" id="fus" /> <div onclick="fus();" style="position:relative; float:left; left:170px; cursor:pointer; width: 30px; height:20px; background-color: orange"></div></div>
<div style="position: absolute; top:390px;">Mover dentro de: <input type="text" style="width:50px;" id="mov" /> <div onclick="mov();" style="position:relative; float:left; left:220px; cursor:pointer; width: 30px; height:20px; background-color: orange"></div></div>


<div style="position: absolute; top: 450px;">
	
<input  type="text" style="width:420px; font-size:10px; font-family: Arial;" id="url2" value="/">

<div style="position: relative; margin-top: 10px; font-size:10px; font-family: Arial; left:4px;">title:</div>
<input  type="text" style="width:420px; font-size:10px; font-family: Arial;" id="codTittle2" value="">

<div style="position: relative; margin-top: 10px; font-size:10px; font-family: Arial; left:4px;">title CORTO:</div>
<input  type="text" style="width:420px; font-size:10px; font-family: Arial;" id="pagTittleC2" value="">

<div style="position: relative; margin-top: 10px; font-size:10px; font-family: Arial; left:4px;">title para CROSS:</div>
<input type="text" style="width:420px; font-size:10px; font-family: Arial;" id="crsTittle2" value="">

<input type="button" style="width:420px; font-size:10px; font-family: Arial;" onclick="creaCat();" value="crear aqui">
</div>


</div>


</body></html>