<?php
$del="";$keyw="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=0; 
require_once ('iniAJX.php');

//$id="";
//$res=DBselect("SELECT id FROM skf_txtDesc WHERE t_id=$idc;");
//if(array_key_exists(1, $res)){$id=$res[1]['id'];};

//if($id){
//$res=DBUpIns("UPDATE skf_txtDesc SET $campo='$cont' WHERE id=$id;");	
//}else{
//$res=DBUpIns("INSERT INTO skf_txtDesc (t_id,$campo) VALUES ($idc,'$cont');");		
//}

if($del){
$res=DBUpIns("DELETE FROM skf_cat_keywords WHERE id=$del;");	
$vals[1]=1;
}


if($keyw){$html ="";
$res=DBUpIns("INSERT INTO skf_cat_keywords (id_cat,keyword) VALUES ($idc,'$keyw');");
$pk=DBselect("select id, id_cat, keyword from skf_cat_keywords where id_cat=$idc ORDER BY LENGTH(keyword) DESC;");	

foreach ($pk as $key => $val) {$id=$val['id']; $kw=$val['keyword'];
$html .="<div id='$id' ondblclick='delKWD($id);' style='font-size:9px; border:1px solid #cccccc; padding: 3px; margin-top:3px; width: 169px'; class='color2_BG'>$kw</div>";	
}

$vals['html']=$html;		
}



echo json_encode($vals);
?>
