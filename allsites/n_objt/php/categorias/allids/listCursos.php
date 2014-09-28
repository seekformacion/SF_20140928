<?php
$bcursos=getBloqueCursos($v['where']['id']);
if(trim($bcursos)){$Datos['suma_cadaCurso']=$bcursos;}else{$Datos['codNULL']=1;};

?>