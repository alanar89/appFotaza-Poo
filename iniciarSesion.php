<?php
session_start();
require_once("ClassUsuario.php");
$mail=$_POST['mail'];
$pass=$_POST['pass'];
$usuario=new Usuario();
$res=$usuario->ingresar($mail,$pass);
if($res){
   $_SESSION['usuario']=$res['idUsuario'];
   $_SESSION['nya']=$res['Nombre']." ".$res['Apellido'];
   $_SESSION['foto']=$res['Foto'];
if(isset($_SESSION['usuario'])){ header("location:index.php");}
}else{header("location:login.php?res=1");}
?>