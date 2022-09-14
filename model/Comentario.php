<?php
class Comentario extends EntidadBase{
    
    public function __construct() {
        $table="comentarios";
        parent::__construct($table);

    }

    public function comentarios($publicacion)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT Descripcion,Fecha,idPublicacion,usuarios.idUsuario,Nombre,Apellido,Foto FROM comentarios JOIN usuarios ON usuarios.idUsuario=comentarios.idUsuario 
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
        $conexion = new Conectar();
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
