<?php session_start();if (isset($_SESSION['usuario'])){
require_once("ClassUsuario.php");
require_once("ClassInteres.php");
$usuario=new Usuario();
$id=$_SESSION['usuario'];
$datos=$usuario->perfil($id);
$interes=new Interes();
$datos2=$interes->intereses($id);?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("head.php"); ?>
</head>

<body class="estilo">
    <header>
        <?php require_once("header.php"); ?>
    </header>
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
    <?php
if (isset($_POST['addInt']) && isset($_POST['btnAdd'])) {
    if($interes->alta($_POST['addInt'],$id)){
        $_SESSION['exito']="Interes agregado con exito";
        header("location:perfil.php");
    }
}
if (isset($_GET['idInt'])) { 
   if($interes->baja($_GET['idInt'],$id)){
    $_SESSION['exito']="Interes eliminado con exito";
       header("location:perfil.php");
   }
}

if (isset($_POST['btn-editarPerfil'])) {
    $n=$_POST['nombre'];
    $a=$_POST['apellido'];
    $m=$_POST['mail'];
    $t=$_POST['tel'];
   if($_FILES['foto']['name']!=""){
    $f= $_FILES['foto']["name"];
	$destino=$_SERVER['DOCUMENT_ROOT']."/fotaza/img/".$f;
	$tmp= $_FILES['foto']["tmp_name"];
	move_uploaded_file($tmp,$destino);
   }else{ $f=$datos['Foto'];}
    if($usuario->editar($id,$n,$a,$m,$t,$f)){
        $_SESSION['foto']=$f;
        $_SESSION['exito']="Perfil actualizado con exito";
        header("location:perfil.php");
    }
}

?>
    <div class="container d-flex justify-content-center mt-3">
        <div class="col-md-10 card mb-3">
            <div class=" mb-3">
                <div class="card-body">
                    <h4 class=" text-center mt-3 mb-4"></h4>
                    <div class="row">
                        <div class="col-md-12 text-center mb-5">
                            <img src="<?php echo 'img/'.$datos['Foto'] ?>" data-bs-toggle="modal"
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
                            <a href='<?php echo"perfil.php?idInt=$value[idInteres]";?>'
                                onclick="return confirm('eliminar Interes?')">
                                <i class="fas fa-times text-danger icono" id="" title="quitar"></i></a>

                            <?php } 
                                }?>
                            <form method="POST" id="formAdd" name="formAdd" action="" enctype="">
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
                    <form method="POST" name="formaperfil" action="" enctype="multipart/form-data">
                        <div class="mb-3 ">
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
                <img src="<?php echo 'img/'.$datos['Foto'] ?>" class="img-fluid" alt="">
            </div>
        </div>
    </div>
    <?php require_once("script.php"); ?>
    <?php require_once("footer.php"); ?>
</body>

</html>
<?php  }else{header("location:login.php");}?>