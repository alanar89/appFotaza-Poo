<?php
class UsuarioController extends ControladorBase{
    public $conectar;
		
    public function __construct() {
        parent::__construct();
		 
        
    }

		public function index(){
				
		}

		public function crear(){
			session_start();
			$nombre=$_POST['nombre'];
			$apellido=$_POST['apellido'];
			$mail=$_POST['mail'];
			$tel=$_POST['tel'];
			$contrasena=$_POST["pass"];
			if($_FILES['foto']['name']!=""){
				$foto= $_FILES['foto']["name"];
				$destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/public/img/".$foto;
				$tmp= $_FILES['foto']["tmp_name"];
				move_uploaded_file($tmp,$destino);}
				else{$foto="avatar.jpg";}
				$usuario=new Usuario();
				if($usuario->alta($nombre,$apellido,$mail,$contrasena,$tel,$foto)){
					$_SESSION['exito']="registro exitoso";
					$this->redirect("Usuario","login");
				}else{$this->redirect("Usuario","registro&res=1");}
		}

     
	
		public function actualizar(){
			if(isset($_POST["nombre"])){
				session_start();
				$id=$_SESSION['usuario'];
				$usuario=new Usuario();
				$n=$_POST['nombre'];
				$a=$_POST['apellido'];
				$m=$_POST['mail'];
				$t=$_POST['tel'];
			   if($_FILES['foto']['name']!=""){
				$f= $_FILES['foto']["name"];
				$destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/public/img/".$f;
				$tmp= $_FILES['foto']["tmp_name"];
				move_uploaded_file($tmp,$destino);
			   }else{ $f=$_POST['fotop'];}
				if($usuario->editar($id,$n,$a,$m,$t,$f)){
					$_SESSION['nya']=$n." ".$a;
					$_SESSION['foto']=$f;
					$_SESSION['exito']="Perfil actualizado con exito";
					$this->redirect("Usuario","perfil");
				}
			}
		}
    
	
		
			//Muestra el formulario de registro
			public function registro(){
					$this->view("registro",array());
				}

			//Muestra el formulario de inicio de sesion
			public function login(){
				$this->view("login",array());
			}

			
		public function ingresar(){
			session_start();
			$mail=$_POST['mail'];
			$pass=$_POST['pass'];
			$usuario=new Usuario();
			$res=$usuario->ingresar($mail,$pass);
			if($res){
			   $_SESSION['usuario']=$res['idUsuario'];
			   $_SESSION['nya']=$res['Nombre']." ".$res['Apellido'];
			   $_SESSION['foto']=$res['Foto'];
			if(isset($_SESSION['usuario'])){$this->redirect("Inicio", "index");}
			}else{$this->redirect("Usuario","login&res=1");}
		}	

		public function salir(){
			if (session_start()) {
				session_unset();
				session_destroy();
				
			} 
				$this->redirect("Inicio", "index");
		
		}

		public function perfil(){
			session_start();
			$id=$_SESSION['usuario'];
			$usuario=new Usuario();
			$interes=new Interes();
			$datos=$usuario->perfil($id);
			$datos2=$interes->intereses($id);
			$this->view("perfil",array(
				"datos2"=>$datos2,
				"datos"=>$datos
			));
		}
			
}
