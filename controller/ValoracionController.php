<?php
class ValoracionController extends ControladorBase
{
	public $conectar;

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		session_start();
		if (isset($_SESSION['usuario'])) {
			$validacion = new Valoracion();
			if (isset($_POST['cali'])) {

				if ($validacion->alta($_POST['cali'], $_POST['idPubCal'], $_SESSION['usuario'])) {
					$_SESSION['exito'] = "Calificacion exitosa";
					if (isset($_GET['idUser'])) {
						$this->redirect("Inicio", "publicaciones&idUser=$_GET[idUser]");
					} else {
						$this->redirect("Inicio", "index");
					}
				}
			}
		} else {
			$this->redirect("Usuario", "login");
		}
	}
}
