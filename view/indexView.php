<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("public/head.php"); ?>
    <script src="public/js/calificar.js"></script>
</head>

<body class="estilo">
    <header>
        <?php require_once("public/header.php"); ?>
        <?php require_once("public/script.php"); ?>
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
    <div class="container d-md-flex">

        <div class="col-md-8">
            <?php
            if ($publicaciones) {
                foreach ($publicaciones as $publicacion) {
                    if (isset($_SESSION['usuario'])) {
            ?>
                        <div class="m-3">
                            <div class="card col-12  mb-3">
                                <div class="p-4 pb-2 mt-2  d-flex">
                                    <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $publicacion['datos']['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $publicacion['datos']['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>
                                    <div class="ms-3">
                                        <span class="fw-bold"><?php echo $publicacion['datos']['Nombre'] . " " . $publicacion['datos']['Apellido']; ?></span><br>
                                        <small class="text-muted">
                                            <?php
                                            setlocale(LC_TIME, 'ES.UTF-8');
                                            echo strftime("%A, %d de %B de %Y", strtotime($publicacion['datos']['FechaCreacion']));
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="container">
                                    <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $publicacion['datos']['Categoria']; ?></span>
                                    <h5 class="card-text m-1 mb-4"><?php echo $publicacion['datos']['Titulo']; ?></h5>
                                    <a href="<?php echo $helper->url("Publicacion", "detalle") . '&idImg=' . $publicacion['datos']['idPublicacion']; ?>"> <img src="<?php echo 'public/img/' . $publicacion['datos']['Imagen']; ?>" class=" rounded img-fluid icono" data-bs-toggle="modal" data-bs-target="#<?php echo 'ver' . $publicacion['datos']['idPublicacion'] ?>" title="detalle" alt="..."></a>
                                </div>
                                <div class="card-body">

                                    <div class="row mb-4 mt-2 justify-content-center text-center text-md-start">
                                        <small><?php echo "Calificación: " . round($publicacion['cal']['AVG(Valoracion)'], 1) . " estrellas"; ?></small>
                                        <div class="col-md-4">
                                            <?php if (isset($_SESSION['usuario'])) {

                                                if ($publicacion['mical']) {
                                                    for ($i = 0; $i < intval($publicacion['mical']['Valoracion']); $i++) {
                                                        echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                                    }
                                                } else { ?>
                                                    <form method="POST" name="formCali" action="<?php echo $helper->url("Valoracion", "index"); ?>" enctype="">
                                                        <input type="radio" style="display: none;" id="r1<?php echo $publicacion['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                        <label for="r1<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r2<?php echo $publicacion['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                        <label for="r2<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r3<?php echo $publicacion['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                        <label for="r3<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r4<?php echo $publicacion['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                        <label for="r4<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r5<?php echo $publicacion['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                        <label for="r5<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="hidden" value="<?php echo $publicacion['datos']['idPublicacion']; ?>" name="idPubCal">
                                                        <button class="btn btn-sm d-none" id="btn<?php echo $publicacion['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                    </form>


                                                <?php }

                                                echo "</div>";
                                            } else { ?>

                                                <form method="POST" name="formCali" action="" enctype="">
                                                    <input type="radio" style="display: none;" id="r1<?php echo $publicacion['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                    <label for="r1<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r2<?php echo $publicacion['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                    <label for="r2<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r3<?php echo $publicacion['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                    <label for="r3<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r4<?php echo $publicacion['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                    <label for="r4<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r5<?php echo $publicacion['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                    <label for="r5<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="hidden" value="<?php echo $publicacion['datos']['idPublicacion']; ?>" name="idPubCal">
                                                    <button class="btn btn-sm d-none" id="btn<?php echo $publicacion['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                </form>
                                        </div>
                                    <?php  }  ?>

                                    <div class="col-md-5 mt-1 mb-1 mt-md-0 mb-md-0">
                                        <?php if ($publicacion['et']) {
                                            foreach ($publicacion['et'] as $val) {
                                        ?>
                                                <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                                    <?php echo $val['Nombre']; ?>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $publicacion['datos']['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $publicacion['datos']['idPublicacion'] ?>">
                                            <i class="far fa-comment"></i>
                                            <small class="text-muted">Comentarios</small>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-3 collapse scroll" id="<?php echo 'com' . $publicacion['datos']['idPublicacion'] ?>">
                                        <?php if ($publicacion['com']) {

                                            foreach ($publicacion['com'] as $com) {
                                                if ($com != "") {
                                        ?>
                                                    <div class="mt-2 mb-2 d-flex">
                                                        <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $com['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>
                                                        <div class="ms-3">
                                                            <span class="fw-bold"><?php echo $com['Nombre'] . " " . $com['Apellido']; ?></span><br>
                                                            <small class="text-muted">
                                                                <?php setlocale(LC_TIME, "spanish");
                                                                $Nueva_Fecha = date("d-m-Y", strtotime($com['Fecha']));
                                                                echo strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha));
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <p class="card-text text-muted mt-2"><?php echo $com['Descripcion']; ?></p>
                                                    <hr>
                                        <?php }
                                            }
                                        } ?>
                                        <form method="POST" name="formAddCom" action="<?php echo $helper->url("Comentario", "crear"); ?>" enctype="">
                                            <div class="input-group mt-4 mb-2 p-2">
                                                <input type="text" class="form-control" name="com" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                                <input type="hidden" value="<?php echo $publicacion['datos']['idPublicacion']; ?>" name="idPubCom">
                                                <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } else {
                        if ($publicacion['datos']['Estado'] == "publica") { ?>
                            <div class="m-3">
                                <div class="card col-12  mb-3">
                                    <div class="p-4 pb-2 mt-2  d-flex">
                                        <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $publicacion['datos']['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $publicacion['datos']['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>
                                        <div class="ms-3">
                                            <span class="fw-bold"><?php echo $publicacion['datos']['Nombre'] . " " . $publicacion['datos']['Apellido']; ?></span><br>
                                            <small class="text-muted">
                                                <?php
                                                setlocale(LC_TIME, 'ES.UTF-8');
                                                echo strftime("%A, %d de %B de %Y", strtotime($publicacion['datos']['FechaCreacion']));
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $publicacion['datos']['Categoria']; ?></span>
                                        <h5 class="card-text m-1 mb-4"><?php echo $publicacion['datos']['Titulo']; ?></h5>
                                        <a href="<?php echo $helper->url("Publicacion", "detalle") . '&idImg=' . $publicacion['datos']['idPublicacion']; ?>"> <img src="<?php echo 'public/img/' . $publicacion['datos']['Imagen']; ?>" class=" rounded img-fluid icono" data-bs-toggle="modal" data-bs-target="#<?php echo 'ver' . $publicacion['datos']['idPublicacion'] ?>" title="detalle" alt="..."></a>
                                    </div>
                                    <div class="card-body">

                                        <div class="row mb-4 mt-2 justify-content-center text-center text-md-start">
                                            <small><?php echo "Calificación: " . round($publicacion['cal']['AVG(Valoracion)'], 1) . " estrellas"; ?></small>
                                            <div class="col-md-4">
                                                <?php if (isset($_SESSION['usuario'])) {

                                                    if ($publicacion['mical']) {
                                                        for ($i = 0; $i < intval($publicacion['mical']['Valoracion']); $i++) {
                                                            echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                                        }
                                                    } else { ?>
                                                        <form method="POST" name="formCali" action="<?php echo $helper->url("Valoracion", "index"); ?>" enctype="">
                                                            <input type="radio" style="display: none;" id="r1<?php echo $publicacion['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                            <label for="r1<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                            <input type="radio" style="display: none;" id="r2<?php echo $publicacion['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                            <label for="r2<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                            <input type="radio" style="display: none;" id="r3<?php echo $publicacion['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                            <label for="r3<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                            <input type="radio" style="display: none;" id="r4<?php echo $publicacion['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                            <label for="r4<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                            <input type="radio" style="display: none;" id="r5<?php echo $publicacion['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                            <label for="r5<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                            <input type="hidden" value="<?php echo $publicacion['datos']['idPublicacion']; ?>" name="idPubCal">
                                                            <button class="btn btn-sm d-none" id="btn<?php echo $publicacion['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                        </form>


                                                    <?php }

                                                    echo "</div>";
                                                } else { ?>

                                                    <form method="POST" name="formCali" action="<?php echo $helper->url("Valoracion", "index"); ?>" enctype="">
                                                        <input type="radio" style="display: none;" id="r1<?php echo $publicacion['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                        <label for="r1<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r2<?php echo $publicacion['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                        <label for="r2<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r3<?php echo $publicacion['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                        <label for="r3<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r4<?php echo $publicacion['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                        <label for="r4<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r5<?php echo $publicacion['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                        <label for="r5<?php echo $publicacion['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $publicacion['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="hidden" value="<?php echo $publicacion['datos']['idPublicacion']; ?>" name="idPubCal">
                                                        <button class="btn btn-sm d-none" id="btn<?php echo $publicacion['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                    </form>
                                            </div>
                                        <?php  }  ?>

                                        <div class="col-md-5 mt-1 mb-1 mt-md-0 mb-md-0">
                                            <?php if ($publicacion['et']) {
                                                foreach ($publicacion['et'] as $val) {
                                            ?>
                                                    <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                                        <?php echo $val['Nombre']; ?>
                                                    </div>
                                            <?php }
                                            } ?>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $publicacion['datos']['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $publicacion['datos']['idPublicacion'] ?>">
                                                <i class="far fa-comment"></i>
                                                <small class="text-muted">Comentarios</small>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="p-3 collapse scroll" id="<?php echo 'com' . $publicacion['datos']['idPublicacion'] ?>">
                                            <?php if ($publicacion['com']) {

                                                foreach ($publicacion['com'] as $com) {
                                                    if ($com != "") {
                                            ?>
                                                        <div class="mt-2 mb-2 d-flex">
                                                            <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $com['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>
                                                            <div class="ms-3">
                                                                <span class="fw-bold"><?php echo $com['Nombre'] . " " . $com['Apellido']; ?></span><br>
                                                                <small class="text-muted">
                                                                    <?php setlocale(LC_TIME, "spanish");
                                                                    $Nueva_Fecha = date("d-m-Y", strtotime($com['Fecha']));
                                                                    echo strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha));
                                                                    ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <p class="card-text text-muted mt-2"><?php echo $com['Descripcion']; ?></p>
                                                        <hr>
                                            <?php }
                                                }
                                            } ?>
                                            <form method="POST" name="formAddCom" action="<?php echo $helper->url("Comentario", "crear"); ?>" enctype="">
                                                <div class="input-group mt-4 mb-2 p-2">
                                                    <input type="text" class="form-control" name="com" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                                    <input type="hidden" value="<?php echo $publicacion['datos']['idPublicacion']; ?>" name="idPubCom">
                                                    <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
            <?php     }
                    }
                }
            } ?>
        </div>

        <!------------------- destacados--------------->
        <div class="col-md-4 m-3">

            <?php if ($destacados) {
                foreach ($destacados as $value) {
                    if (isset($_SESSION['usuario'])) {
            ?>
                        <div class="card col-12  border-top-0 mb-3">
                            <div class="position-relative">
                                <div class="position-absolute top-0 end-0"> <img src="public/img/des1.jpg" alt="" width="80" height="80" class="ms-2"></div>
                            </div>
                            <div class="col-md-10 p-4  d-flex">
                                <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $value['datos']['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $value['datos']['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>

                                <div class="ms-3 col-md-10">
                                    <span class="fw-bold"><?php echo $value['datos']['Nombre'] . " " . $value['datos']['Apellido']; ?></span><br>
                                    <small class="text-muted">
                                        <?php
                                        setlocale(LC_TIME, 'ES.UTF-8');
                                        echo strftime("%A, %d de %B de %Y", strtotime($value['datos']['FechaCreacion']));
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="container">
                                <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $value['datos']['Categoria']; ?></span>
                                <h5 class="card-text m-1 mb-4"><?php echo $value['datos']['Titulo']; ?></h5>
                                <a href="<?php echo $helper->url("Publicacion", "detalle") . '&idImg=' . $value['datos']['idPublicacion']; ?>"> <img src="<?php echo 'public/img/' . $value['datos']['Imagen']; ?>" class=" rounded img-fluid icono" title="detalle" alt="..."></a>
                            </div>
                            <div class="card-body">

                                <div class="row mb-2 mt-2 text-center">
                                    <small><?php echo "Calificación: " . round($value['cal']['AVG(Valoracion)'], 1) . " estrellas"; ?></small>
                                    <div class="col-md-12">
                                        <?php if (isset($_SESSION['usuario'])) {

                                            if ($value['mical']) {
                                                for ($i = 0; $i < intval($value['mical']['Valoracion']); $i++) {
                                                    echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                                }
                                            } else { ?>
                                                <form method="POST" name="formCali" action="<?php echo $helper->url("Valoracion", "index"); ?>" enctype="">
                                                    <input type="radio" style="display: none;" id="r1<?php echo $value['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                    <label for="r1<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r2<?php echo $value['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                    <label for="r2<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r3<?php echo $value['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                    <label for="r3<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r4<?php echo $value['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                    <label for="r4<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r5<?php echo $value['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                    <label for="r5<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="hidden" value="<?php echo $value['datos']['idPublicacion']; ?>" name="idPubCal">
                                                    <button class="btn btn-sm d-none" id="btn<?php echo $value['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                </form>


                                            <?php }

                                            echo "</div>";
                                        } else { ?>

                                            <form method="POST" name="formCali" action="<?php echo $helper->url("Comentario", "crear"); ?>" enctype="">
                                                <input type="radio" style="display: none;" id="r1<?php echo $value['idPublicacion']; ?>" value="1" name="cali" required>
                                                <label for="r1<?php echo $value['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $value['idPublicacion']; ?>" title="calificar"></i></label>
                                                <input type="radio" style="display: none;" id="r2<?php echo $value['idPublicacion']; ?>" value="2" name="cali">
                                                <label for="r2<?php echo $value['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $value['idPublicacion']; ?>" title="calificar"></i></label>
                                                <input type="radio" style="display: none;" id="r3<?php echo $value['idPublicacion']; ?>" value="3" name="cali">
                                                <label for="r3<?php echo $value['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $value['idPublicacion']; ?>" title="calificar"></i></label>
                                                <input type="radio" style="display: none;" id="r4<?php echo $value['idPublicacion']; ?>" value="4" name="cali">
                                                <label for="r4<?php echo $value['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $value['idPublicacion']; ?>" title="calificar"></i></label>
                                                <input type="radio" style="display: none;" id="r5<?php echo $value['idPublicacion']; ?>" value="5" name="cali">
                                                <label for="r5<?php echo $value['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $value['idPublicacion']; ?>" title="calificar"></i></label>
                                                <input type="hidden" value="<?php echo $value['idPublicacion']; ?>" name="idPubCal">
                                                <button class="btn btn-sm d-none" id="btn<?php echo $value['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                            </form>
                                    </div>
                                <?php  }  ?>

                                <div class="col-md-12 mt-1 mb-1">
                                    <?php if ($value['et']) {
                                        foreach ($value['et'] as $val) {
                                    ?>
                                            <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                                <?php echo $val['Nombre']; ?>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $value['datos']['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $value['datos']['idPublicacion'] ?>">
                                        <i class="far fa-comment"></i>
                                        <small class="text-muted">Comentarios</small>
                                    </div>
                                </div>
                                </div>
                                <div class="p-3 collapse scroll" id="<?php echo 'com' . $value['datos']['idPublicacion'] ?>">
                                    <?php if ($value['com']) {

                                        foreach ($value['com'] as $com) {
                                            if ($com != "") {
                                    ?>
                                                <div class="mt-2 mb-2 d-flex">
                                                    <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $com['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>
                                                    <div class="ms-3">
                                                        <span class="fw-bold"><?php echo $com['Nombre'] . " " . $com['Apellido']; ?></span><br>
                                                        <small class="text-muted">
                                                            <?php setlocale(LC_TIME, "spanish");
                                                            $Nueva_Fecha = date("d-m-Y", strtotime($com['Fecha']));
                                                            echo strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha));
                                                            ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                <p class="card-text text-muted mt-2"><?php echo $com['Descripcion']; ?></p>
                                                <hr>
                                    <?php }
                                        }
                                    } ?>
                                    <form method="POST" name="formAddCom" action="<?php echo $helper->url("Comentario", "crear"); ?>" enctype="">
                                        <div class="input-group mt-4 mb-2 p-2">
                                            <input type="text" class="form-control" name="com" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                            <input type="hidden" value="<?php echo  $value['datos']['idPublicacion']; ?>" name="idPubCom">
                                            <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php } else {
                        if ($value['datos']['Estado'] == "publica") { ?>
                            <div class="card col-12  border-top-0 mb-3">
                                <div class="position-relative">
                                    <div class="position-absolute top-0 end-0"> <img src="public/img/des1.jpg" alt="" width="80" height="80" class="ms-2"></div>
                                </div>
                                <div class="col-md-10 p-4  d-flex">
                                    <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $value['datos']['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $value['datos']['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>

                                    <div class="ms-3 col-md-10">
                                        <span class="fw-bold"><?php echo $value['datos']['Nombre'] . " " . $value['datos']['Apellido']; ?></span><br>
                                        <small class="text-muted">
                                            <?php
                                            setlocale(LC_TIME, 'ES.UTF-8');
                                            echo strftime("%A, %d de %B de %Y", strtotime($value['datos']['FechaCreacion']));
                                            ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="container">
                                    <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $value['datos']['Categoria']; ?></span>
                                    <h5 class="card-text m-1 mb-4"><?php echo $value['datos']['Titulo']; ?></h5>
                                    <a href="<?php echo $helper->url("Publicacion", "detalle") . '&idImg=' . $value['datos']['idPublicacion']; ?>"> <img src="<?php echo 'public/img/' . $value['datos']['Imagen']; ?>" class=" rounded img-fluid icono" title="detalle" alt="..."></a>
                                </div>
                                <div class="card-body">

                                    <div class="row mb-2 mt-2 text-center">
                                        <small><?php echo "Calificación: " . round($value['cal']['AVG(Valoracion)'], 1) . " estrellas"; ?></small>
                                        <div class="col-md-12">
                                            <?php if (isset($_SESSION['usuario'])) {

                                                if ($value['mical']) {
                                                    for ($i = 0; $i < intval($value['mical']['Valoracion']); $i++) {
                                                        echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                                    }
                                                } else { ?>
                                                    <form method="POST" name="formCali" action="<?php echo $helper->url("Valoracion", "index"); ?>" enctype="">
                                                        <input type="radio" style="display: none;" id="r1<?php echo $value['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                        <label for="r1<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r2<?php echo $value['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                        <label for="r2<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r3<?php echo $value['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                        <label for="r3<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r4<?php echo $value['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                        <label for="r4<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="radio" style="display: none;" id="r5<?php echo $value['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                        <label for="r5<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                        <input type="hidden" value="<?php echo $value['datos']['idPublicacion']; ?>" name="idPubCal">
                                                        <button class="btn btn-sm d-none" id="btn<?php echo $value['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                    </form>


                                                <?php }

                                                echo "</div>";
                                            } else { ?>

                                                <form method="POST" name="formCali" action="<?php echo $helper->url("Valoracion", "index"); ?>" enctype="">
                                                    <input type="radio" style="display: none;" id="r1<?php echo $value['datos']['idPublicacion']; ?>" value="1" name="cali" required>
                                                    <label for="r1<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono ms-2" onclick="calificar(this)" style="color:#cbd1ce" id="1<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r2<?php echo $value['datos']['idPublicacion']; ?>" value="2" name="cali">
                                                    <label for="r2<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="2<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r3<?php echo $value['datos']['idPublicacion']; ?>" value="3" name="cali">
                                                    <label for="r3<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="3<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r4<?php echo $value['datos']['idPublicacion']; ?>" value="4" name="cali">
                                                    <label for="r4<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="4<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="radio" style="display: none;" id="r5<?php echo $value['datos']['idPublicacion']; ?>" value="5" name="cali">
                                                    <label for="r5<?php echo $value['datos']['idPublicacion']; ?>"><i class="fas fa-star icono" onclick="calificar(this)" style="color:#cbd1ce" id="5<?php echo $value['datos']['idPublicacion']; ?>" title="calificar"></i></label>
                                                    <input type="hidden" value="<?php echo $value['datos']['idPublicacion']; ?>" name="idPubCal">
                                                    <button class="btn btn-sm d-none" id="btn<?php echo $value['datos']['idPublicacion']; ?>" name="btnAddCal"><i class="fas fa-check text-success" title="aceptar" type="submit"></i></button>

                                                </form>
                                        </div>
                                    <?php  }  ?>

                                    <div class="col-md-12 mt-1 mb-1">
                                        <?php if ($value['et']) {
                                            foreach ($value['et'] as $val) {
                                        ?>
                                                <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                                    <?php echo $val['Nombre']; ?>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $value['datos']['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $value['datos']['idPublicacion'] ?>">
                                            <i class="far fa-comment"></i>
                                            <small class="text-muted">Comentarios</small>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="p-3 collapse scroll" id="<?php echo 'com' . $value['datos']['idPublicacion'] ?>">
                                        <?php if ($value['com']) {

                                            foreach ($value['com'] as $com) {
                                                if ($com != "") {
                                        ?>
                                                    <div class="mt-2 mb-2 d-flex">
                                                        <a href="<?php echo $helper->url("Inicio", "publicaciones") . '&idUser=' . $com['idUsuario']; ?>"> <img src="<?php echo 'public/img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1"></a>
                                                        <div class="ms-3">
                                                            <span class="fw-bold"><?php echo $com['Nombre'] . " " . $com['Apellido']; ?></span><br>
                                                            <small class="text-muted">
                                                                <?php setlocale(LC_TIME, "spanish");
                                                                $Nueva_Fecha = date("d-m-Y", strtotime($com['Fecha']));
                                                                echo strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha));
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <p class="card-text text-muted mt-2"><?php echo $com['Descripcion']; ?></p>
                                                    <hr>
                                        <?php }
                                            }
                                        } ?>
                                        <form method="POST" name="formAddCom" action="<?php echo $helper->url("Comentario", "crear"); ?>" enctype="">
                                            <div class="input-group mt-4 mb-2 p-2">
                                                <input type="text" class="form-control" name="com" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                                <input type="hidden" value="<?php echo  $value['datos']['idPublicacion']; ?>" name="idPubCom">
                                                <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

            <?php     }
                    }
                }
            } ?>
        </div>
    </div>
    <?php require_once("public/script.php"); ?>
    <?php require_once("public/footer.php"); ?>
</body>

</html>