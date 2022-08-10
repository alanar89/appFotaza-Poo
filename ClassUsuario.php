<?php
require_once('ClassConexion.php');
class Usuario
{

    public function  __construct()
    {
    }

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function crearUsuario($nombre, $apellido, $mail, $contrasena, $foto)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "SELECT Mail FROM usuarios WHERE Mail='$mail'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) == 0) {
            $sql = "INSERT INTO usuarios (Nombre,Apellido,Mail,Contrasena,Foto) VALUES( '$nombre','$apellido','$mail','$contrasena','$foto')";
            if ($con->query($sql)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function ingresar($usuario, $contrasena)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT * FROM usuarios WHERE Mail='$usuario'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
            $fila = $consulta->fetch_assoc();
            $hash = $fila["Contrasena"];
            if ((password_verify($contrasena, $hash))) {
                return  $fila;
            } else {
                return false;
            }
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function perfil($usuario)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT * FROM usuarios WHERE idUsuario='$usuario'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_assoc();
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function editar($id,$nombre,$apellido,$mail,$telefono,$foto)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
       // $sql = "SELECT Mail FROM usuarios WHERE Mail='$mail'";
       // $consulta = $con->query($sql);
        //if (($consulta->num_rows) == 0) {
           // return false;
            $sql = "UPDATE usuarios SET Nombre ='$nombre', Apellido='$apellido',Mail='$mail',Telefono='$telefono',Foto='$foto' WHERE idUsuario='$id'";
            if ($con->query($sql)) {
                return true;
            } else {
                return false;
            }
      //  } else {
      //      return false;
      //  }
      $conexion->cerrarConexion();
    }

    public function salir()
    {
        if (session_start()) {
            session_unset();
            session_destroy();
            return true;
        } else {
            return false;
        }
    }
}

// public function editar($id,$nombre,$apellido,$telefono,$foto)
//     {
//         $conexion = new Conexion();
//         $con = $conexion->crearConexion();
//        $sql = "SELECT Mail FROM usuarios WHERE Mail='$mail'";
//        $consulta = $con->query($sql);
//         if (($consulta->num_rows) == 0) {
//            return false;
//             $sql = "UPDATE usuarios SET Mail ='$nombre' WHERE idUsuario='$id'";
//             if ($con->query($sql)) {
//                 return true;
//             } else {
//                 return false;
//             }
//        } else {
//            return false;
//        }
//     }
/*$a=new Usuario();
$u="alan@gmail.com";
$p="12345";
if($a->ingresar($u,$p)){echo"si";}else{echo "no";}
$c=password_hash($p, PASSWORD_DEFAULT);*/
