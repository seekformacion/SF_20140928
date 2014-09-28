<?php

if($debug){
echo "\n\nprocesaso especifico de 278 CEAC \n";
}

$B=$datos['brand'];

if($B=='TV'){$B='ceactele';}else{$B='ceac';}
$datos['brand']=$B;
$datos['salebrand']=$B;
?>