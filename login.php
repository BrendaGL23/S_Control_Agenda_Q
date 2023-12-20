<?php 
include_once '../backend/php/login.php'
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/principal.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.ico">
    <title>SISTEMA AGENDA</title>

</head>
<body>
<section class="vh-100">
  <div class="container-fluid h-custom">
      <div class="col-md-9 col-lg-5">
        <img src="../imagenes/login2.png"
          class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-7">
            <div class="main">
                <img src="../imagenes/aamates.png" width="60%" align="center" />
                <h3>Ingrese sus credenciales</h3>
                <?php 
                  if (isset($errMsg)) {
                    echo '
                  <div style="color:#FF0000;text-align:center;font-size:20px; font-weight:bold;">'.$errMsg.'</div>';  
                ;}
                ?>

                <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
                    <form method="POST" autocomplete="off" action="" id="formlg"> 
                        <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>"  placeholder="Usuario" required />
                        <input type="password" name="password" value="<?php if(isset($_POST['password'])) echo MD5($_POST['password']) ?>"  placeholder="Password" required />
                        <input type="submit" name='login' class="botonlog" value="Iniciar sesión">
                    </form>
            </div>
        </div>
    </div>
  </div>
</section>
    <br />
    <br />
    <script src="../js/jquery-3.7.1.min.js"></script>
</body>
</html>
