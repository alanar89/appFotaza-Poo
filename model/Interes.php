<?php
class Interes extends EntidadBase{
 
    public function __construct() {
        $table="intereses";
        parent::__construct($table);
    }

    public function intereses($usuario)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT idInteres,Interes FROM intereses WHERE idUsuario='$usuario'";
       $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    
    public function alta($interes, $usuario)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO intereses(interes,idUsuario)VALUES( '$interes','$usuario')";
        if ($con->query($sql)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    
    public function baja($interes, $usuario)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "DELETE FROM intereses WHERE idInteres='$interes' AND idUsuario='$usuario'";
        $consulta = $con->query($sql);
        if (($consulta)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

}

