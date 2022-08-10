<?php
require_once('ClassConexion.php');
class Comentario
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

    
    public function comentarios($publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT Descripcion,Fecha,idPublicacion,Nombre,Apellido,Foto FROM comentarios JOIN usuarios ON usuarios.idUsuario=comentarios.idUsuario 
        WHERE idPublicacion='$publicacion'  order by comentarios.Fecha asc";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    
    public function alta($comentario, $publicacion, $usuario,$fecha)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO comentarios (Descripcion,Fecha,idPublicacion,idUsuario) 
            VALUES( '$comentario','$fecha','$publicacion','$usuario')";
        if ($con->query($sql)) {
            return true;
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    
    }
