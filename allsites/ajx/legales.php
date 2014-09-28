<?php

$cents=$_GET['cents'];
$uid=$_GET['uid'];

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php'); 

$res=DBselect("SELECT id, legal, id_centro FROM skv_centros_legales WHERE id_centro IN ($cents);");
if(count($res)>0){
	
echo '<style>
body{font-size:9px; color:#888888; font-family:Arial;}

h1{font-size:9px;}
h2{font-size:9px;}

p {text-align:justify; display:block; position:relative; float:left;}
.ckbLeg {position:relative; float:left;}

</style>
<body>';	
	
foreach ($res as $kk => $vals){$legal=$vals['legal']; $idcent=$vals['id_centro'];

$legal=str_replace('df_', "df_$idcent" . "_", $legal);

$res3=DBselect("SELECT id, id_campo, valor FROM skv_user_data_cent WHERE seekforID='$uid' AND id_centro='$idcent';");		
if(count($res3)>0){foreach($res3 as $pp => $vals){$cmp=$vals['id_campo']; $valor=$vals['valor'];

	if(($cmp==29)||($cmp==30)||($cmp==31)||($cmp==38)){
	if($valor==1){$legal=str_replace("df_$idcent" . "_$cmp\"","df_$idcent" . "_$cmp\" checked" , $legal);}	
	}		
	
	
}}	


echo $legal;
echo "<p>____________________________________________________________________</p> <br>";
}

echo '</body>';
}
?>