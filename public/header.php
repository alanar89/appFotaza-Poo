<nav class="navbar navbar-expand-lg navbar-dark bg-primary text-uppercase">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <div class="d-inline-block align-text-top ms-5">
                <i class="fas fa-camera-retro "></i> Fotaza
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <?php if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if(isset($_SESSION['usuario'])){?>
      <div class="mb-2 col-md-6">
                <form method="POST" id="formbuscar" name="formbuscar" action="<?php echo $helper->url("Inicio","buscar"); ?>" enctype="">
                    <div class="input-group mt-3 col-md-2">
                        <input type="text" class="form-control form-control-sm"  name="buscar" placeholder="buscar imagen"
                            aria-label="" aria-describedby="basic-addon2" required>
                        <button class="btn btn-success text-light btn-sm"  name="btn-buscar"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
    <ul class="navbar-nav mb-3 mb-lg-0 ms-5 me-5">
    <li class="nav-item">
                    <a class="nav-link mt-2 me-2 text-light"  href="<?php echo $helper->url("Publicacion","publicaciones"); ?>">Publicaciones</a>
                </li>
        <li class="nav-item dropdown d-none d-md-block">
        <a class="nav-link dropdown-toggle" href="#" id="menuPerfil" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="<?php echo'public/img/'.$_SESSION['foto']?>" alt="" width="40" height="40" class="foto">
                               <span class="text-light m-1"><?php echo $_SESSION['nya'];?></span>
                            </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <li><a class="dropdown-item" href="<?php echo $helper->url("Usuario","perfil"); ?>">Perfil</a></li>
                                <li><a class="dropdown-item"  href="<?php echo $helper->url("Usuario","salir"); ?>">Salir</a></li>
          </ul>
        </li>
        <li class="nav-item d-md-none">
                    <a class="nav-link mt-2 text-light" href="<?php echo $helper->url("Usuario","perfil"); ?>">Perfil</a>
                </li>
                <li class="nav-item d-md-none">
                <a class="nav-link mt-2 text-light"  href="<?php echo $helper->url("Usuario","salir"); ?>">Salir</a>
                </li>
      </ul>
           
        </div>
        <?php }else{?>
            <div class="mb-2 col-md-6 me-md-5">
                <form method="POST" id="formbuscar" name="formbuscar" action="<?php echo $helper->url("Inicio","buscar"); ?>" enctype="">
                    <div class="input-group mt-3 col-md-2">
                        <input type="text" class="form-control form-control-sm" name="buscar" placeholder="buscar imagen"
                            aria-label="" aria-describedby="basic-addon2" required>
                        <button class="btn btn-success text-light btn-sm" name="btn-buscar"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        <ul class="navbar-nav mb-2 mb-lg-0 me-5">
            <li class="nav-item">
                <a class="nav-link text-light ms-md-5 me-2"  href="<?php echo $helper->url("Usuario","login"); ?>" tabindex="-1" aria-disabled="false">Ingresar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light"  href="<?php echo $helper->url("Usuario","registro"); ?>" tabindex="-1" aria-disabled="false">Registrarse</a>
            </li>
        </ul>
    </div>
    <?php }?>
    </div>
</nav>