<?php

$uid=$_GET['uid'];
$cmp=$_GET['cmp'];
$val=$_GET['val'];
$cent=$_GET['centro'];

$val=addslashes($val);

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$result['res']=0;

$res=DBselect("SELECT id FROM skv_user_sessions WHERE seekforID='$uid';");
if(count($res)>0){
$res2=DBselect("SELECT nom_campo FROM skv_campos WHERE id='$cmp';");
if(count($res2)>0){
		
$id="";		
$res3=DBselect("SELECT id FROM skv_user_data_cent WHERE seekforID='$uid' AND id_campo=$cmp AND id_centro='$cent';");		
if(count($res3)>0){$id=$res3[1]['id'];}		

if($id){
DBUpIns("UPDATE skv_user_data_cent SET valor='$val' WHERE id=$id");	
}else{
DBUpIns("INSERT INTO skv_user_data_cent (seekforID,id_campo,id_centro,valor) VALUES ('$uid',$cmp,$cent,'$val');");	
}		

$result['res']=1;	
}}

echo json_encode($result);
?>