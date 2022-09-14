<?php
class ComentarioController extends ControladorBase
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
            $comentarios = new Comentario();
            $pub = $publicacion->publicacion($id);
            $com = $comentarios->comentarios($id);
            $this->view("comentarios", array(
                "comentarios" => $com,
                'publicacion' => $pub
            ));
        }
    }

    public function crear()
    {
        if (isset($_POST['coment'])) {
            $com = $_POST['coment'];
        }
        if (isset($_POST['com'])) {
            $com = $_POST['com'];
        }

        session_start();
        if (isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario'];
            $fecha = date("y/m/d H:i:s");
            $comentario = new Comentario();
            if ($comentario->alta($com, $_POST['idPubCom'], $id, $fecha)) {
                $_SESSION['exito'] = "Comentario exitoso";
                if (isset($_POST['coment'])) {
                    $this->redirect("Comentario", "index&idImg=$_POST[idPubCom]");
                } else {
                    $this->redirect("Inicio", "index");
                }
            }
        } else {
            $this->redirect("Usuario", "login");
        }
    }
}
