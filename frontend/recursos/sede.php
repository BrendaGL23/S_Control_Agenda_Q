<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
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


    <title>Listado de Cedes</title>
</head>
<body>

    <!-- Contenido -->
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
                        <div class="form-group">
                        </div>
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
                    <h1 class="title">Bienvenido <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?></h1>
                    <ul class="breadcrumbs">
                        <li><a href="../admin/escritorio.php">Home</a></li>
                        <li class="divider">></li>
                        <li><a href="#" class="active">Listado de sedes</a></li>
                    </ul>
                    <button class="button" onclick="location.href='sede_nuevo.php'">Nuevo</button>
                    <div class="data">
    <div class="content-data">
        <div class="head">
            <h3>Sedes</h3>
        </div>
        <div class="data">
    <div class="content-data">
        <div class="head">
            <h3>Lista de sedes</h3>
        </div>
        <div class="table-responsive" style="overflow-x:auto;">
    <?php
    require '../../backend/bd/Conexion.php';
    $sentencia = $connect->prepare("SELECT * FROM sede ORDER BY idsede DESC;");
    $sentencia->execute();
    $sedes = $sentencia->fetchAll(PDO::FETCH_OBJ);
    ?>
    <?php if (count($sedes) > 0): ?>
        <table id="example" class="responsive-table">
            <thead>
                <tr>
                    <th scope="col">Número de empresa</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Código Postal</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">A/I</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sedes as $sede): ?>
                    <tr>
                        <td data-title="Número de Empleado"><?php echo $sede->num_emp ?></td>
                        <td data-title="Nombre"><?php echo $sede->nombre ?></td>
                        <td data-title="Dirección"><?php echo $sede->direccion ?></td>
                        <td data-title="Estado"><?php echo $sede->estado ?></td>
                        <td data-title="Código Postal"><?php echo $sede->codigo_postal ?></td>
                        <td data-title="Correo"><?php echo $sede->correo ?></td>
                        <td data-title="Teléfono"><?php echo $sede->telefono ?></td>
                        <td data-title="Estado de Sede">
                            <label class="switch">
                                <input type="checkbox" id="<?= $sede->idsede ?>" value="<?= $sede->estado_sede ?>" <?= $sede->estado_sede == 'A' ? 'checked' : ''; ?>/> 
                                <span class="slider"></span>
                            </label>
                        </td>
                        <td>
    <!-- Contenedor para los iconos -->
    <div class="icon-container">
        <!-- Enlace para actualizar -->
        <a title="Actualizar" href="../recursos/sede_editar.php?id=<?php echo $sede->idsede ?>" class="fa fa-pencil"></a>

        <!-- Enlace para obtener información detallada -->
        <a title="Información" href="../recursos/sede_info.php?id=<?php echo $sede->idsede ?>" class="fa fa-info"></a>

        <!-- Formulario para eliminar el registro -->
        <form onsubmit="return confirm('¿Realmente desea eliminar el registro?');" method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
            <input type='hidden' name='idsede' value="<?php echo $sede->idsede; ?>">
            <button type="submit" name='delete_sedes' style="cursor: pointer;" class="fa fa-trash"></button>
        </form>
    </div>
</td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    <?php else: ?>
        <div class="alert">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
            <strong>Advertencia:</strong> No hay datos.
        </div>
    <?php endif; ?>
</div>

    </div>
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

 <script type="text/javascript">
    let popUp = document.getElementById("cookiePopup");
//When user clicks the accept button
document.getElementById("acceptCookie").addEventListener("click", () => {
  //Create date object
  let d = new Date();
  //Increment the current time by 1 minute (cookie will expire after 1 minute)
  d.setMinutes(2 + d.getMinutes());
  //Create Cookie withname = myCookieName, value = thisIsMyCookie and expiry time=1 minute
  document.cookie = "myCookieName=thisIsMyCookie; expires = " + d + ";";
  //Hide the popup
  popUp.classList.add("hide");
  popUp.classList.remove("shows");
});
//Check if cookie is already present
const checkCookie = () => {
  //Read the cookie and split on "="
  let input = document.cookie.split("=");
  //Check for our cookie
  if (input[0] == "myCookieName") {
    //Hide the popup
    popUp.classList.add("hide");
    popUp.classList.remove("shows");
  } else {
    //Show the popup
    popUp.classList.add("shows");
    popUp.classList.remove("hide");
  }
};
//Check if cookie exists when page loads
window.onload = () => {
  setTimeout(() => {
    checkCookie();
  }, 2000);
};
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
 <?php include_once '../../backend/php/delete_sede.php' ?>
</body>
</html>


