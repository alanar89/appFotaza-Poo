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
        <div class="container d-flex justify-content-center mt-3">

            <div class="col-md-10 card mb-3 ">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb m-3">
                        <li class="breadcrumb-item"><a href="<?php echo $helper->url("Inicio", "index"); ?>">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Publicaciones</li>
                    </ol>
                </nav>
                <div class="row row-cols-1 row-cols-md-3 g-4 m-1">
                    <?php if ($publicaciones) {
                        foreach ($publicaciones as $key => $value) {
                    ?>
                            <div class="col">
                                <div class="card">
                                    <a href="<?php echo $helper->url("Etiqueta") . '&idImg=' . $value['idPublicacion']; ?>">
                                        <img src="<?php echo 'public/img/' . $value['Imagen'] ?>" class="card-img-top icono" title="Detalle" alt="..."></a>
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo $value['Titulo'] ?></h5>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo 'editar' . $value['idPublicacion'] ?>"><i class="fas fa-edit icono" title="Editar"></i></button>
                                        <a class="btn btn-primary" href="<?php echo $helper->url("Publicacion", "eliminar") . '&idImg=' . $value['idPublicacion']; ?>">
                                            <i class="fas fa-trash-alt icono" onclick="return confirm('eliminar imagen?')" title="Eliminar"></i></a>

                                        <a class="btn btn-primary" href="<?php echo $helper->url("Comentario") . '&idImg=' . $value['idPublicacion']; ?>"><i class="fas fa-comment-dots" title="Comentarios"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- modal editar publicacion -->
                            <div class="modal fade" id="<?php echo 'editar' . $value['idPublicacion'] ?>" tabindex="-1" aria-labelledby="<?php echo 'editarLabel' . $value['idPublicacion'] ?>" aria-hidden="true">
                                <div class="modal-dialog ">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-light">
                                            <h5 class="modal-title " id="<?php echo 'editarLabel' . $value['idPublicacion'] ?>">Editar
                                                publicación</h5>
                                            <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" name="" action="<?php echo $helper->url("Publicacion", "actualizar"); ?>" enctype="multipart/form-data">
                                                <input type="hidden" value="<?php echo $value['Imagen']; ?>" id="fotop" name="fotop">
                                                <div class="mb-3 ">
                                                    <label for="titulo" class="form-label">Titulo</label>
                                                    <input type="text" class="form-control form-control-sm" value="<?php echo $value['Titulo'] ?>" id="titulo" name="titulo" aria-describedby="" required>
                                                    <div id="tituloError" class="d-none mt-2 p-1 alert alert-danger">Ingrese titulo.
                                                    </div>
                                                </div>
                                                <div class="mb-3 ">
                                                    <label for="categoria" class="form-label">Categoria</label>
                                                    <input type="text" value="<?php echo $value['Categoria'] ?>" class="form-control form-control-sm" id="categoria" name="categoria" aria-describedby="" required>
                                                    <div id="categoriaError" class="d-none mt-2 p-1 alert alert-danger">Ingrese
                                                        categoria.</div>
                                                </div>
                                                <div class="mb-3 ">
                                                    <label for="precio" class="form-label">Precio</label>
                                                    <input type="number" value="<?php echo $value['Precio'] ?>" class="form-control form-control-sm" id="precio" name="precio" aria-describedby="" required>
                                                    <div id="precioError" class="d-none mt-2 p-1 alert alert-danger">Ingrese
                                                        precio.</div>
                                                </div>
                                                <div class="mb-3 ">
                                                    <label for="categoria" class="form-label">Estado</label>
                                                    <select class="form-select form-select-sm" name="estado" id="estado">
                                                        <?php if ($value['Estado'] == "publica") { ?>
                                                            <option value="publica" selected>Publica</option>
                                                            <option value="protegida">Protegida</option>
                                                        <?php  } else { ?>
                                                            <option value="publica">Publica</option>
                                                            <option value="protegida" selected>Protegida</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 ">
                                                    <label for="categoria" class="form-label">Derechos de uso</label>
                                                    <select class="form-select form-select-sm" name="duso" id="duso">
                                                        <?php if ($value['DerechosDeUso'] == "copyleft") { ?>
                                                            <option value="copyleft" selected>copyleft</option>
                                                            <option value="copyright">copyright</option>
                                                        <?php  } else { ?>
                                                            <option value="copyleft">copyleft</option>
                                                            <option value="copyright" selected>copyright</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 ">
                                                    <label for="foto" class="form-label">Foto</label>
                                                    <input type="file" name="foto" class="form-control form-control-sm" id="foto" aria-describedby="">
                                                </div>
                                                <input type="hidden" value="<?php echo $value['idPublicacion']; ?>" name="idPubEditar">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" name="btn-editar" class="btn btn-primary">Guardar</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                    <?php }
                    } ?>

                    <!-- modal nueva publicacion -->
                    <div class="col">
                        <div class="card icono mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <img src="public/img/subirFoto.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title text-center">Nueva publicacion <i class="fas fa-plus text-primary"></i></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-light">
                        <h5 class="modal-title " id="exampleModalLabel">Publicar Imagen</h5>
                        <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" name="formPublicar" action="<?php echo $helper->url("Publicacion", "crear"); ?>" enctype="multipart/form-data">
                            <div class="mb-3 ">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" name="imagen" class="form-control form-control-sm" required id="imagen" aria-describedby="">
                            </div>
                            <div class="mb-3 ">
                                <label for="titulo" class="form-label">Titulo</label>
                                <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" aria-describedby="" required>
                                <div id="tituloError" class="d-none mt-2 p-1 alert alert-danger">Ingrese titulo.</div>
                            </div>
                            <div class="mb-3 ">
                                <label for="categoria" class="form-label">Categoria</label>
                                <input type="text" class="form-control form-control-sm" id="categoria" name="categoria" aria-describedby="" required>
                                <div id="categoriaError" class="d-none mt-2 p-1 alert alert-danger">Ingrese categoria.</div>
                            </div>
                            <div class="mb-3 ">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control form-control-sm" id="precio" name="precio" aria-describedby="" required>
                                <div id="precioError" class="d-none mt-2 p-1 alert alert-danger">Ingrese
                                    precio.</div>
                            </div>
                            <div class="mb-3 ">
                                <label for="categoria" class="form-label">Estado</label>
                                <select class="form-select form-select-sm" name="estado" id="estado">
                                    <option value="publica">Publica</option>
                                    <option value="protegida">Protegida</option>
                                </select>
                            </div>
                            <div class="mb-3 ">
                                <label for="categoria" class="form-label">Derechos de uso</label>
                                <select class="form-select form-select-sm" name="duso" id="duso">
                                    <option value="copyleft">copyleft</option>
                                    <option value="copyright">copyright</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label lass="form-label">Etiquetas</label>
                                <input type="text" class="form-control form-control-sm" id="et1" name="et1">
                                <input type="text" class="form-control form-control-sm mt-2" id="et2" name="et2">
                                <input type="text" class="form-control form-control-sm mt-2" id="2t3" name="et3">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
    header("location:login.php");
} ?>