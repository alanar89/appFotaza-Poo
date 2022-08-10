<?php session_start();if (!isset($_SESSION['usuario'])){?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php require_once("head.php");?>
<script src="js/registro.js"></script>
</head>
<body class="estilo">
    <div class="container card  card mt-5  col-md-8">
        <div class="row">
        <div class="col-md-6 bg card border-bottom-0 border-top-0 border-end-0"> 
        </div> 
            <div class="col-md-6  p-5">
            <div class="text-primary text-center mt-3 mb-4 fs-5">
                <i class="fas fa-camera-retro"></i> Fotaza
            </div>
            <h2 class=" text-center  display-6 mb-3">Registro</h2>
                <form method="POST" name="formRegistro" action="registrar.php" enctype="multipart/form-data">
                <div class="mb-3 ">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control form-control-sm" id="nombre"name="nombre" aria-describedby="" required>
                        <div id="nombreError" class="d-none mt-2 p-1 alert alert-danger">Ingrese nombre.</div>
                    </div>
                    <div class="mb-3 ">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control form-control-sm" id="apellido" name="apellido" aria-describedby="" required>
                        <div id="apellidoError" class="d-none mt-2 p-1 alert alert-danger">Ingrese apellido.</div>
                    </div>
                    <div class="mb-3 ">
                        <label for="mail" class="form-label">Email</label>
                        <input type="email"  placeholder="nombre@ejemplo.com" class="form-control form-control-sm" id="mail" name="mail" aria-describedby="" required>
                        <div id="mailError" class="d-none mt-2 p-1 alert alert-danger">Ingrese un mail valido.</div>
                    </div>
                    <div class="mb-3">
                        <label for="pass" class="form-label">Contraseña</label>
                        <input type="password" class="form-control form-control-sm" id="pass"   name="pass" required>
                        <div id="passError" class="d-none mt-2 p-1 alert alert-danger">La contraseña no debe ser menor a 4 caracteres.</div>
                    </div>
                    <div class="mb-3 ">
                        <label for="tel" class="form-label">Telefono</label>
                        <input type="tel" class="form-control form-control-sm" id="tel" name="tel" aria-describedby="">
                    </div>
                    <div class="mb-3 ">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file"  name="foto" class="form-control form-control-sm" id="foto" aria-describedby="">
                    </div>
                    <?php if (isset($_GET['res'])) { echo "<div class='alert alert-danger p-1' role='alert' id='apwe'> El Email ya existe </div>";} ?> 
                    <button type="button" class="btn btn-primary col-12" onclick="validar()">registrarse</button>
                </form>
                <div  class="mt-4 mb-4">Ya tienes cuenta? <a href="login.php" class="">Ingresar</a></div>
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