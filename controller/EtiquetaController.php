<?php
class EtiquetaController extends ControladorBase
{
    public $conectar;

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        if (isset($_GET['idImg'])) {
            $id = $_GET['idImg'];
            session_start();
            $publicacion = new Publicacion();
            $etiquetas = new Etiqueta();
            $pub = $publicacion->publicacion($id);
            $et = $etiquetas->etiquetas($id);
            $this->view("etiquetas", array(
                "etiquetas" => $et,
                'publicacion' => $pub
            ));
        }
    }



    public function crear()
    {
        if (isset($_POST['addTag'])) {
            session_start();
            $etiquetas = new Etiqueta();
            if ($etiquetas->alta($_POST['addTag'], $_POST['idPub'])) {
                $_SESSION['exito'] = "Etiqueta agregada con exito";
                $this->redirect("Etiqueta", "index&idImg=$_POST[idPub]");
            }
        }
    }


    public function eliminar()
    {
        if (isset($_GET['idTag'])) {
            session_start();
            $etiquetas = new Etiqueta();
            if ($etiquetas->baja($_GET['idTag'], $_GET['idPub'])) {
                $_SESSION['exito'] = "Etiqueta eliminada con exito";
                $this->redirect("Etiqueta", "index&idImg=$_GET[idPub]");
            }
        }
    }
}
