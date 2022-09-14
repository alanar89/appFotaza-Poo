<?php
class Conectar{
    private $driver;
    private $host, $user, $pass, $database, $charset;
    private static $con;

    public function __construct() {

        $dbConfig  = require 'config/database.php';
        $this->driver = $dbConfig["driver"];
        $this->host= $dbConfig["host"];
        $this->user= $dbConfig["user"];
        $this->pass= $dbConfig["pass"];
        $this->database= $dbConfig["database"];
        $this->charset= $dbConfig["charset"];
    }
    
    public function crearConexion(){
        

        if(!isset(self::$con)){
            $con= new mysqli($this->host, $this->user, $this->pass, $this->database);
            //Es necesario para enviar datos al servidor que no pueden ser representados en ASCII puro, como 'ñ' o 'á'.
            $con->query("SET NAMES '".$this->charset."'");
            
            //implementar los controles necesarios para comprobar la conexión exitosa
            self::$con = $con;
        }

        return self::$con;
    }
	
	// tarea!! implementar cerrar la conexión
    public function cerrarConexion(){
        self::$con->close();
}
}
?>
