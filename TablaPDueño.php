<?php
    error_reporting(0);
//Recordar la variable de sesion
session_start();
include 'include/conecta.php';
//Validar que se cree una variable de sesion al pasar por el login
$usuario=$_SESSION['nickname'];
if (!isset($usuario)) {
    header("location:InicioTrabajador.php");
}if (($_SESSION['tipo'])==null) {
    header("location:PerfilUsuario.php");
}if (($_SESSION['tipo'])==false) {
    header("location:PerfilBarbero.php");
}
//Consulta
$consulta="select t.ID_trabajador, 
t.status,
t.nickname,
(select count(c.ID_cita)  from cita c where c.status =1 and c.ID_trabajador =t.ID_trabajador) as aceptadas,
(select count(c.ID_cita)  from cita c where c.status =0 and c.ID_trabajador =t.ID_trabajador) as rechazadas,
(select count(c.ID_cita)  from cita c where c.status is null and c.ID_trabajador =t.ID_trabajador) as pendientes,
(select count(c.ID_cita)  from cita c where c.ID_trabajador =t.ID_trabajador) as total
from trabajador t where t.tipo =0";

$guardar=$conecta->query($consulta);

 if (isset($_POST['update'])) {
     $mensaje="";
     $status=$conecta->real_escape_string($_POST['opcion']);
     $id=$conecta->real_escape_string($_POST['id_trabajador']);

     //Consulta para insertar los datos
             $insertar="update trabajador set status ='$status' where ID_trabajador = '$id'";
             $guardando=$conecta->query($insertar);
            if ($guardando > 0) {
                header("location:TablaPDueño.php");
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
            <li><a href="PerfilDueño.php">Perfil</a></li>
            <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
            <li><a href="Informacion.html">Informacion</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    </header>




    <div class="Acomodo" style="width: 70%; left: 17%; ">
    <div class="container">
        <div class="row">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Barbero</th>
                <th>Citas Realizadas</th>
                <th>Citas Canceladas</th>
                <th>Citas pendientes por revisar</th>
                <th>Total</th>
                <th>Estado Barbero</th>
                <th>Configuración de estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php while($row=$guardar->fetch_assoc()){  ?>
            <tr>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                    <input type="hidden" name="id_trabajador" id="id_trabajador" value="<?php echo $row['ID_trabajador'] ?>">
                    <td><?php echo $row['nickname'] ?></td>
                    <td><?php echo $row['aceptadas'] ?></td>
                    <td><?php echo $row['rechazadas'] ?></td>
                    <td><?php echo $row['pendientes'] ?></td>
                    <td><?php echo $row['total'] ?></td>
                    <th><?php if ($row['status']) {
                                    echo 'Activo';
                                }else{
                                    echo 'Inactivo';
                                }
                                ?></th>
                    <th>
                        <select name="opcion">
                            <option value="1">Activar</option>
                            <option value="0">Desactivar</option>
                        </select> 
                    </th> 
                    <td><input  class="boton" type="submit" value="Guardar cambios" name="update"></td>
                </form>

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