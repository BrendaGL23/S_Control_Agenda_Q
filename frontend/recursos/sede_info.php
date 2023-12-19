<?php
    ob_start();
     session_start();
    
    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 1){
    header('location: ../login.php');

    $id=$_SESSION['id'];
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../backend/css/admin.css">
    <link rel="icon" type="image/png" sizes="96x96" href="../../backend/img/ico.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">

    <!-- CSS GOB -->
    <link href="/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">

    <!-- JS GOB -->
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>

    <title>Información de la enfermera(o)</title>
</head>
<body>
    <main class="page">
    <!-- SIDEBAR -->
    <section id="sidebar">
                <ul class="side-menu">
                    <li><a href="../admin/escritorio.php" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
                    <li>
                        <a href="#"><i class='bx bxs-book-alt icon' ></i> Citas <i class='bx bx-chevron-right icon-right' ></i></a>
                        <ul class="side-dropdown">
                            <li><a href="../citas/mostrar.php">Todas las citas</a></li>
                            <li><a href="../citas/nuevo.php">Nueva</a></li>
                            <li><a href="../citas/calendario.php">Calendario</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class='bx bxs-user icon' ></i> Pacientes <i class='bx bx-chevron-right icon-right' ></i></a>
                        <ul class="side-dropdown">
                            <li><a href="../pacientes/mostrar.php">Lista de pacientes</a></li>
                            <li><a href="../pacientes/historial.php">Historial de los pacientes</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class='bx bxs-briefcase icon' ></i> Médicos <i class='bx bx-chevron-right icon-right' ></i></a>
                        <ul class="side-dropdown">
                            <li><a href="../medicos/mostrar.php">Lista de médicos</a></li>
                            <li><a href="../medicos/historial.php">Historial de los médicos</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class='bx bxs-city icon' ></i> Instituciones<i class='bx bx-chevron-right icon-right' ></i></a>
                        <ul class="side-dropdown">
                            <li><a href="../recursos/sede.php"> Cedes</a></li>
                            <li><a href="../recursos/laboratiorios.php">Especialidades</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class='bx bxs-cog icon' ></i> Ajustes<i class='bx bx-chevron-right icon-right' ></i></a>
                        <ul class="side-dropdown">
                            <li><a href="../ajustes/mostrar.php">Ajustes</a></li>
                            <li><a href="../ajustes/base.php">Base de datos</a></li>

                        </ul>
                    </li>
                </ul>


    </section>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <section id="content">
        <!-- NAVBAR -->
        <nav id="denver">
            <i class='bx bx-menu toggle-sidebar' ></i>
            <form action="#">
            </form>
            
           
            <span class="divider"></span>
            <div class="profile">
                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
                <ul class="profile-link">
                    <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon' ></i> Perfil</a></li>
                    
                    <li>
                     <a href="../salir.php"><i class='bx bxs-log-out-circle' ></i> Cerrar sesión</a>
                    </li>
                   
                </ul>
            </div>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->

        <main>
    <h1 class="title">Bienvenido <?php echo '<strong>'.$_SESSION['username'].'</strong>'; ?></h1>
    <ul class="breadcrumbs">
        <li><a href="../admin/escritorio.php">Home</a></li>
        <li class="divider">></li>
        <li><a href="../recursos/sede.php">Listado de sedes</a></li>
        <li class="divider">></li>
        <li><a href="#" class="active">Información de la sede</a></li>
    </ul>

    <?php 
    require '../../backend/bd/Conexion.php';
    $id = $_GET['id'];
    $sentencia = $connect->prepare("SELECT * FROM sede WHERE idsede = '$id';");
    $sentencia->execute();

    $data =  array();
    if($sentencia){
        while($r = $sentencia->fetchObject()){
            $data[] = $r;
        }
    }
    ?>

    <?php if(count($data) > 0): ?>
        <?php foreach($data as $sede): ?>
            <form action="" enctype="multipart/form-data" method="POST" autocomplete="off" onsubmit="return validacion()">
                <div class="containerss">
                    <h1>Información de la sede</h1>

                    <hr>

                    <label for="num_emp"><b>Número de Empleado</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: 12345" value="<?php echo $sede->num_emp; ?>" readonly name="num_emp" maxlength="20" required>

                    <label for="nombre"><b>Nombre de la Sede</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Hospital XYZ" value="<?php echo $sede->nombre; ?>" readonly name="nombre" required>

                    <label for="direccion"><b>Dirección</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Calle Principal 123" value="<?php echo $sede->direccion; ?>" readonly name="direccion" required>

                    <label for="ciudad"><b>Ciudad</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Ciudad ABC" value="<?php echo $sede->ciudad; ?>" readonly name="ciudad" required>

                    <label for="estado"><b>Estado</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: Activo" value="<?php echo $sede->estado; ?>" readonly name="estado" required>

                    <label for="codigo_postal"><b>Código Postal</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: 12345" value="<?php echo $sede->codigo_postal; ?>" readonly name="codigo_postal" maxlength="20" required>

                    <!-- Agregar el campo correo -->
                    <label for="correo"><b>Correo</b></label><span class="badge-warning">*</span>
                    <input type="email" placeholder="ejm: correo@ejemplo.com" value="<?php echo $sede->correo; ?>" readonly name="correo" required>

                    <label for="telefono"><b>Teléfono</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: (123) 456-7890" value="<?php echo $sede->telefono; ?>" readonly name="telefono" maxlength="20" required>

                    <label for="estado_sede"><b>Estado de la Sede</b></label><span class="badge-warning">*</span>
                    <input type="text" placeholder="ejm: A" value="<?php echo $sede->estado_sede; ?>" readonly name="estado_sede" maxlength="1" required>

                    <hr>
                </div>
            </form>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="alert alert-warning">No hay datos</p>
    <?php endif; ?>
</main>

        <!-- MAIN -->
    </section>
    </main>

    <script src="../../backend/js/jquery.min.js"></script>


    <!-- NAVBAR -->
    
    <script src="../../backend/js/script.js"></script>
    <script src="../../backend/js/multistep.js"></script>
    <script src="../../backend/js/vpat.js"></script>
   
   
</body>
</html>


