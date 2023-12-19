<?php
    ob_start();
     session_start();
    
    if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 2){
    header('location: ../login.php');

    $id=$_SESSION['id'];
  }
?>
    <?php 
    require_once('../../backend/bd/Conexion.php');
      $req = $connect->prepare("SELECT id, title, start, end, color FROM events");
      $req->execute();
      $events = $req->fetchAll();
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

    <title>Panel administrativo</title>
</head>
<body>
    
<!-- Contenido -->
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
                <li class="divider">/</li>
                <li><a href="#" class="active">Perfil de Usuario</a></li>
            </ul>
            <div class="info-data">
                <div class="card">
                    <div class="head">
                        <div>
                           
                                    <?php 
                                            $sql = "SELECT COUNT(*) total FROM doctor";
                                            $result = $connect->query($sql); //$pdo sería el objeto conexión
                                            $total = $result->fetchColumn();

                                             ?>
                            <h2><?php echo  $total; ?></h2>
                            <p>Sus Medicos </p>
                        </div>
                        <i class='bx bx-briefcase icon' ></i>
                    </div>
                 
                </div>
            </div>
            <div class="data">
                <div class="content-data">
                    <div class="table-responsive" style="overflow-x:auto;">
 <?php 

$sentencia = $connect->prepare("SELECT * FROM doctor ORDER BY idodc DESC LIMIT 10;");
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
                    <th scope="col">Su médico</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $d):?>
                    <tr>
                    
                        <td data-title="Paciente"><?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?></td>
                        <td data-title="Especialidad"><?php echo $d->nomesp ?></td>
                      
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
            $sentencia = $connect->prepare("SELECT events.id, events.title, patients.idpa, patients.numhs, patients.nompa, patients.apepa, doctor.idodc, doctor.ceddoc, doctor.nodoc, doctor.apdoc, laboratory.idlab, laboratory.nomlab, events.start, events.end, events.color, events.state,events.chec,events.monto FROM events INNER JOIN patients ON events.idpa = patients.idpa INNER JOIN doctor ON events.idodc = doctor.idodc INNER JOIN laboratory ON events.idlab = laboratory.idlab WHERE patients.idpa  = :idUsuario ORDER BY events.id DESC;");
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
                            <th scope="col">Fecha inicio</th>
                            <th scope="col">Fecha fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $d): ?>
                            <tr>
                                <th scope="row"><?php echo $d->nompa ?>&nbsp;<?php echo $d->apepa ?></th>
                                <td data-title="Cita"><?php echo $d->title ?></td>
                                <td data-title="Médico"><?php echo $d->nodoc ?>&nbsp;<?php echo $d->apdoc ?></td>
                                <td data-title="Laboratorio"><?php echo $d->nomlab ?></td>
                                <td data-title="Fecha inicio"><?php echo $d->start ?></td>
                                <td data-title="Fecha fin"><?php echo $d->end ?></td>
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
    </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- NAVBAR -->

      
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="../../backend/js/script.js"></script>

    <!-- Data Tables -->
        <script src="../../backend/vendor/datatables/dataTables.min.js"></script>
        <script src="../../backend/vendor/datatables/dataTables.bootstrap.min.js"></script>


        <!-- Custom Data tables -->
        <script src="../../backend/vendor/datatables/custom/custom-datatables.js"></script>
        <script src="../../backend/vendor/datatables/custom/fixedHeader.js"></script>


        <!-- FullCalendar -->
    <script src='../../backend/js/moment.min.js'></script>
    <script src='../../backend/js/fullcalendar/fullcalendar.min.js'></script>
    <script src='../../backend/js/fullcalendar/fullcalendar.js'></script>
    <script src='../../backend/js/fullcalendar/locale/es.js'></script>

<script>

  $(document).ready(function() {

    var date = new Date();
       var yyyy = date.getFullYear().toString();
       var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
       var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();
    
    $('#calendar').fullCalendar({
      header: {
         language: 'es',
        left: 'prev,next today',
        center: 'title',
        right: 'month,basicWeek,basicDay',

      },
      defaultDate: yyyy+"-"+mm+"-"+dd,
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      selectable: true,
      selectHelper: true,
      select: function(start, end) {
        
        $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
        $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
        $('#ModalAdd').modal('show');
      },
      eventRender: function(event, element) {
        element.bind('dblclick', function() {
          $('#ModalEdit #id').val(event.id);
          $('#ModalEdit #title').val(event.title);
          $('#ModalEdit #color').val(event.color);
          $('#ModalEdit').modal('show');
        });
      },
      eventDrop: function(event, delta, revertFunc) { // si changement de position

        edit(event);

      },
      eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

        edit(event);

      },
      events: [
      <?php foreach($events as $event): 
      
        $start = explode(" ", $event['start']);
        $end = explode(" ", $event['end']);
        if($start[1] == '00:00:00'){
          $start = $start[0];
        }else{
          $start = $event['start'];
        }
        if($end[1] == '00:00:00'){
          $end = $end[0];
        }else{
          $end = $event['end'];
        }
      ?>
        {
          id: '<?php echo $event['id']; ?>',
          title: '<?php echo $event['title']; ?>',
          start: '<?php echo $start; ?>',
          end: '<?php echo $end; ?>',
          color: '<?php echo $event['color']; ?>',
        },
      <?php endforeach; ?>
      ]
    });
    
 
    
  });

</script>
</body>
</html>