<?php if (isset($_SESSION['usuario'])){
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("public/head.php"); ?>
</head>

<body class="estilo">
    <header>
        <?php require_once("public/header.php"); ?>
    </header>
    <?php if (isset($_SESSION['exito'])) { ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        </svg>
        <div class="mt-2 alert alert-success alert-dismissible fade show " role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
            <use xlink:href="#check-circle-fill"/>
            </svg><?php echo $_SESSION['exito']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php unset($_SESSION['exito']);
    } ?> 


    <div class="container d-flex justify-content-center mt-3">
  
        <div class="col-md-10 card mb-3">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb m-3">
    <li class="breadcrumb-item"><a href="<?php echo $helper->url("Inicio","index"); ?>">Inicio</a></li>
    <li class="breadcrumb-item active" aria-current="page">Perfil</li>
  </ol>
</nav>
            <div class=" mb-3">
                <div class="card-body">
                    <h4 class=" text-center mt-3 mb-4"></h4>
                    <div class="row">
                        <div class="col-md-12 text-center mb-5">
                            <img src="<?php echo 'public/img/'.$datos['Foto'] ?>" data-bs-toggle="modal"
                                data-bs-target="#exampleModal1" class=" foto icono" title="ver" width="128"
                                height="120"><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class=" text-center mt-3 mb-5 text-uppercase">Datos Personales</h5>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Nombre</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $datos['Nombre'];?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Apellido</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $datos['Apellido'];?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $datos['Mail'];?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Telefono</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <?php echo $datos['Telefono'];?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="d-grid gap-2 d-sm-block">
                                    <button class="btn btn-primary " data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Editar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center ms-md-5">
                            <h5 class=" text-center mt-3 mb-5  text-uppercase">Intereses</h5>
                            <?php if($datos2){
                            foreach($datos2 as $value){
                            ?>

                            <span class="m-1 mb-3  text-uppercase badge rounded-pill bg-success">
                                <?php echo $value['Interes'];?></span>
                            <a href="<?php echo $helper->url("Interes","eliminar").'&idInt='.$value['idInteres']; ?>"
                                onclick="return confirm('eliminar Interes?')">
                                <i class="fas fa-times text-danger icono" id="" title="quitar"></i></a>

                            <?php } 
                                }?>
                            <form method="POST" id="formAdd" name="formAdd" action="<?php echo $helper->url("Interes","crear"); ?>" enctype="">
                                <div class="input-group  mt-3 col-4">
                                    <input type="text" id="addInt" name="addInt" class="form-control form-control-sm"
                                        placeholder="intereses.." aria-label="" aria-describedby="basic-addon2"
                                        required>
                                    <button class="btn btn-primary btn-sm" type="submit" name="btnAdd">Agregar</button>
                                </div>
                            </form>
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
                    <h5 class="modal-title " id="exampleModalLabel">Editar perfil</h5>
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" name="formaperfil"  action="<?php echo $helper->url("Usuario","actualizar"); ?>" enctype="multipart/form-data">
                        <div class="mb-3 ">
                        <input type="hidden" value="<?php echo $datos['Foto'];?>" id="fotop" name="fotop" >
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-sm"
                                value="<?php echo $datos['Nombre'];?>" id="nombre" name="nombre" aria-describedby=""
                                required>
                            <div id="nombreError" class="d-none mt-2 p-1 alert alert-danger">Ingrese nombre.</div>
                        </div>
                        <div class="mb-3 ">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control form-control-sm"
                                value="<?php echo $datos['Apellido'];?>" id="apellido" name="apellido"
                                aria-describedby="" required>
                            <div id="apellidoError" class="d-none mt-2 p-1 alert alert-danger">Ingrese apellido.</div>
                        </div>
                        <div class="mb-3 ">
                            <label for="mail" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm"
                                value="<?php echo $datos['Mail'];?>" id="mail" name="mail" aria-describedby="" required>
                            <div id="mailError" class="d-none mt-2 p-1 alert alert-danger">Ingrese un mail valido.</div>
                        </div>
                        <div class="mb-3 ">
                            <label for="tel" class="form-label">Telefono</label>
                            <input type="tel" class="form-control form-control-sm"
                                value="<?php echo $datos['Telefono'];?>" id="tel" name="tel" aria-describedby="">
                        </div>
                        <div class="mb-3 ">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control form-control-sm" id="foto"
                                aria-describedby="">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="btn-editarPerfil" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <img src="<?php echo 'public/img/'.$datos['Foto'] ?>" class="img-fluid" alt="">
            </div>
        </div>
    </div>
    <?php require_once("public/script.php"); ?>
    <?php require_once("public/footer.php"); ?>
</body>

</html>
<?php  }else{ echo $helper->url("Usuario","login");}?>