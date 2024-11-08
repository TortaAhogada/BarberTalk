<?php
    //Recordar la variable de sesion
    session_start();
    include 'include/conecta.php';
    $usuario=$_SESSION['nickname'];
    //Validar que se cree una variable de sesion al pasar por el login
    if (!isset($usuario)) {
        header("location:Inicio2.php");
    }if (($_SESSION['tipo'])) {
        
        header("location:PerfilDueño.php");
    }else if (($_SESSION['tipo'])===false) {
        header("location:PerfilBarbero.php");
    }

    //Consulta
    $consulta="select (select s.nombre from servicio s where s.ID_servicio =ci.ID_servicio) as servicio,
    (select p.precio from precio p where p.ID_precio =ci.ID_precio) as costo,
    (select Hora  from horarios h where id = (ci.hora)) as horac, 
    ci.fecha_cita,
    ci.status,
    (select t.nickname  from trabajador t where t.ID_trabajador =ci.ID_trabajador) as Trabajador
    from cita ci
    where ci.ID_cliente  =(select c.ID_cliente from cliente c where c.nickname ='$usuario')";

    $guardar=$conecta->query($consulta)
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla</title>
    <link rel="stylesheet" href="Tabla_Usuario/Tabla_Usuario.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <script type="text/Javascript" src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script type="text/Javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

</head>
<body>
    <header>
        <h1>Barber Talk</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="PerfilUsuario.php">Perfil</a></li>
            <li><a href="Cita3.php">Agendar cita</a></li>
            <li><a href="PreguntasF.html">Preguntas Frecuentes</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    </header>



    <div class="Acomodo">
    <div class="container">
        <div class="row">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Costo</th>
                <th>Hora</th>
                <th>Fecha de la cita</th>
                <th>Barbero a cargo:</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row=$guardar->fetch_assoc()){  ?>
            <tr>
                <td><?php echo $row['servicio'] ?></td>
                <td><?php echo $row['costo'] ?></td>
                <td><?php echo $row['horac'] ?></td>
                <td><?php echo $row['fecha_cita'] ?></td>
                <td><?php echo $row['Trabajador'] ?></td>
                <th>
                    <?php if ($row['status']) {
                                echo 'Confirmada';
                            }elseif ($row['status']==null) {
                                echo 'Sin revisar';
                            }else{
                                echo 'Rechazada';
                            }
                    ?>
                </th>
            </tr>
            <?php } ?>
        </tbody>
    </table>
   
    </div>
</div>
</div>
  

</body>
<script> 
    /* Initialization of datatables */ 
    $(document).ready(function () { 
        $('table.display').DataTable(); 
    }); 
</script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>