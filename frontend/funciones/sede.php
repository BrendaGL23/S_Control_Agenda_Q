 <?php 
 require '../../backend/bd/Conexion.php';
 echo '<option value="0">Seleccione</option>';
 $stmt = $connect->prepare('SELECT * FROM `sede` ORDER BY idsede   ASC');

  $stmt->execute();


  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            ?>
            <option value="<?php echo $idsede; ?>"><?php echo $nombre; ?></option>

            <?php
        }

  ?>


