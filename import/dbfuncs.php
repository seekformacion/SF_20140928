<?php


function DBselect($queryp){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$v['conf']['db']);
if (!$dbnivel->open()){die($dbnivel->error());};

$dbnivel->query($queryp);

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();

$cuenta=0;
while ($row = $dbnivel->fetchassoc()){$cuenta++;foreach($row as $campo => $valor){$resultados[$cuenta][$campo]=$valor;};};



if (!$dbnivel->close()){die($dbnivel->error());};	


return $resultados;	
}



function DBselectSDB($queryp,$dbsel){
	
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$dbsel);
if (!$dbnivel->open()){die($dbnivel->error());};

$dbnivel->query($queryp);

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();

$cuenta=0;
while ($row = $dbnivel->fetchassoc()){$cuenta++;foreach($row as $campo => $valor){$resultados[$cuenta][$campo]=$valor;};};



if (!$dbnivel->close()){die($dbnivel->error());};	


return $resultados;	
	
	
	
}



function DBUpInsSDB($queryp,$dbsel){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$dbsel);
if (!$dbnivel->open()){die($dbnivel->error());};


$dbnivel->query($queryp);

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();
$error=$dbnivel->error();

if (!$dbnivel->close()){die($dbnivel->error());};	

return $error;	
}




function DBUpIns($queryp){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$v['conf']['db']);

if (!$dbnivel->open()){die($dbnivel->error());};



$dbnivel->query($queryp);

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();


if (!$dbnivel->close()){die($dbnivel->error());};	

	
}



function DBUpInsL($queryp){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$v['conf']['db']);
if (!$dbnivel->open()){die($dbnivel->error());};


$dbnivel->query($queryp);

$queryp="SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();


if (!$dbnivel->close()){die($dbnivel->error());};	

return $id;	
}


function DBUpInsLSDB($queryp,$dbsel){
global $v;$resultados=array();

$dbnivel=new DB($v['conf']['host'],$v['conf']['usr'],$v['conf']['pass'],$dbsel);
if (!$dbnivel->open()){die($dbnivel->error());};


$dbnivel->query($queryp);

$queryp="SELECT LAST_INSERT_ID() as id;";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$id=$row['id'];};

if($v['debug']==-1){echo $queryp . "    <br>\n";}
echo $dbnivel->error();


if (!$dbnivel->close()){die($dbnivel->error());};	

return $id;	
}



?>