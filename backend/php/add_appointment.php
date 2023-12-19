<?php
require_once('../../backend/bd/Conexion.php');

if (isset($_POST['add_appointment'])) {
    try {
        $title = trim($_POST['appnam']);
        $idpa = trim($_POST['apppac']);
        $idodc = trim($_POST['appdoc']);
        $idlab = trim($_POST['applab']);
        $color = trim($_POST['appco']);
        $start = $_POST['appini'];
        $end = $_POST['appfin'];
        $idsede = trim($_POST['appidsede']); // Asegúrate de obtener el valor correcto del formulario

        // Validar y sanitizar datos según sea necesario

        $sql = "INSERT INTO events (title, idpa, idodc, idlab, color, start, end, state, monto, chec, idsede) 
                VALUES (:title, :idpa, :idodc, :idlab, :color, :start, :end, 1, '0', '', :idsede)";

        $stmt = $connect->prepare($sql);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':idpa', $idpa);
        $stmt->bindParam(':idodc', $idodc);
        $stmt->bindParam(':idlab', $idlab);
        $stmt->bindParam(':color', $color);
        $stmt->bindParam(':start', $start);
        $stmt->bindParam(':end', $end);
        $stmt->bindParam(':idsede', $idsede);

        $stmt->execute();

        $lastInsertId = $connect->lastInsertId();

        if ($lastInsertId > 0) {
            echo '<script type="text/javascript">
                    swal("¡Registrado!", "Se reservó la cita correctamente", "success").then(function() {
                        window.location = "../citas/calendario.php";
                    });
                </script>';
        } else {
            echo '<script type="text/javascript">
                    swal("Error!", "No se pueden agregar datos, comuníquese con el administrador", "error").then(function() {
                        window.location = "nuevo.php";
                    });
                </script>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>