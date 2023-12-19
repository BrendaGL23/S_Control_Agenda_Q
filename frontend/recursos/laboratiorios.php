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

    <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="../../backend/css/datatable.css">
    <link rel="stylesheet" type="text/css" href="../../backend/css/buttonsdataTables.css">
    <link rel="stylesheet" type="text/css" href="../../backend/css/font.css">

    <!-- CSS GOB -->
    <link href="/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">

    <!-- JS GOB -->
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>


    <title>Listado de laboratorios</title>
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
                <li><a href="#" class="active">Listado de los laboratorios</a></li>
            </ul>
            <button class="button" onclick="location.href='laboratorios_nuevo.php'">Nuevo</button>
          <div class="data">
                <div class="content-data">
                    <div class="head">
                        <h3>Laboratorios</h3>
                      

                    </div>
                   <div class="table-responsive" style="overflow-x:auto;">
                       <?php 
require '../../backend/bd/Conexion.php';
$sentencia = $connect->prepare("SELECT * FROM laboratory ORDER BY idlab DESC;");
 $sentencia->execute();
$data =  array();
if($sentencia){
  while($r = $sentencia->fetchObject()){
    $data[] = $r;
  }
}
     ?>
     <?php if(count($data)>0):?>
         <table id="example" class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Laboratorio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $d):?>
                    <tr>
                        <th scope="row"><?php echo $d->nomlab ?></th>
                        
                        <td data-title="Estado">
    
                        <label class="switch">
                          <input type="checkbox" id="<?=$d->idlab?>" value="<?=$d->state ?>" <?=$d->state == '1' ? 'checked' : '' ;?>/> 

                          <span class="slider"></span>
                        </label>
                        </td>
                        <td>
                        <div class="icon-container">
                            <a title="Actualizar" href="../recursos/laboratorios_editar.php?id=<?php echo $d->idlab ?>" class="fa fa-pencil"></a>
                            <a title="Información" href="../recursos/laboratorios_info.php?id=<?php echo $d->idlab ?>" class="fa fa-info"></a>
                            <form  onsubmit="return confirm('Realmente desea eliminar el registro?');" method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
<input type='hidden' name='idlab' value="<?php echo  $d->idlab; ?>">

<button name='delete_laboratory' style="cursor: pointer;" class="fa fa-trash"></button>
</form>

        
</div>                        
</td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
         </table> 
         <?php else:?>
  
    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
      <strong>Danger!</strong> No hay datos.
    </div>
    <?php endif; ?>
                    </div>
                </div>
            </div>  

        </main>
        <!-- MAIN -->
    </section>
    </main>

    <!-- NAVBAR -->
    <script src="../../backend/js/jquery.min.js"></script>
    
    <script src="../../backend/js/script.js"></script>
    
    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>
    <script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
    }
    } );
} );
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
 <?php include_once '../../backend/php/delete_laboratory.php' ?>
</body>
</html>


