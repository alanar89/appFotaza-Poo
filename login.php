<?php if (!isset($_SESSION['usuario'])){?>
 <!DOCTYPE html>
<html lang="es">
<head>
<?php require_once("head.php");?>
<script src="js/login.js"></script>
</head>
<body class="estilo">
<?php if (isset($_SESSION['exito'])){?>
<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
  <strong>Registro exitoso!</strong> Inicia sesión para continuar.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php }?>
    <div class="container card mt-5  col-md-8">
        <div class="row">
     <div class="col-md-6 bg card border-bottom-0 border-top-0 border-end-0"> 
        </div> 
            <div class="col-md-6 p-5">
            <div class="text-primary text-center mt-3 mb-4 fs-5">
                <i class="fas fa-camera-retro"></i> Fotaza
            </div>
                <h2 class=" text-center display-6 mb-3">Bienvenido</h2>
                <form method="POST" id="formLogin"  name="formLogin" action="iniciarSesion.php" enctype="">
                    <div class="mb-3 ">
                        <label for="mail" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" name="mail"  placeholder="nombre@ejemplo.com" id="mail" aria-describedby="emailHelp" required>
                        <div id="mailError" class="d-none mt-2 p-1 alert alert-danger">Ingrese un mail valido.</div>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control form-control-sm" placeholder=""  name="pass" id="pass" required>
                        <div id="passError" class="d-none mt-2 p-1 alert alert-danger">La contraseña no debe ser menor a 4 caracteres.</div>
                    </div>
                    <!-- <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">recordar</label>
                    </div> -->
                    <?php if (isset($_GET['res'])) { echo "<div class='alert alert-danger p-1' role='alert' id='apwe'> Email o contraseña incorrecto </div>";} ?> 
                    <button id="login" type="button" onclick="validar()"  class="btn btn-primary col-12">Iniciar Sesión</button>
                </form>
                <div class="mt-4 mb-4">No tienes cuenta? <a href="registro.php" class="">Registrarse</a></div>
            </div>
        </div>
    </div>
    <footer>
        <p class=" text-center mt-2">Pamela Varas &copy; 2021</p>
    </footer>
   <?php require_once("script.php");?>
</body>
</html>
<?php  }else{header("location:index.php");}?>