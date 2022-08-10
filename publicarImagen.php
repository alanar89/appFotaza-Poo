<?php
session_start();
require_once("ClassPublicacion.php");
require_once("ClassEtiqueta.php");
$titulo=$_POST['titulo'];
$categoria=$_POST['categoria'];
$estado=$_POST['estado'];
$derechoUso=$_POST["duso"];
$et1=$_POST['et1'];
$et2=$_POST['et2'];
$et3=$_POST['et3'];
$fecha= date("y/m/d");
$usuario=$_SESSION['usuario'];
if($_FILES['imagen']['name']!=""){
	$foto= $_FILES['imagen']["name"];
  $tipo=$_FILES['imagen']["type"];
	$destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/img/".$foto;
	$tmp= $_FILES['imagen']["tmp_name"];
	if(move_uploaded_file($tmp,$destino)){
   $resolucion=getimagesize("img/".$foto);
   $resolucion=$resolucion[0]."x".$resolucion[1];
   $t=explode("/",$tipo);
   $formato=$t[1];
  $publicacion=new Publicacion();
  if($res=$publicacion->alta($titulo, $categoria, $foto, $estado, $fecha, $formato, $resolucion, $derechoUso, $usuario)){
    $etiquetas= new Etiqueta();
    if ($et1!="") {
     $etiquetas->alta($et1,$res);
    }
    if ($et2!="") {
      $etiquetas->alta($et2,$res);
     }
     if ($et3!="") {
      $etiquetas->alta($et3,$res);
     }
     $_SESSION['exito']="Publicacion creada con exito";
      header("location:publicaciones.php");
    }

  }
  
  

}
?>