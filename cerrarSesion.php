<?php
require_once("ClassUsuario.php");
$usuario=new Usuario();
if($usuario->salir()){ 
    header("location:login.php");
}
?>