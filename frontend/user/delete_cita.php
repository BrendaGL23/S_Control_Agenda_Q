<?php
require_once('../../backend/bd/Conexion.php');

if (isset($_POST['delete_appointment'])) {
    try {
        $id_event = trim($_POST['id_event']);

        // Eliminar de la tabla events
        $consulta = "DELETE FROM `events` WHERE `id` = :id_event";
        $sql = $connect->prepare($consulta);
        $sql->bindParam(':id_event', $id_event, PDO::PARAM_INT);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            // Éxito en la eliminación
            echo json_encode(['success' => true, 'message' => 'Cita eliminada correctamente', 'redirect' => 'citas.php']);
        } else {
            // No se eliminó ningún registro
            echo json_encode(['success' => false, 'message' => 'No se pudo eliminar la cita', 'redirect' => 'nuevo.php']);
        }
    } catch (PDOException $e) {
        // Error en la eliminación
        echo json_encode(['success' => false, 'message' => 'Error al eliminar la cita: ' . $e->getMessage()]);
    }
}
?>



 

