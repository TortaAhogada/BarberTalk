<?php
    //Recordar la variable de sesion
    session_start();
    include 'include/conecta.php';
    //Validar que se cree una variable de sesion al pasar por el login
    $usuario=$_SESSION['nickname'];
    if (!isset($usuario)) {
        header("location:Inicio2.php");
    }if (($_SESSION['tipo'])) {
        
        header("location:PerfilDueño.php");
    }else if (($_SESSION['tipo'])===false) {
        header("location:PerfilBarbero.php");
    }
    
    $consulta="select c.correo, c.num_telefono from cliente c where c.nickname ='$usuario'";
    $ejecuta= $conecta->query($consulta);
    $row=$ejecuta->fetch_assoc();


    $consulta="select count(ci.ID_cita) as Total,
    (select count(ci.ID_cita) from cita ci where ci.status =false and ci.ID_cliente = (select c.ID_cliente from cliente c where c.nickname ='$usuario')) as Rechazadas,
    (select count(ci.ID_cita) from cita ci where ci.status =true and ci.ID_cliente = (select c.ID_cliente from cliente c where c.nickname ='$usuario')) as Aceptadas
    from cita ci 
    where ci.ID_cliente = (select c.ID_cliente from cliente c where c.nickname ='$usuario')";
    $ejecuta= $conecta->query($consulta);
    $row2=$ejecuta->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="PerfilUsuario/PerfilUsuario.css">
    <link rel="icon" href="PerfilUsuario/img/logo2.ico"> <!-- Para el icono de la pagina -->
    <link rel="stylesheet" href="PerfilUsuario/fontawesome-free-6.5.1-web/fontawesome-free-6.5.1-web/css/all.css">
    <!-- Aqui van las reglas de estilo -->
    <style>
    /* Datos de como contactar con el barbero */
        .botonTabla > p > a > .boton{
            font: bold 10px Arial, sans-serif;
            color: white;
            background-color: black;
            position: absolute;
            top: 46.5%;
            left: 58.6%;
            width: 19.4%;
            background: rgb(224, 161, 60);
            padding: 3px;
            border-radius: 2%;
            margin-bottom: 10px;
            border: 2px solid black;
        }
    </style>

</head>

<body>
    <!-- Cabecera del titulo y menu de barber talk -->
    <h1>Barber Talk</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="PerfilUsuario.php">Perfil</a></li>
            <li><a href="Cita3.php">Registrar cita</a></li>
            <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
    </nav>


    <!-- Aqui va lo del perfil -->
    <div class="container">
        <div class="Complicated">
            <br>
            <br>
            <br>              
             <h3>Bienvenido</h3>
             <input class="nombrebarbero" style="width: 18%"  type="nombre" name="nombre" id="nombre" placeholder="<?php echo $usuario; ?> " readonly>
             <img class="imagenbarbero" src="PerfilUsuario/img/usuario.png" width="150" height="150" style=" border: 1px solid black;" alt="no se encontro">
             <br>
             <br>
             <input class="correoUsuario" style="width: 18%" type="correo" name="correo" id="correo"  placeholder="<?php echo $row['correo'] ?>" readonly >
             <img class="imagenC" src="PerfilUsuario/img/correo.png" width="35" height="25" alt="no se encontro">
             <input class="telefonoUsuario" style="width: 18%"  type="telefono" name="telefono" id="telefono" placeholder="<?php echo $row['num_telefono'] ?>" readonly> 
             <img class="imagenT" src="PerfilUsuario/img/telefono.png" width="35" height="25" alt="no se encontro">
                <hr class="lineavertical">
            
                <!-- Segundo cuadro -->
                <div class="containerCitas">
                    <div class="ComplicatedCitas">
                        <br>
                        <br>
                        <br>              
                         <h4>Estado de citas: </h4>
                         <input class="citasRealizadas" type="citasR" name="citasR" id="citasR" placeholder="<?php echo $row2['Aceptadas'] ?>" readonly>
                         <p class="citasR">Realizadas</p>
                         <input class="citasCanceladas" type="citasC" name="citasC" id="citasC" placeholder="<?php echo $row2['Rechazadas'] ?>" readonly>
                         <p class="citasC">Canceladas</p>
                         <input class="citasTotales" type="citasT" name="citasT" id="citasT" placeholder="<?php echo $row2['Total'] ?>" readonly>
                         <p class="citasT">Total</p>   
                    </div>                
                </div>
                

                <div class="botonTabla"> <p><a href="Tabla_Usuario.php"><input  class="boton" type="button" value="Registro Citas"href="PerfilBarbero.html"></a></p></div> 
                <img class="imgpelo" src="PerfilUsuario\img\pelo.jpg" width="240" height="240" style="position: absolute; top: 54%; left: 60%;" alt="no se encontro"> 
                









    </div> <!-- Este cierra el complicated -->
    </div> <!-- Este cierra el container -->


</body>
</html>
 
