<?php
class Publicacion extends EntidadBase{
 
    public function __construct() {
        $table="publicaciones";
        parent::__construct($table);

    }
    
    public function publicacion($id)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT * FROM publicaciones
    Where idPublicacion=$id";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
            return $consulta->fetch_assoc();
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    
    public function publicaciones()
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT  idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso,usuarios.idUsuario,usuarios.Nombre,usuarios.Apellido,usuarios.Foto FROM publicaciones
        JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    public function usuarioPublicaciones($usuario)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT  idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso,usuarios.idUsuario,usuarios.Nombre,usuarios.Apellido,usuarios.Foto FROM publicaciones
        JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario WHERE usuarios.idUsuario='$usuario'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function misPublicaciones($usuario)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "SELECT * FROM publicaciones WHERE idUsuario='$usuario'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }

    public function buscarPublicaciones($buscar,$tipo)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
       if($tipo){
        $sql = "SELECT  DISTINCT publicaciones.idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso, usuarios.idUsuario,usuarios.Nombre, usuarios.Apellido,usuarios.Foto FROM publicaciones
        JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario JOIN etiquetas ON etiquetas.idPublicacion=publicaciones.idPublicacion
        WHERE etiquetas.Nombre='$buscar' or usuarios.Nombre='$buscar' or  usuarios.Apellido='$buscar' or concat( usuarios.Nombre,' ', usuarios.Apellido)='$buscar'";}
        else{
            $sql = "SELECT DISTINCT publicaciones.idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso, usuarios.Nombre, usuarios.Apellido,usuarios.Foto FROM publicaciones
            JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario JOIN etiquetas ON etiquetas.idPublicacion=publicaciones.idPublicacion
            WHERE  Estado='publica'and( etiquetas.Nombre='$buscar' or usuarios.Nombre='$buscar' or  usuarios.Apellido='$buscar' or concat( usuarios.Nombre,' ', usuarios.Apellido)='$buscar')";
        }
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
  
    
    public function alta($titulo, $categoria, $foto, $estado,$precio, $fecha, $formato, $resolucion, $derechoUso, $usuario)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO publicaciones (Titulo,Categoria,Imagen,Estado,Precio,FechaCreacion,Formato,resolucion,DerechosDeUso,idUsuario) 
            VALUES( '$titulo','$categoria','$foto','$estado','$precio','$fecha','$formato','$resolucion','$derechoUso','$usuario')";
        if ($con->query($sql)) {
            return $con->insert_id;
        } else {
            return false;
        }
    }

    public function editar($titulo,$categoria,$foto,$estado,$precio,$derechoUso,$publicacion)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
            $sql = "UPDATE publicaciones SET Titulo ='$titulo', Categoria='$categoria',Imagen='$foto',Estado='$estado',Precio='$precio',DerechosDeUso='$derechoUso' WHERE idPublicacion='$publicacion'";
            if ($con->query($sql)) {
                return true;
            } else {
                return false;
            }
      $conexion->cerrarConexion();
    }

    public function baja($publicacion)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $sql = "DELETE FROM publicaciones WHERE idPublicacion='$publicacion'";
        $consulta = $con->query($sql);
        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }
}


