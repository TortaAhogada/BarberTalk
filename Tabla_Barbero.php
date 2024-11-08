<?php
    //Recordar la variable de sesion
    session_start();
    include 'include/conecta.php';
    //Validar que se cree una variable de sesion al pasar por el login
    $usuario=$_SESSION['nickname'];
    if (!isset($usuario)) {
        header("location:Inicio2.php");
    }if (($_SESSION['tipo'])===null) {
        header("location:PerfilUsuario.php");
    }if ($_SESSION['tipo']) {
        header("location:PerfilDueño.php");
    }
    //Consulta
    $consulta="select ci.ID_cita, 
	(select c.nickname from cliente c where c.ID_cliente =ci.ID_cliente) as Nombre,
    (select c.correo  from cliente c where c.ID_cliente =ci.ID_cliente) as correo,
    (select s.nombre from servicio s where s.ID_servicio =ci.ID_servicio) as servicio,
    (select p.precio from precio p where p.ID_precio =ci.ID_precio) as costo,
    (select Hora  from horarios h where id = (ci.hora)) as horac,  
    ci.fecha_cita,
    ci.status,
    (select t.nickname  from trabajador t where t.ID_trabajador =ci.ID_trabajador) as Trabajador
    from cita ci
    where ci.ID_trabajador =(select t.ID_trabajador from trabajador t where t.nickname='$usuario')";

    $guardar=$conecta->query($consulta);

    if (isset($_POST['update'])) {
        $mensaje="";
        $status=$conecta->real_escape_string($_POST['opcion']);
        $id=$conecta->real_escape_string($_POST['id_cita']);
   
        //Consulta para insertar los datos
                $insertar="update cita set status ='$status' where ID_cita = '$id'";
                $guardando=$conecta->query($insertar);
               if ($guardando > 0) {
                   header("location:Tabla_Barbero.php");
                }else{
                    $mensaje.="Error en la consulta";
            }
       }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de citas</title>
    <link rel="stylesheet" href="Tabla_Dueño/Tabla_Dueño.css">
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
            <li><a href="PerfilDueño.php">Perfil</a></li>
            <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
            <li><a href="Informacion.html">Informacion</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    </header>
    


    <div class="Acomodo" style="position: absolute; left: 5%;">
    <div class="container">
        <div class="row">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo Electronico</th>
                <th>Servicio</th>
                <th>Costo</th>
                <th>Hora</th>
                <th>Fecha de la cita</th>
                <th>Barbero a cargo:</th>
                <th>Estado</th>
                <th>Configuracion de estado</th>
                <th></th>

            </tr>
        </thead>
        <tbody>
        <?php while($row=$guardar->fetch_assoc()){  ?>
            <tr>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                    <input type="hidden" name="id_cita" id="id_cita" value="<?php echo $row['ID_cita'] ?>">
                    <td><?php echo $row['Nombre'] ?></td>
                    <td><?php echo $row['correo'] ?></td>
                    <td><?php echo $row['servicio'] ?></td>
                    <td><?php echo $row['costo'] ?></td>
                    <td><?php echo $row['horac'] ?></td>
                    <td><?php echo $row['fecha_cita'] ?></td>
                    <td><?php echo $row['Trabajador'] ?></td>
                    <th><?php if ($row['status']) {
                                    echo 'Confirmada';
                                }elseif ($row['status']==null) {
                                    echo 'Sin revisar';
                                }else{
                                    echo 'Rechazada';
                                }
                                ?></th>
                    <th>
                        <select name="opcion">
                            <option value="1">Aceptar</option>
                            <option value="0">Rechazar</option>
                        </select> 
                    </th> 
                    <input type="hidden" name="nickname" id="nickname" value="<?php echo $row['Nombre'] ?>">
                    <td><input  class="boton" type="submit" value="Guardar cambios" name="update"></td>
                </form>
            </tr>
            <?php } ?>
        </tbody>
    </table>
   
    </div>
</div>
</div>
<br>
<br>
<br>




</body>
<script> 
    /* Initialization of datatables */ 
    $(document).ready(function () { 
        $('table.display').DataTable(); 
    }); 
</script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>