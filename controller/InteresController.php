<?php
class InteresController extends ControladorBase
{
    public $conectar;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
    }



    public function crear()
    {
        if (isset($_POST['addInt'])) {
            session_start();
            $id = $_SESSION['usuario'];
            $interes = new Interes();
            if ($interes->alta($_POST['addInt'], $id)) {
                $_SESSION['exito'] = "Interes agregado con exito";
                $this->redirect("Usuario", "perfil");
            }
        }
    }


    public function eliminar()
    {
        if (isset($_GET['idInt'])) {
            session_start();
            $id = $_SESSION['usuario'];
            $interes = new Interes();
            if ($interes->baja($_GET['idInt'], $id)) {
                $_SESSION['exito'] = "Interes eliminado con exito";
                $this->redirect("Usuario", "perfil");
            }
        }
    }
}
