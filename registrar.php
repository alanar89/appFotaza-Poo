<?php
session_start();
require_once("ClassUsuario.php");
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$mail=$_POST['mail'];
$contrasena=$_POST["pass"];
if($_FILES['foto']['name']!=""){
	$foto= $_FILES['foto']["name"];
	$destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/img/".$foto;
	$tmp= $_FILES['foto']["tmp_name"];
	move_uploaded_file($tmp,$destino);}
	else{$foto="avatar.jpg";}
    $usuario=new Usuario();
    if($usuario->crearUsuario($nombre,$apellido,$mail,$contrasena,$foto)){
        $_SESSION['exito']="registro exitoso";
         header("location:login.php");}
    else{header("location:registro.php?res=1");}
    ?>