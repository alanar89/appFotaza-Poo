<?php
 class Conexion{

private $host="localhost";
private $usuario="root";
private $contrasena="";
private $db="fotaza";
private $conectar;

public function  __construct() {
}

public function crearConexion(){
    $this->conectar=new mysqli($this->host,$this->usuario,$this->contrasena,$this->db);
if ($this->conectar->connect_errno) {
    return "Ha surgido un error y no se puede conectar a la base de datos: " . $this->conectar->connect_error;
}
return $this->conectar;
}
public function cerrarConexion(){
    $this->conectar->close();
}
}


