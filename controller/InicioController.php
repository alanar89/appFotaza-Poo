<?php
class InicioController extends ControladorBase{
    public $conectar;
		
    public function __construct() {
        parent::__construct();
		 
        
    }

	
		public function index(){
			session_start();
			$i=0;
			 $publicaciones = new Publicacion();
            $etiquetas = new Etiqueta();
            $comentarios = new Comentario();
            $validacion = new Valoracion();
			$publicaciones=$publicaciones->publicaciones();
			if($publicaciones){
			foreach ($publicaciones as $key => $value)  { 
				$valoracion=$validacion->valoraciones($value['idPublicacion']);
				$etiqueta=$etiquetas->etiquetas($value['idPublicacion']); 
				$calificacion= $validacion->valoraciones($value['idPublicacion']); 
				$comentario=$comentarios->comentarios($value['idPublicacion']);
				$cantidad = $validacion->cantidad($value['idPublicacion']);
			if(isset($_SESSION['usuario'])){
				$micalificacion=$validacion->valoracion($value['idPublicacion'],$_SESSION['usuario']);}
			if ($cantidad['COUNT(Valoracion)'] >= 5 && $valoracion['AVG(Valoracion)'] >= 4) {
			
					$destacados['pub'.$i]['datos'] = $value;
					$destacados['pub'.$i]['et'] = $etiqueta;
					$destacados['pub'.$i]['com'] = $comentario;
					$destacados['pub'.$i]['cal'] =$calificacion;
					if(isset($_SESSION['usuario'])){	$destacados['pub'.$i]['mical'] =$micalificacion;}
					$i++;
				
			}else{
				$publicacion['pub'.$i]['datos'] = $value;
					$publicacion['pub'.$i]['et'] = $etiqueta;
					$publicacion['pub'.$i]['com'] = $comentario;
					$publicacion['pub'.$i]['cal'] =$calificacion;
					if(isset($_SESSION['usuario'])){$publicacion['pub'.$i]['mical'] =$micalificacion;}
					$i++;
			}
			}
				$this->view("index",array(
					'publicaciones'=>$publicacion,
					"destacados"=>$destacados
				));
			}else{
				$this->view("index",array(
				'publicaciones'=>$publicaciones,));}
			
		

		
                
            }

			public function publicaciones(){
				if (isset($_GET['idUser'])) { 
				session_start();
				$i=0;
				 $publicaciones = new Publicacion();
				$etiquetas = new Etiqueta();
				$comentarios = new Comentario();
				$validacion = new Valoracion();
				$publicaciones=$publicaciones->usuarioPublicaciones($_GET['idUser']);
				if($publicaciones){
				foreach ($publicaciones as $key => $value)  { 
					$etiqueta=$etiquetas->etiquetas($value['idPublicacion']); 
					$calificacion= $validacion->valoraciones($value['idPublicacion']); 
					$comentario=$comentarios->comentarios($value['idPublicacion']);
					if(isset($_SESSION['usuario'])){
					$micalificacion=$validacion->valoracion($value['idPublicacion'],$_SESSION['usuario']);}
			
					$publicacion['pub'.$i]['datos'] = $value;
						$publicacion['pub'.$i]['et'] = $etiqueta;
						$publicacion['pub'.$i]['com'] = $comentario;
						$publicacion['pub'.$i]['cal'] =$calificacion;
						if(isset($_SESSION['usuario'])){$publicacion['pub'.$i]['mical'] =$micalificacion;}
						$i++;
				}
					$this->view("usuarioPublicaciones",array(
						'publicaciones'=>$publicacion,
					));
				}else{
					$this->view("usuarioPublicaciones",array(
					'publicaciones'=>$publicaciones,));}
				}
	
			
					
				}
				public function buscar(){
					if (isset($_POST['buscar'])) { 
					session_start();
					$i=0;
					 $publicaciones = new Publicacion();
					$etiquetas = new Etiqueta();
					$comentarios = new Comentario();
					$validacion = new Valoracion();
					if(isset($_SESSION['usuario'])){$tipo=true;}else{$tipo=false;}
					$publicaciones=$publicaciones->buscarPublicaciones($_POST['buscar'],$tipo);
					if($publicaciones){
					foreach ($publicaciones as $key => $value)  { 
						$etiqueta=$etiquetas->etiquetas($value['idPublicacion']); 
						$calificacion= $validacion->valoraciones($value['idPublicacion']); 
						$comentario=$comentarios->comentarios($value['idPublicacion']);
						if(isset($_SESSION['usuario'])){
						$micalificacion=$validacion->valoracion($value['idPublicacion'],$_SESSION['usuario']);}
				
						$publicacion['pub'.$i]['datos'] = $value;
							$publicacion['pub'.$i]['et'] = $etiqueta;
							$publicacion['pub'.$i]['com'] = $comentario;
							$publicacion['pub'.$i]['cal'] =$calificacion;
							if(isset($_SESSION['usuario'])){	$publicacion['pub'.$i]['mical'] =$micalificacion;}
							$i++;
					}
						$this->view("buscar",array(
							'publicaciones'=>$publicacion,
						));}else{$_SESSION['exito']="";
							$this->view("buscar",array(
							'publicaciones'=>$publicaciones,));}
					
					}
				}
}
