<?php
class Usuario extends EntidadBase{
    
    public function __construct() {
        $table="usuarios";
        parent::__construct($table);
    }
    

    public function ingresar($usuario, $contrasena)
    {
        $conexion = new Conectar();
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

    public function alta($nombre, $apellido, $mail, $contrasena,$tel ,$foto)
    {
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "SELECT Mail FROM usuarios WHERE Mail='$mail'";
        $consulta = $con->query($sql);
        if (($consulta->num_rows) == 0) {
            $sql = "INSERT INTO usuarios (Nombre,Apellido,Mail,Contrasena,Telefono,Foto) VALUES( '$nombre','$apellido','$mail','$contrasena','$tel','$foto')";
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

    public function perfil($usuario)
    {
        $conexion = new Conectar();
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
        $conexion = new Conectar();
        $con = $conexion->crearConexion();
            $sql = "UPDATE usuarios SET Nombre ='$nombre', Apellido='$apellido',Mail='$mail',Telefono='$telefono',Foto='$foto' WHERE idUsuario='$id'";
            if ($con->query($sql)) {
                return true;
            } else {
                return false;
            }
      $conexion->cerrarConexion();
    }
	

}
?>