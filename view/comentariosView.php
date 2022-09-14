<?php
if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <?php require_once("public/head.php"); ?>
        <script src="public/js/imagen.js"></script>
    </head>

    <body class="estilo">
        <header>
            <?php require_once("public/header.php"); ?>
        </header>
        <?php if (isset($_SESSION['exito'])) { ?>
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
            </svg>
            <div class="mt-2 alert alert-success alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                    <use xlink:href="#check-circle-fill" />
                </svg><?php echo $_SESSION['exito']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['exito']);
        } ?>


        <div class="container d-flex justify-content-center mt-3 mb-3">
            <div class="col-md-10 card">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb m-3">
                        <li class="breadcrumb-item"><a href="<?php echo $helper->url("Inicio", "index"); ?>">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo $helper->url("Publicacion", "Publicaciones"); ?>">Publicaciones</a></li>

                        <li class="breadcrumb-item active" aria-current="page"><?php echo $publicacion['Titulo']; ?></li>
                        <li class="breadcrumb-item active" aria-current="page"> Comentarios</li>
                    </ol>
                </nav>
                <div class="container">
                    <?php if ($comentarios) {
                        foreach ($comentarios as $comentario) {

                    ?>
                            <div class="mt-2 mb-2 d-flex">
                                <img src="<?php echo 'public/img/' . $comentario['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
                                <div class="ms-3">
                                    <span class="fw-bold"><?php echo $comentario['Nombre'] . " " . $comentario['Apellido']; ?></span><br>
                                    <small class="text-muted"> <?php setlocale(LC_TIME, "spanish");
                                                                $Nueva_Fecha = date("d-m-Y", strtotime($comentario['Fecha']));
                                                                echo strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha)); ?></small>
                                </div>
                            </div>
                            <p class="card-text text-muted mt-4 mb-4"><?php echo $comentario['Descripcion']; ?></p>
                            <hr>
                    <?php }
                    } ?>
                    <form method="POST" id="" name="" action="<?php echo $helper->url("Comentario", "crear"); ?>" enctype="">
                        <div class="input-group mt-4 mb-2 p-2">
                            <input type="text" class="form-control" name="coment" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                            <input type="hidden" value="<?php echo $publicacion['idPublicacion']; ?>" name="idPubCom">
                            <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require_once("public/script.php"); ?>
        <?php require_once("public/footer.php"); ?>
    </body>

    </html>
<?php  } else {
    echo $helper->url("Usuario", "login");
} ?>