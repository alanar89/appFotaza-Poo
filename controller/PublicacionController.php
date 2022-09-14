<?php
class PublicacionController extends ControladorBase{
    public $conectar;
		
    public function __construct() {
        parent::__construct();  
    }

		
		public function index(){

		}


        public function publicaciones(){
            session_start();
			$id=$_SESSION['usuario'];
        $publicaciones= new Publicacion();
        $publicacion=$publicaciones->misPublicaciones($id);
			$this->view("publicaciones",array(
                'publicaciones'=>$publicacion,
			));
		}

		 public function crear(){	
        session_start();
        $titulo=$_POST['titulo'];
        $categoria=$_POST['categoria'];
        $precio=$_POST['precio'];
        $estado=$_POST['estado'];
        $derechoUso=$_POST["duso"];
        $et1=$_POST['et1'];
        $et2=$_POST['et2'];
        $et3=$_POST['et3'];
        $fecha= date("y/m/d");
        $usuario=$_SESSION['usuario'];
        if($_FILES['imagen']['name']!=""){
            $foto= $_FILES['imagen']["name"];
          $tipo=$_FILES['imagen']["type"];
            $destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/public/img/".$foto;
            $tmp= $_FILES['imagen']["tmp_name"];
            if(move_uploaded_file($tmp,$destino)){
           $resolucion=getimagesize("public/img/".$foto);
           $resolucion=$resolucion[0]."x".$resolucion[1];
           $t=explode("/",$tipo);
           $formato=$t[1];
          $publicacion=new Publicacion();
          if($res=$publicacion->alta($titulo, $categoria, $foto, $estado,$precio, $fecha, $formato, $resolucion, $derechoUso, $usuario)){
            $etiquetas= new Etiqueta();
            if ($et1!="") {
             $etiquetas->alta($et1,$res);
            }
            if ($et2!="") {
              $etiquetas->alta($et2,$res);
             }
             if ($et3!="") {
              $etiquetas->alta($et3,$res);
             }
             $_SESSION['exito']="Publicacion creada con exito";
             $this->redirect("Publicacion", "publicaciones");
            }
        
          }
          
        }
        
        }

        public function actualizar(){
			if (isset($_POST['titulo'])) {
                session_start();
                $publicacion=new Publicacion();
                $titulo=$_POST['titulo'];
            $categoria=$_POST['categoria'];
            $precio=$_POST['precio'];
            $estado=$_POST['estado'];
            $derechoUso=$_POST["duso"];
            $pub=$_POST['idPubEditar'];
            if($_FILES['foto']['name']!=""){
				$foto= $_FILES['foto']["name"];
				$destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/public/img/".$foto;
				$tmp= $_FILES['foto']["tmp_name"];
				move_uploaded_file($tmp,$destino);
			   }else{ $foto=$_POST['fotop'];}
                if($publicacion->editar($titulo,$categoria,$foto,$estado,$precio,$derechoUso,$pub)){
                    $_SESSION['exito']="Publicacion actualizada con exito";
                    $this->redirect("Publicacion", "publicaciones");
                }    
            }
				
			}
            public function eliminar(){
                if (isset($_GET['idImg'])) { 
                    session_start();
                   
                    $publicacion=new Publicacion();
                    if($publicacion->baja($_GET['idImg'])){
                        $_SESSION['exito']="Publicacion eliminada con exito";
                        $this->redirect("Publicacion", "publicaciones");
                    }
                 } 
                  
                }   
                
                public function detalle(){
                    session_start();
                    if (isset($_GET['idImg'])) { 
                $publicaciones= new Publicacion();
                $usuario=new Usuario();
                $publicacion=$publicaciones->Publicacion($_GET['idImg']);
                $usuario=$usuario->perfil($publicacion['idUsuario']);
                    $this->view("detalle",array(
                        'publicacion'=>$publicacion,
                        'contacto'=>$usuario
                    ));}
                }

}
