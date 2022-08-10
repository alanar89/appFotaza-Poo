<?php
require_once('ClassConexion.php');
class Etiqueta
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

    public function etiquetas($publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT idEtiqueta,Nombre FROM etiquetas WHERE idPublicacion='$publicacion'";
       $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    
    public function alta($etiqueta, $publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO etiquetas(Nombre,idPublicacion) VALUES ('$etiqueta','$publicacion')";
        if ($con->query($sql)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    public function baja($etiqueta, $publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "DELETE FROM etiquetas WHERE idEtiqueta='$etiqueta' AND idPublicacion='$publicacion'";
        $consulta = $con->query($sql);
        if (($consulta)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

}


