<?php
require_once('ClassConexion.php');
class Valoracion
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

    public function valoracion($publicacion,$usuario)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT * FROM valoraciones WHERE idPublicacion='$publicacion' and idUsuario='$usuario'";
       $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_assoc();
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function valoraciones($publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT AVG(Valoracion) FROM valoraciones WHERE idPublicacion='$publicacion'";
       $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_assoc();
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function cantidad($publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT COUNT(Valoracion) FROM valoraciones WHERE idPublicacion='$publicacion'";
       $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_assoc();
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function alta($puntaje, $publicacion, $usuario)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO valoraciones(Valoracion,idPublicacion,idUsuario)VALUES( '$puntaje','$publicacion','$usuario')";
        if ($con->query($sql)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    
   
    // public function baja($interes, $usuario)
    // {
    //     $conexion = new Conexion();
    //     $con = $conexion->crearConexion();
    //     $sql = "DELETE FROM intereses WHERE idInteres='$interes' AND idUsuario='$usuario'";
    //     $consulta = $con->query($sql);
    //     if (($consulta)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    //     $conexion->cerrarConexion();
    // }

  

}

