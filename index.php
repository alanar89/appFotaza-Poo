<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("head.php"); ?>
    <script src="js/calificar.js"></script>
</head>

<body class="estilo">
    <header>
        <?php require_once("header.php"); ?>
    </header>
    <?php if (isset($_SESSION['buscar'])) { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        </svg>
        <div class="mt-2 alert alert-danger alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                <use xlink:href="#info-fill" />
            </svg> Sin resultados de busqueda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION['buscar']);
    } ?>
    <?php if (isset($_SESSION['exito'])) { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="mt-2 alert alert-success alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
            <use xlink:href="#check-circle-fill"/>
            </svg><?php echo $_SESSION['exito']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION['exito']);
    } ?>
    <div class="container d-md-flex">

        <div class="col-md-8">
            <?php
            require_once("ClassPublicacion.php");
            require_once("ClassEtiqueta.php");
            require_once("ClassComentario.php");
            require_once("ClassValoracion.php");

            $publicaciones = new Publicacion();
            $etiquetas = new Etiqueta();
            $comentarios = new Comentario();
            $validacion = new Valoracion();
            if (isset($_POST['coment']) && isset($_POST['btnAddCom'])) {
                if (isset($_SESSION['usuario'])) {
                    $fecha = date("y/m/d H:i:s");
                    if ($comentarios->alta($_POST['coment'], $_POST['idPubCom'], $_SESSION['usuario'], $fecha)) {
                        $_SESSION['exito']="Comentario exitoso";
                        header("location:index.php");
                    }
                } else {
                    header("location:login.php");
                }
            }
            if (isset($_POST['cali']) && isset($_POST['btnAddCal'])) {
                if (isset($_SESSION['usuario'])) {
                    if ($validacion->alta($_POST['cali'], $_POST['idPubCal'], $_SESSION['usuario'])) {
                        $_SESSION['exito']="Calificacion exitosa";
                        header("location:index.php");
                    }
                } else {
                    header("location:login.php");
                }
            }

            if (isset($_POST['buscar']) && isset($_POST['btn-buscar'])) {
                if (isset($_SESSION['usuario'])) {
                    $publicacion = $publicaciones->buscarPublicaciones($_POST['buscar']);
                } else {
                    $publicacion = $publicaciones->buscarPublicacionesPublicas($_POST['buscar']);
                }
            }
            if (!isset($_POST['buscar']) && !isset($_POST['btn-buscar'])) {
                $publicacion = $publicaciones->publicaciones();
            } else {
                if (!$publicacion) {
                    $_SESSION['buscar'] = "";
                    header("location:index.php");
                }
            }
            $destacadosPrivado = [];
            $destacados = [];
            foreach ($publicacion as $key => $value) {
                $dpv = false;
                $dv = false;
                $etiqueta = $etiquetas->etiquetas($value['idPublicacion']);
                $comentario = $comentarios->comentarios($value['idPublicacion']);
                $calificacion = $validacion->valoraciones($value['idPublicacion']);
                $c = $validacion->cantidad($value['idPublicacion']);
                if (!isset($_POST['buscar']) && !isset($_POST['btn-buscar'])) {
                if ($c['COUNT(Valoracion)'] >= 5) {

                    if ($calificacion['AVG(Valoracion)'] >= 4) {
                        $datos = [
                            'idPublicacion' => $value['idPublicacion'],
                            'Titulo' => $value['Titulo'],
                            'Categoria' => $value['Categoria'],
                            'Imagen' => $value['Imagen'],
                            'FechaCreacion' => $value['FechaCreacion'],
                            'Formato' => $value['Formato'],
                            'Resolucion' => $value['Resolucion'],
                            'DerechosDeUso' => $value['DerechosDeUso'],
                            'Nombre' => $value['Nombre'],
                            'Apellido' => $value['Apellido'],
                            'Foto' => $value['Foto']
                        ];
                        if (isset($_SESSION['usuario'])) {
                            $destacadosPrivado[] = $datos;
                            $dpv = true;
                        }
                        if ($value['Estado'] != "protegida") {
                            $destacados[] = $datos;
                            $dv = true;
                        }
                    }
                }
            }
                if (!$dpv && $value['Estado'] == "protegida" && isset($_SESSION['usuario'])) {
            ?>
                    <div class="m-3">
                        <div class="card col-12  mb-3">
                            <div class="p-4 pb-2 mt-2  d-flex">
                                <img src="<?php echo 'img/' . $value['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
                                <div class="ms-3">
                                    <span class="fw-bold"><?php echo $value['Nombre'] . " " . $value['Apellido']; ?></span><br>
                                    <small class="text-muted">
                                        <?php
                                        setlocale(LC_TIME, 'ES.UTF-8');
                                        echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion']));
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="container">
                                <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $value['Categoria']; ?></span>
                                <h5 class="card-text m-1 mb-4"><?php echo $value['Titulo']; ?></h5>
                                <img src="<?php echo 'img/' . $value['Imagen']; ?>" class=" rounded img-fluid icono" data-bs-toggle="modal" data-bs-target="#<?php echo 'ver' . $value['idPublicacion'] ?>" title="detalle" alt="...">
                            </div>
                            <div class="card-body">

                                <div class="row mb-4 mt-2 justify-content-center text-center text-md-start">
                                    <div class="ms-md-3"><small><?php echo "Calificación: " . floatval($calificacion['AVG(Valoracion)']) . " estrellas"; ?></small></div>
                                    <div class="col-md-4">
                                        <?php if ($validacion->valoracion($value['idPublicacion'], $_SESSION['usuario'])) {

                                            for ($i = 0; $i < intval($calificacion['AVG(Valoracion)']); $i++) {
                                                echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                            }
                                            echo "</div>";
                                        } else { ?>

                                            <form method="POST" name="formCali" action="" enctype="">
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
                                <?php  } ?>
                                <div class="col-md-5 mt-1 mb-1 mt-md-0 mb-md-0">
                                    <?php if ($etiqueta) {
                                        foreach ($etiqueta as $val) {
                                    ?>
                                            <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                                <?php echo $val['Nombre']; ?>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="col-md-3">
                                    <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $value['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $value['idPublicacion'] ?>">
                                        <i class="far fa-comment"></i>
                                        <small class="text-muted">Comentarios</small>
                                    </div>
                                </div>
                                </div>
                                <div class="p-3 collapse scroll" id="<?php echo 'com' . $value['idPublicacion'] ?>">
                                    <?php if ($comentario) {
                                        foreach ($comentario as $com) {
                                    ?>
                                            <div class="mt-2 mb-2 d-flex">
                                                <img src="<?php echo 'img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
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
                                    } ?>
                                    <form method="POST" name="formAddCom" action="" enctype="">
                                        <div class="input-group mt-4 mb-2 p-2">
                                            <input type="text" class="form-control" name="coment" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                            <input type="hidden" value="<?php echo $value['idPublicacion']; ?>" name="idPubCom">
                                            <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- modal informacion publicacion -->
                    <div class="modal fade" id="<?php echo "ver" . $value['idPublicacion'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card">
                                    <img src="<?php echo 'img/' . $value['Imagen'] ?>" class="img-fluid" alt="">
                                    <div class="card-body ms-5">
                                        <p class="display-6">Información de la foto</p>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Titulo</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Titulo']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Categoria</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Categoria']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Formato</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Formato']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Resolucion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Resolucion']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Derechos de uso</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['DerechosDeUso']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Fecha Publicacion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php setlocale(LC_TIME, 'ES.UTF-8');
                                                echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                if (!$dv && $value['Estado'] != "protegida") { ?>
                    <div class="m-3">
                        <div class="card col-12  mb-3">
                            <div class="p-4 pb-2 mt-2  d-flex">
                                <img src="<?php echo 'img/' . $value['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
                                <div class="ms-3">
                                    <span class="fw-bold"><?php echo $value['Nombre'] . " " . $value['Apellido']; ?></span><br>
                                    <small class="text-muted">
                                        <?php
                                        setlocale(LC_TIME, 'ES.UTF-8');
                                        echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion']));
                                        ?>
                                    </small>
                                </div>
                            </div>
                            <div class="container">
                                <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $value['Categoria']; ?></span>
                                <h5 class="card-text m-1 mb-4"><?php echo $value['Titulo']; ?></h5>
                                <img src="<?php echo 'img/' . $value['Imagen']; ?>" class=" rounded img-fluid icono" data-bs-toggle="modal" data-bs-target="#<?php echo 'ver' . $value['idPublicacion'] ?>" title="detalle" alt="...">
                            </div>
                            <div class="card-body">

                                <div class="row mb-4 mt-2 justify-content-center  text-center text-md-start">
                                    <small><?php echo "Calificación: " . floatval($calificacion['AVG(Valoracion)']) . " estrellas"; ?></small>
                                    <div class="col-md-4">
                                        <?php if (isset($_SESSION['usuario'])) {

                                            if ($validacion->valoracion($value['idPublicacion'], $_SESSION['usuario'])) {
                                                for ($i = 0; $i < intval($calificacion['AVG(Valoracion)']); $i++) {
                                                    echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                                }
                                            } else { ?>
                                                <form method="POST" name="formCali" action="" enctype="">
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
                                            <?php }
                                            echo "</div>";
                                        } else { ?>

                                            <form method="POST" name="formCali" action="" enctype="">
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
                                <?php  } ?>
                                <div class="col-md-5 mt-1 mb-1 mt-md-0 mb-md-0">
                                    <?php if ($etiqueta) {
                                        foreach ($etiqueta as $val) {
                                    ?>
                                            <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                                <?php echo $val['Nombre']; ?>
                                            </div>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="col-md-3">
                                    <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $value['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $value['idPublicacion'] ?>">
                                        <i class="far fa-comment"></i>
                                        <small class="text-muted">Comentarios</small>
                                    </div>
                                </div>
                                </div>
                                <div class="p-3 collapse scroll" id="<?php echo 'com' . $value['idPublicacion'] ?>">
                                    <?php if ($comentario) {

                                        foreach ($comentario as $com) {
                                    ?>
                                            <div class="mt-2 mb-2 d-flex">
                                                <img src="<?php echo 'img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
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
                                    } ?>

                                    <form method="POST" name="formAddCom" action="" enctype="">
                                        <div class="input-group mt-4 mb-2 p-2">
                                            <input type="text" class="form-control" name="coment" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                            <input type="hidden" value="<?php echo $value['idPublicacion']; ?>" name="idPubCom">
                                            <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- modal informacion publicacion -->
                    <div class="modal fade" id="<?php echo "ver" . $value['idPublicacion'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card">
                                    <img src="<?php echo 'img/' . $value['Imagen'] ?>" class="img-fluid" alt="">
                                    <div class="card-body ms-5">
                                        <p class="display-6">Información de la foto</p>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Titulo</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Titulo']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Categoria</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Categoria']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Formato</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Formato']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Resolucion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Resolucion']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Derechos de uso</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['DerechosDeUso']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Fecha Publicacion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php setlocale(LC_TIME, 'ES.UTF-8');
                                                echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <!-- publicaciones destacadas -->
        <?php if (isset($_SESSION['usuario'])) { ?>
            <div class="col-md-4 m-3">
                <?php foreach ($destacadosPrivado as $key => $value) {
                    $etiqueta = $etiquetas->etiquetas($value['idPublicacion']);
                    $comentario = $comentarios->comentarios($value['idPublicacion']);
                    $calificacion = $validacion->valoraciones($value['idPublicacion']); ?>
                    <div class="card col-12  border-top-0  mb-3">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0"> <img src="img/des1.jpg" alt="" width="80" height="80" class="ms-2"></div>
                        </div>
                        <div class="col-md-10 p-4  d-flex">
                            <img src="<?php echo 'img/' . $value['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">

                            <div class="ms-3 col-md-10">
                                <span class="fw-bold"><?php echo $value['Nombre'] . " " . $value['Apellido']; ?></span><br>
                                <small class="text-muted">
                                    <?php
                                    setlocale(LC_TIME, 'ES.UTF-8');
                                    echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion']));
                                    ?>
                                </small>
                            </div>
                        </div>
                        <div class="container">
                            <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $value['Categoria']; ?></span>
                            <h5 class="card-text m-1 mb-4"><?php echo $value['Titulo']; ?></h5>
                            <img src="<?php echo 'img/' . $value['Imagen']; ?>" class=" rounded img-fluid icono" data-bs-toggle="modal" data-bs-target="#<?php echo 'ver' . $value['idPublicacion'] ?>" title="detalle" alt="...">
                        </div>
                        <div class="card-body">

                            <div class="row mb-2 mt-2 text-center">
                                <small><?php echo "Calificación: " . floatval($calificacion['AVG(Valoracion)']) . " estrellas"; ?></small>
                                <div class="col-md-12">
                                    <?php if ($validacion->valoracion($value['idPublicacion'], $_SESSION['usuario'])) {


                                        for ($i = 0; $i < intval($calificacion['AVG(Valoracion)']); $i++) {
                                            echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                        }
                                        echo "</div>";
                                    } else { ?>

                                        <form method="POST" name="formCali" action="" enctype="">
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
                            <?php  } ?>
                            <div class="col-md-12 mt-1 mb-1">
                                <?php if ($etiqueta) {
                                    foreach ($etiqueta as $val) {
                                ?>
                                        <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                            <?php echo $val['Nombre']; ?>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                            <div class="col-md-12">
                                <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $value['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $value['idPublicacion'] ?>">
                                    <i class="far fa-comment"></i>
                                    <small class="text-muted">Comentarios</small>
                                </div>
                            </div>
                            </div>
                            <div class="p-3 collapse scroll" id="<?php echo 'com' . $value['idPublicacion'] ?>">
                                <?php if ($comentario) {

                                    foreach ($comentario as $com) {
                                ?>
                                        <div class="mt-2 mb-2 d-flex">
                                            <img src="<?php echo 'img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
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
                                } ?>
                                <form method="POST" name="formAddCom" action="" enctype="">
                                    <div class="input-group mt-4 mb-2 p-2">
                                        <input type="text" class="form-control" name="coment" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                        <input type="hidden" value="<?php echo $value['idPublicacion']; ?>" name="idPubCom">
                                        <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- modal informacion publicacion -->
                    <div class="modal fade" id="<?php echo "ver" . $value['idPublicacion'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card">
                                    <img src="<?php echo 'img/' . $value['Imagen'] ?>" class="img-fluid" alt="">
                                    <div class="card-body ms-5">
                                        <p class="display-6">Información de la foto</p>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Titulo</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Titulo']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Categoria</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Categoria']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Formato</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Formato']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Resolucion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Resolucion']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Derechos de uso</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['DerechosDeUso']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Fecha Publicacion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php setlocale(LC_TIME, 'ES.UTF-8');
                                                echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="col-md-4 m-3">
                <?php foreach ($destacados as $key => $value) {
                    $etiqueta = $etiquetas->etiquetas($value['idPublicacion']);
                    $comentario = $comentarios->comentarios($value['idPublicacion']);
                    $calificacion = $validacion->valoraciones($value['idPublicacion']); ?>
                    <div class="card col-12  border-top-0 mb-3">
                        <div class="position-relative">
                            <div class="position-absolute top-0 end-0"> <img src="img/des1.jpg" alt="" width="80" height="80" class="ms-2"></div>
                        </div>
                        <div class="col-md-10 p-4  d-flex">
                            <img src="<?php echo 'img/' . $value['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">

                            <div class="ms-3 col-md-10">
                                <span class="fw-bold"><?php echo $value['Nombre'] . " " . $value['Apellido']; ?></span><br>
                                <small class="text-muted">
                                    <?php
                                    setlocale(LC_TIME, 'ES.UTF-8');
                                    echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion']));
                                    ?>
                                </small>
                            </div>
                        </div>
                        <div class="container">
                            <span class="m-1 mb-3  text-uppercase fw-light badge rounded-pill bg-success icono" title="categoria"><?php echo $value['Categoria']; ?></span>
                            <h5 class="card-text m-1 mb-4"><?php echo $value['Titulo']; ?></h5>
                            <img src="<?php echo 'img/' . $value['Imagen']; ?>" class=" rounded img-fluid icono" data-bs-toggle="modal" data-bs-target="#<?php echo 'ver' . $value['idPublicacion'] ?>" title="detalle" alt="...">
                        </div>
                        <div class="card-body">

                            <div class="row mb-2 mt-2 text-center">
                                <small><?php echo "Calificación: " . floatval($calificacion['AVG(Valoracion)']) . " estrellas"; ?></small>
                                <div class="col-md-12">
                                    <?php if (isset($_SESSION['usuario'])) {

                                        if ($validacion->valoracion($value['idPublicacion'], $_SESSION['usuario'])) {
                                            for ($i = 0; $i < intval($calificacion['AVG(Valoracion)']); $i++) {
                                                echo '<i class="fas fa-star" style="color:#1630d9"></i>';
                                            }
                                        } else { ?>
                                            <form method="POST" name="formCali" action="" enctype="">
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


                                        <?php }

                                        echo "</div>";
                                    } else { ?>

                                        <form method="POST" name="formCali" action="" enctype="">
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
                                <?php if ($etiqueta) {
                                    foreach ($etiqueta as $val) {
                                ?>
                                        <div class="badge bg-primary text-wrap icono" title="etiqueta">
                                            <?php echo $val['Nombre']; ?>
                                        </div>
                                <?php }
                                } ?>
                            </div>
                            <div class="col-md-12">
                                <div class="icono" data-bs-toggle="collapse" data-bs-target="#<?php echo 'com' . $value['idPublicacion'] ?>" aria-expanded="false" aria-controls="<?php echo 'com' . $value['idPublicacion'] ?>">
                                    <i class="far fa-comment"></i>
                                    <small class="text-muted">Comentarios</small>
                                </div>
                            </div>
                            </div>
                            <div class="p-3 collapse scroll" id="<?php echo 'com' . $value['idPublicacion'] ?>">
                                <?php if ($comentario) {

                                    foreach ($comentario as $com) {
                                ?>
                                        <div class="mt-2 mb-2 d-flex">
                                            <img src="<?php echo 'img/' . $com['Foto']; ?>" alt="" width="40" height="40" class="foto mt-1">
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
                                } ?>

                                <form method="POST" name="formAddCom" action="" enctype="">
                                    <div class="input-group mt-4 mb-2 p-2">
                                        <input type="text" class="form-control" name="coment" placeholder="comentar..." aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                        <input type="hidden" value="<?php echo $value['idPublicacion']; ?>" name="idPubCom">
                                        <span class=""><button type="submit" name="btnAddCom" class="btn btn-primary"><i class="fas fa-comment-dots"></i></button></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- modal informacion publicacion -->
                    <div class="modal fade" id="<?php echo "ver" . $value['idPublicacion'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="card">
                                    <img src="<?php echo 'img/' . $value['Imagen'] ?>" class="img-fluid" alt="">
                                    <div class="card-body ms-5">
                                        <p class="display-6">Información de la foto</p>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Titulo</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Titulo']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Categoria</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Categoria']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0">Formato</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Formato']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Resolucion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['Resolucion']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Derechos de uso</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php echo $value['DerechosDeUso']; ?>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-6">
                                                <h6 class="mb-0"> Fecha Publicacion</h6>
                                            </div>
                                            <div class="col-md-6 text-secondary">
                                                <?php setlocale(LC_TIME, 'ES.UTF-8');
                                                echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php  } ?>
    </div>
    <?php require_once("script.php"); ?>
    <?php require_once("footer.php"); ?>
</body>

</html>