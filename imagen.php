<?php session_start();if (isset($_SESSION['usuario'])){?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php require_once("head.php");?>
<script src="js/imagen.js"></script>
</head>
<body>
    <div class="container">
        <div class="row  justify-content-center  mt-5">
            <div class="col-md-6 ">
            <h2 class=" text-center">Publicar Imagen</h2>
                <form method="POST" name="formPublicar" action="publicarImagen.php" enctype="multipart/form-data">
                <div class="mb-3 ">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file"  name="imagen" class="form-control" id="imagen" aria-describedby="">
                    </div>
                <div class="mb-3 ">
                        <label for="titulo" class="form-label">Titulo</label>
                        <input type="text" class="form-control" id="titulo"name="titulo" aria-describedby="" required>
                        <div id="tituloError" class="d-none mt-2 p-1 alert alert-danger">Ingrese titulo.</div>
                    </div>
                    <div class="mb-3 ">
                        <label for="categoria" class="form-label">Categoria</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" aria-describedby="" required>
                        <div id="categoriaError" class="d-none mt-2 p-1 alert alert-danger">Ingrese categoria.</div>
                    </div>
                    <div class="mb-3 ">
                    <label for="categoria" class="form-label">Estado</label>
                       <select class="form-control" name="estado" id="estado">
                       <option value="publica">Publica</option>
                       <option value="privada">Privada</option>
                       </select>
                    </div>
                    <div class="mb-3 ">
                    <label for="categoria" class="form-label">Derechos de uso</label>
                       <select class="form-control" name="duso" id="duso">
                       <option value="copyleft">copyleft</option>
                       <option value="copyrigth">copyrigth</option>
                       </select>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Etiquetas</label>
                        <input type="text" class="form-control" id="et1"   name="et1">
                        <input type="text" class="form-control mt-2" id="et2"   name="et2">
                        <input type="text" class="form-control mt-2" id="2t3"   name="et3">
                    </div>
                    <button type="submit" class="btn btn-primary col-12">publicar</button>
                </form>
            </div>
        </div>
    </div>
   <?php require_once("script.php");?>
</body>
</html>
<?php  }else{header("location:login.php");}?>