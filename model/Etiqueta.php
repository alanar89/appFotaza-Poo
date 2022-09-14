<?php
class Etiqueta extends EntidadBase{
  
    public function __construct() {
        $table="etiquetas";
        parent::__construct($table);
    }

    public function etiquetas($publicacion)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT * FROM etiquetas WHERE idPublicacion='$publicacion'";
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
        $conexion = new Conectar();
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
        $conexion = new Conectar();
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


