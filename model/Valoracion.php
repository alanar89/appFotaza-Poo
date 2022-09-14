<?php
class Valoracion extends EntidadBase{
 
    public function __construct() {
        $table="valoraciones";
        parent::__construct($table);
    }

    public function valoracion($publicacion,$usuario)
    {
        $conexion = new Conectar();
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
        $conexion = new Conectar();
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
        $conexion = new Conectar();
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
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO valoraciones(Valoracion,idPublicacion,idUsuario)VALUES( '$puntaje','$publicacion','$usuario')";
        if ($con->query($sql)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
     

}

