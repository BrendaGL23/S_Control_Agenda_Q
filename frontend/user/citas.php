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

    <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="../../backend/css/datatable.css">
    <link rel="stylesheet" type="text/css" href="../../backend/css/buttonsdataTables.css">
    <link rel="stylesheet" type="text/css" href="../../backend/css/font.css">

    <!-- CSS GOB -->
    <link href="/favicon.ico" rel="shortcut icon">
    <link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">

    <!-- JS GOB -->
    <script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>

    <title>Listado de las citas</title>
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
                <li><a href="#" class="active">Listado de las citas</a></li>
            </ul>
          <div class="data">
          <div class="content-data">
        <div class="table-responsive">
            <h3>Citas</h3>
        </div>
        <div class="table-responsive" style="overflow-x:auto;">
        <?php
        require_once '../../backend/bd/Conexion.php';

        // Obtener el ID del usuario desde la sesión
        $idUsuario = isset($_SESSION['id']) ? $_SESSION['id'] : null;

        try {
            $sentencia = $connect->prepare("SELECT events.id, events.title, patients.idpa, patients.numhs, patients.nompa, patients.apepa, doctor.idodc, doctor.ceddoc, doctor.nodoc, doctor.apdoc, laboratory.idlab, laboratory.nomlab, events.start, events.end, events.color, events.state,events.chec,events.monto, sede.idsede,  -- Agregada la columna idsede de la tabla sede
            sede.nombre FROM events INNER JOIN patients ON events.idpa = patients.idpa INNER JOIN doctor ON events.idodc = doctor.idodc INNER JOIN laboratory ON events.idlab = laboratory.idlab INNER JOIN sede ON events.idsede = sede.idsede WHERE patients.idpa  = :idUsuario ORDER BY events.id DESC;");
            $sentencia->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $sentencia->execute();
            $data = $sentencia->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
            <?php if (count($data) > 0): ?>
                <table id="example" class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Pacientes</th>
                    <th scope="col">Motivo</th>
                    <th scope="col">Médico</th>
                    <th scope="col">Laboratorio</th>
                    <th scope="col">Sede</th>
                    <th scope="col">Fecha inicio</th>
                    <th scope="col">Fecha fin</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $d):?>
                    <tr>
                        <th scope="row"><?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?></th>
                        <td data-title="Cita"><?php echo $d->title ?></td>
                        <td data-title="Médico"><?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?></td>
                        <td data-title="Laboratorio"><?php echo $d->nomlab ?></td>
                        <td data-title="Sede"><?php echo $d->nombre ?></td>
                        <td data-title="Fecha inicio"><?php echo $d->start ?></td>
                        <td data-title="Fecha fin"><?php echo $d->end ?></td>
                        <td>
                        <div class="icon-container">
                <a title="Información" href="info.php?id=<?php echo $d->id ?>" class="fa fa-info"></a>
                <!-- Añade la librería de SweetAlert y jQuery si no lo has hecho -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Modifica el formulario -->
<form id="deleteAppointmentForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="id_event" value="<?php echo $d->id; ?>">
    <button type="button" onclick="deleteEvent('<?php echo $d->id; ?>')" style="cursor: pointer;" class="fa fa-trash"></button>
</form>

<script>
    function deleteEvent(idEvent) {
        if (confirm('¿Realmente desea eliminar la cita?')) {
            $.ajax({
                type: 'POST',
                url: 'delete_cita.php', // Reemplaza 'tu_archivo_php.php' con la ruta correcta
                data: { delete_appointment: true, id_event: idEvent },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Éxito en la eliminación, muestra el mensaje de SweetAlert
                        swal({
                            icon: "success",
                            title: "Eliminado",
                            text: response.message
                        }).then(function() {
                            // Elimina el elemento del DOM sin recargar la página
                            $("#cita_" + idEvent).remove();

                            // Redirige a la página especificada
                            window.location.href = response.redirect;
                        });
                    } else {
                        // Error al eliminar, muestra el mensaje de error de SweetAlert
                        swal({
                            icon: "error",
                            title: "Error",
                            text: response.message
                        });
                    }
                },
                error: function () {
                    // Error de comunicación con el servidor, muestra el mensaje de error de SweetAlert
                    swal({
                        icon: "error",
                        title: "Error",
                        text: "Error de comunicación con el servidor."
                    });
                }
            });
        }
    }
</script>


            </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
         </table> 
            <?php else: ?>
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
    <?php include_once 'delete_cita.php' ?>
    <script src="../../backend/js/script.js"></script>

    <!-- Script para manejar la eliminación con AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
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
 
</body>
</html>