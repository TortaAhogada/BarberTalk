<?php
include 'include/conecta.php';

// Validar que se cree una variable de sesión al pasar por el login

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $fechaCita = $_POST['fechaCita'];
    $horaCita = $_POST['horaCita'];
    $barberoSeleccionado = $_POST['barberoSeleccionado'];
    $servicioSeleccionado = $_POST['servicioSeleccionado'];
    $idCliente = $_POST['idcliente'];
    $status=null;

    $consulta="select s.ID_servicio  from servicio s where s.nombre ='$servicioSeleccionado'";
    $ejecuta= $conecta->query($consulta);
    $row=$ejecuta->fetch_assoc();
    $idServicio=$row['ID_servicio'];

    $consulta2="select p.ID_precio from precio p where p.ID_servicio ='$idServicio'";
    $ejecuta2= $conecta->query($consulta2);
    $row2=$ejecuta2->fetch_assoc();
    $precio=$row2['ID_precio'];

    $consulta3="select h.id from horarios h where h.Hora ='$horaCita'";
    $ejecuta3= $conecta->query($consulta3);
    $row3=$ejecuta3->fetch_assoc();
    $idHora=$row3['id'];

    $insertar="INSERT INTO `cita`(`ID_servicio`, `fecha_cita`, `ID_cliente`, `ID_trabajador`, `ID_precio`, `hora`) 
    VALUES ('$idServicio','$fechaCita','$idCliente','$barberoSeleccionado','$precio','$idHora')";
                $guardando=$conecta->query($insertar);
                if ($guardando > 0) {
                    echo("Guardado con exito");
                    header("location:Tabla_Usuario.php");
                }else{
                    echo("Hubo un error");
            }
}
?>



