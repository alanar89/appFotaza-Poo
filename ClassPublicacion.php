<?php
require_once('ClassConexion.php');
require_once('ClassValoracion.php');
class Publicacion
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

    
    public function publicaciones()
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "SELECT  idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso,usuarios.Nombre,usuarios.Apellido,usuarios.Foto FROM publicaciones
        JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario";
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
        $conexion = new Conexion();
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

    public function buscarPublicaciones($buscar)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
       
        $sql = "SELECT  DISTINCT publicaciones.idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso, usuarios.Nombre, usuarios.Apellido,usuarios.Foto FROM publicaciones
        JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario JOIN etiquetas ON etiquetas.idPublicacion=publicaciones.idPublicacion
        WHERE etiquetas.Nombre='$buscar' or usuarios.Nombre='$buscar' or  usuarios.Apellido='$buscar' or concat( usuarios.Nombre,' ', usuarios.Apellido)='$buscar'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    public function buscarPublicacionesPublicas($buscar)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
       
        $sql = "SELECT DISTINCT publicaciones.idPublicacion,Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,Resolucion,DerechosDeUso, usuarios.Nombre, usuarios.Apellido,usuarios.Foto FROM publicaciones
        JOIN usuarios ON usuarios.idUsuario=publicaciones.idUsuario JOIN etiquetas ON etiquetas.idPublicacion=publicaciones.idPublicacion
        WHERE  Estado='publica'and( etiquetas.Nombre='$buscar' or usuarios.Nombre='$buscar' or  usuarios.Apellido='$buscar' or concat( usuarios.Nombre,' ', usuarios.Apellido)='$buscar')";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) > 0) {
                return $consulta->fetch_all(MYSQLI_ASSOC);
        } else {
            return false;
        }
        $conexion->cerrarConexion();
    }
    public function alta($titulo, $categoria, $foto, $estado, $fecha, $formato, $resolucion, $derechoUso, $usuario)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "INSERT INTO publicaciones (Titulo,Categoria,Imagen,Estado,FechaCreacion,Formato,resolucion,DerechosDeUso,idUsuario) 
            VALUES( '$titulo','$categoria','$foto','$estado','$fecha','$formato','$resolucion','$derechoUso','$usuario')";
        if ($con->query($sql)) {
            return $con->insert_id;
        } else {
            return false;
        }
    }

    public function editar($titulo,$categoria,$estado,$derechoUso,$publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
            $sql = "UPDATE publicaciones SET Titulo ='$titulo', Categoria='$categoria',Estado='$estado',DerechosDeUso='$derechoUso' WHERE idPublicacion='$publicacion'";
            if ($con->query($sql)) {
                return true;
            } else {
                return false;
            }
      $conexion->cerrarConexion();
    }

    public function baja($publicacion)
    {
        $conexion = new Conexion();
        $con = $conexion->crearConexion();
        $sql = "DELETE FROM publicaciones WHERE idPublicacion='$publicacion'";
        $consulta = $con->query($sql);
        if ($consulta) {
            return true;
        } else {
            return false;
        }
    }


    // public function valorarPublicacion($puntaje, $publicacion, $usuario)
    // {
    //     $conexion = new Conexion();
    //     $con = $conexion->crearConexion();
    //     $sql = "INSERT INTO valoraciones(Valoracion,idPublicacion,idUsuario)VALUES( '$puntaje','$publicacion','$usuario')";
    //     if ($con->query($sql)) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
}

/*$a=new Usuario();
$u="alan@gmail.com";
$p="12345";
if($a->ingresar($u,$p)){echo"si";}else{echo "no";}
$c=password_hash($p, PASSWORD_DEFAULT);*/
// $a= new Publicacion();
// print_r($a->buscarPublicacionesPublicas("alan"));
