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
            <div class="mt-2 alert alert-success alert-dismissible fade show " role="alert">
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
                        <li class="breadcrumb-item active" aria-current="page"> Detalle</li>
                    </ol>
                </nav>
                <div class=" mb-3">
                    <div class="card-body">


                        <!-- <h5 class="  mt-3 mb-5 text-uppercase">Información de la foto</h5> -->
                        <img src="<?php echo 'public/img/' . $publicacion['Imagen'] ?>" class="img-fluid" alt="">

                        <div class="m-2">
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Titulo</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo $publicacion['Titulo']; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Categoria</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo $publicacion['Categoria']; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Privacidad</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo $publicacion['Estado']; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Formato</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo $publicacion['Formato']; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0"> Resolucion</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo $publicacion['Resolucion']; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0"> Derechos de uso</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo $publicacion['DerechosDeUso']; ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0"> Fecha Publicacion</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php setlocale(LC_TIME, 'ES.UTF-8');
                                    echo strftime("%A, %d de %B de %Y", strtotime($publicacion['FechaCreacion'])); ?>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Precio</h6>
                                </div>
                                <div class="col-md-6 text-secondary">
                                    <?php echo "$" . $publicacion['Precio']; ?>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6  ms-md-2">
                            <h5 class=" mb-4 mt-4 text-uppercase">Etiquetas</h5>
                            <?php if ($etiquetas) {
                                foreach ($etiquetas as $val) {
                            ?>
                                    <div class=""><span class="m-1 mb-3 icono badge text-wrap bg-success" title="Etiqueta">
                                            <?php echo $val['Nombre']; ?></span>
                                        <a href="<?php echo $helper->url("Etiqueta", "eliminar") . '&idTag=' . $val['IdEtiqueta'] . '&idPub=' . $val['idPublicacion']; ?>" onclick="return confirm('eliminar etiqueta?')">
                                            <i class="fas fa-times text-danger icono" id="" title="quitar"></i></a>
                                    </div>
                            <?php }
                            }
                            ?>

                            <form method="POST" name="" action="<?php echo $helper->url("Etiqueta", "crear"); ?>" enctype="">
                                <div class="input-group  mt-3">
                                    <?php

                                    if ($etiquetas && count($etiquetas) >= 3) { ?>
                                        <p class="alert alert-danger d-flex align-items-center" role="alert">Maximo de
                                            Etiquetas Permitidas.</p>
                                    <?php } else { ?>
                                        <input type="text" placeholder="Nueva etiqueta.." class="form-control form-control-sm" id="addTag" name="addTag" required>
                                        <input type="hidden" value="<?php echo $val['idPublicacion']; ?>" name="idPub">
                                        <button class="btn btn-primary btn-sm" type="submit" name="btnAdd">Agregar</button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>



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