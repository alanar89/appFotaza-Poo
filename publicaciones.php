<?php session_start();
if (isset($_SESSION['usuario'])){
require_once("ClassPublicacion.php");
require_once("ClassEtiqueta.php");
require_once("ClassComentario.php");
$id=$_SESSION['usuario'];
 $publicaciones= new Publicacion();
 $publicacion=$publicaciones->misPublicaciones($id);
 $etiquetas= new Etiqueta();  
 $comentarios=new Comentario(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once("head.php");?>
    <script src="js/imagen.js"></script>
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
} ?><?php
 if (isset($_GET['idImg'])) { 
    if($publicaciones->baja($_GET['idImg'],$id)){
        $_SESSION['exito']="Publicacion eliminada con exito";
        header("location:publicaciones.php");
    }
 } 

 if (isset($_GET['idTag'])) { 
    if($etiquetas->baja($_GET['idTag'],$_GET['idPub'])){
        $_SESSION['exito']="Etiqueta eliminada con exito";
        header("location:publicaciones.php");
    }
 } 

 if (isset($_POST['addTag']) && isset($_POST['btnAdd'])) {
    if($etiquetas->alta($_POST['addTag'],$_POST['idPub'])){
        $_SESSION['exito']="Etiqueta agregada con exito";
        header("location:publicaciones.php");
    }    
}

if (isset($_POST['coment']) && isset($_POST['btnAddCom'])) {
    $fecha= date("y/m/d H:i:s");
    if($comentarios->alta($_POST['coment'],$_POST['idPubCom'],$id,$fecha)){
        $_SESSION['exito']="Comentario exitoso";
        header("location:publicaciones.php");
    }
      
}
if (isset($_POST['btn-editar'])) {
    $titulo=$_POST['titulo'];
$categoria=$_POST['categoria'];
$estado=$_POST['estado'];
$derechoUso=$_POST["duso"];
echo $derechoUso;
$pub=$_POST['idPubEditar'];
    if($publicaciones->editar($titulo,$categoria,$estado,$derechoUso,$pub)){
        $_SESSION['exito']="Publicacion actualizada con exito";
        header("location:publicaciones.php");
    }    
}
    ?>
    <div class="container d-flex justify-content-center mt-3">
        <div class="col-md-10 card mb-3 ">
            <div class="row row-cols-1 row-cols-md-3 g-4 m-1">
                <?php if($publicacion){
                foreach ($publicacion as $key => $value)  { 
                   $etiqueta=$etiquetas->etiquetas($value['idPublicacion']); 
                   $comentario=$comentarios->comentarios($value['idPublicacion']);
                    ?>
                <div class="col">
                    <div class="card">
                        <img src="<?php echo 'img/'.$value['Imagen'] ?>" class="card-img-top icono"
                            data-bs-toggle="modal" data-bs-target="#<?php echo 'ver'.$value['idPublicacion'] ?>"
                            title="Ver" alt="...">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $value['Titulo'] ?></h5>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#<?php echo 'editar'.$value['idPublicacion'] ?>"><i
                                    class="fas fa-edit icono" title="Editar"></i></button>
                            <a class="btn btn-primary"
                                href='<?php echo"publicaciones.php?idImg=$value[idPublicacion]";?>'>
                                <i class="fas fa-trash-alt icono" onclick="return confirm('eliminar imagen?')"
                                    title="Eliminar"></i></a>
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#<?php echo 'tags'.$value['idPublicacion'] ?>"><i
                                    class="fas fa-tags icono" title="Etiquetas"></i></button>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo 'com'.$value['idPublicacion'] ?>"><i
                                    class="fas fa-comment-dots" title="Comentarios"></i></button>
                        </div>
                    </div>
                </div>

                <!-- modal editar publicacion -->
                <div class="modal fade" id="<?php echo 'editar'.$value['idPublicacion'] ?>" tabindex="-1"
                    aria-labelledby="<?php echo 'editarLabel'.$value['idPublicacion'] ?>" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-light">
                                <h5 class="modal-title " id="<?php echo 'editarLabel'.$value['idPublicacion'] ?>">Editar
                                    publicación</h5>
                                <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" name="" action=""
                                    enctype="multipart/form-data">
                                    <!-- <div class="mb-3 ">
                                        <label for="imagen" class="form-label">Imagen</label>
                                        <input type="file" name="imagen" class="form-control form-control-sm"
                                            id="imagen" aria-describedby="">
                                    </div> -->
                                    <div class="mb-3 ">
                                        <label for="titulo" class="form-label">Titulo</label>
                                        <input type="text" class="form-control form-control-sm"
                                            value="<?php echo $value['Titulo'] ?>" id="titulo" name="titulo"
                                            aria-describedby="" required>
                                        <div id="tituloError" class="d-none mt-2 p-1 alert alert-danger">Ingrese titulo.
                                        </div>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="categoria" class="form-label">Categoria</label>
                                        <input type="text"    value="<?php echo $value['Categoria'] ?>" class="form-control form-control-sm" id="categoria"
                                            name="categoria" aria-describedby="" required>
                                        <div id="categoriaError" class="d-none mt-2 p-1 alert alert-danger">Ingrese
                                            categoria.</div>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="categoria" class="form-label">Estado</label>
                                        <select class="form-select form-select-sm"  name="estado" id="estado">
                                            <?php   if($value['Estado']=="publica"){ ?>
                                            <option value="publica" selected>Publica</option>
                                            <option value="protegida">Protegida</option>
                                            <?php  }else{ ?>
                                            <option value="publica">Publica</option>
                                            <option value="protegida" selected>Protegida</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 ">
                                        <label for="categoria" class="form-label">Derechos de uso</label>
                                        <select  class="form-select form-select-sm" name="duso" id="duso">
                                        <?php   if($value['DerechosDeUso']=="copyleft"){ ?>
                                            <option value="copyleft" selected>copyleft</option>
                                            <option value="copyright">copyright</option>
                                            <?php  }else{ ?>
                                                <option value="copyleft">copyleft</option>
                                            <option value="copyright" selected>copyright</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <input type="hidden" value="<?php echo $value['idPublicacion'];?>" name="idPubEditar" >
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" name="btn-editar" class="btn btn-primary">Guardar</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- modal etiquetas -->
                <div class="modal fade" id="<?php echo 'tags'.$value['idPublicacion'] ?>" tabindex="-1"
                    aria-labelledby="<?php echo 'tagsLabel'.$value['idPublicacion'] ?>" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-light">
                                <h5 class="modal-title " id="<?php echo 'tagsLabel'.$value['idPublicacion'] ?>">
                                    Etiquetas</h5>
                                <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12">
                                    <?php if($etiqueta){
                            foreach($etiqueta as $val){
                            ?>
                                    <span class="m-1 mb-3 icono badge text-wrap bg-success" title="Etiqueta">
                                        <?php echo $val['Nombre'];?></span>
                                    <a href='<?php echo"publicaciones.php?idTag=$val[idEtiqueta]&idPub=$value[idPublicacion]";?>'
                                        onclick="return confirm('eliminar etiqueta?')">
                                        <i class="fas fa-times text-danger icono" id="" title="quitar"></i></a>
                                    <?php } 
                                }?>
                                </div>
                                <form method="POST" name="" action="" enctype="">
                                    <div class="input-group  mt-3 col-4">
                                        <?php if(count($etiqueta)>=3) {?>
                                        <p class="alert alert-danger d-flex align-items-center" role="alert">Maximo de
                                            Etiquetas Permitidas.</p>
                                        <?php } else { ?>
                                        <input type="text" placeholder="Nueva etiqueta.."
                                            class="form-control form-control-sm" id="addTag" name="addTag" required>
                                        <input type="hidden" value="<?php echo $value['idPublicacion'];?>" name="idPub">
                                        <button class="btn btn-primary btn-sm" type="submit"
                                            name="btnAdd">Agregar</button>
                                        <?php }?>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- modal comentarios -->
                <div class="modal fade" id="<?php echo 'com'.$value['idPublicacion'] ?>" tabindex="-1" aria-labelledby="#<?php echo 'comlabel'.$value['idPublicacion'] ?>"
                    aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-light">
                                <h5 class="modal-title " id="#<?php echo 'comlabel'.$value['idPublicacion'] ?>">Comentarios</h5>
                                <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php if($comentario){
                                   
                            foreach($comentario as $com){
                            ?>
                                <div class="mt-2 mb-2 d-flex">
                                    <img src="<?php echo'img/'.$com['Foto'];?>" alt="" width="40" height="40" class="foto mt-1">
                                    <div class="ms-3">
                                        <span
                                            class="fw-bold"><?php echo $com['Nombre']." ".$com['Apellido'];?></span><br>
                                        <small class="text-muted"> <?php setlocale(LC_TIME, "spanish");
                            $Nueva_Fecha= date( "d-m-Y",strtotime( $com['Fecha']));
                             echo strftime("%A, %d de %B de %Y", strtotime($Nueva_Fecha)); ?></small>
                                    </div>
                                </div>
                                <p class="card-text text-muted mt-2"><?php echo $com['Descripcion'];?></p>
                                <hr>
                                <?php } } ?>
                                <form method="POST" id="" name="" action="" enctype="">
                                <div class="input-group mt-4 mb-2 p-2">
                                    <input type="text" class="form-control" name="coment" placeholder="comentar..."
                                        aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                        <input type="hidden" value="<?php echo $value['idPublicacion'];?>" name="idPubCom" >
                                    <span class=""><button type="submit"   name="btnAddCom" class="btn btn-primary"><i
                                                class="fas fa-comment-dots"></i></button></span>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- modal informacion publicacion -->
                <div class="modal fade" id="<?php echo "ver".$value['idPublicacion'] ?>" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="card">
                                <img src="<?php echo 'img/'.$value['Imagen'] ?>" class="img-fluid" alt="">
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
                                            <h6 class="mb-0">Privacidad</h6>
                                        </div>
                                        <div class="col-md-6 text-secondary">
                                            <?php echo $value['Estado']; ?>
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
                                            <?php setlocale(LC_TIME,'ES.UTF-8');
                                             echo strftime("%A, %d de %B de %Y", strtotime($value['FechaCreacion'])); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } }?>

                <!-- modal nueva publicacion -->
                <div class="col">
                    <div class="card icono mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <img src="img/subirFoto.svg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title text-center">Nueva publicacion <i
                                    class="fas fa-plus text-primary"></i></h5>
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
                    <button type="button" class="btn-close text-light" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" name="formPublicar" action="publicarImagen.php" enctype="multipart/form-data">
                        <div class="mb-3 ">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" name="imagen" class="form-control form-control-sm" required id="imagen"
                                aria-describedby="">
                        </div>
                        <div class="mb-3 ">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo"
                                aria-describedby="" required>
                            <div id="tituloError" class="d-none mt-2 p-1 alert alert-danger">Ingrese titulo.</div>
                        </div>
                        <div class="mb-3 ">
                            <label for="categoria" class="form-label">Categoria</label>
                            <input type="text" class="form-control form-control-sm" id="categoria" name="categoria"
                                aria-describedby="" required>
                            <div id="categoriaError" class="d-none mt-2 p-1 alert alert-danger">Ingrese categoria.</div>
                        </div>
                        <div class="mb-3 ">
                            <label for="categoria" class="form-label">Estado</label>
                            <select  class="form-select form-select-sm" name="estado" id="estado">
                                <option value="publica">Publica</option>
                                <option value="protegida">Protegida</option>
                            </select>
                        </div>
                        <div class="mb-3 ">
                            <label for="categoria" class="form-label">Derechos de uso</label>
                            <select  class="form-select form-select-sm" name="duso" id="duso">
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

    <?php require_once("script.php"); ?>
    <?php require_once("footer.php"); ?>
</body>

</html>
<?php  }else{header("location:login.php");}?>