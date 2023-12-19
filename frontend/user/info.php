<?php
    ob_start();
     session_start();
    
    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 2){
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

    <title>Información de la cita</title>
</head>
<body>

<main class="page">
    <!-- SIDEBAR -->
    <section id="sidebar">
        <ul class="side-menu">
            <li><a href="user.php" class="active"><i class='bx bxs-dashboard icon' ></i> Perfil de Usuario</a></li>
            <li>
                <a href="#"><i class='bx bxs-book-alt icon' ></i> Citas <i class='bx bx-chevron-right icon-right' ></i></a>
                <ul class="side-dropdown">
                    <li><a href="citas.php">Todas las citas</a></li>
                    <li><a href="nuevo.php">Nueva</a></li>
                    <li><a href="calendario.php">Calendario</a></li>
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
                <li><a href="user.php">Home</a></li>
                <li class="divider">></li>
                <li><a href="citas.php">Listado de las citas</a></li>
                <li class="divider">></li>
                <li><a href="#" class="active">Información de la cita</a></li>
            </ul>
           
           <!-- multistep form -->
<?php 
require '../../backend/bd/Conexion.php';
 $id = $_GET['id'];
 $sentencia = $connect->prepare("SELECT events.id, events.title, patients.idpa, patients.numhs,patients.nompa, patients.apepa, doctor.idodc, doctor.ceddoc, doctor.nodoc,doctor.nomesp, doctor.apdoc, laboratory.idlab, laboratory.nomlab, events.start, events.end, events.color, events.state,events.chec,events.monto FROM events INNER JOIN patients ON events.idpa = patients.idpa INNER JOIN doctor ON events.idodc = doctor.idodc INNER JOIN laboratory ON events.idlab = laboratory.idlab WHERE id= '$id';");
 $sentencia->execute();

$data =  array();
if($sentencia){
  while($r = $sentencia->fetchObject()){
    $data[] = $r;
  }
}
   ?>
   <?php if(count($data)>0):?>
        <?php foreach($data as $d):?> 
<form action="" enctype="multipart/form-data" method="POST"  autocomplete="off">
  <div class="containerss">

<br>
    <label for="email"><b>Motivo de la cita</b></label><span class="badge-warning">*</span>
    <textarea name="appnam" style="height:200px" readonly placeholder="Write something.."><?php echo $d->title; ?> </textarea>
  
    <label for="psw"><b>Nombre del paciente</b></label><span class="badge-warning">*</span>
    <select readonly required name="apppac" id="pati">
        <option><?php echo $d->nompa; ?>&nbsp; <?php echo $d->apepa; ?></option>
    </select>

    <label for="psw"><b>Nombre del médico</b></label><span class="badge-warning">*</span>
    <select readonly required name="" id="doc">
        <option><?php echo $d->nodoc; ?>&nbsp; <?php echo $d->apdoc; ?></option>
    </select>

    <label for="email"><b>Especialidad del médico</b></label><span class="badge-warning">*</span>

     <select readonly id="spe">
        <option><?php echo $d->nomesp; ?></option>
    </select>


    <label for="psw"><b>Laboratorio</b></label><span class="badge-warning">*</span>
    <select required name="" id="lab" readonly>
        <option><?php echo $d->nomlab; ?></option>
    </select>

    <label for="psw"><b>Color</b></label><span class="badge-warning">*</span>
    <select required name="appco" id="gep">
        <option style="color:#CD5C5C;" value="#CD5C5C"><?php echo $d->color; ?></option>
        
        
          
    </select>

    <label for="email"><b>Fecha inicial</b></label><span class="badge-warning">*</span>
    <input readonly type="datetime-local" value="<?php echo $d->start; ?>" name="appini"required="">

    <label for="email"><b>Fecha final</b></label><span class="badge-warning">*</span>
    <input readonly type="datetime-local" value="<?php echo $d->end; ?>"  name="appfin"required="">


    <hr>
   
    
  </div>
  
</form>
<?php endforeach; ?>
  
    <?php else:?>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  
   
</body>
</html>


