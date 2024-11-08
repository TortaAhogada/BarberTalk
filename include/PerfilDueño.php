<?php
    //Recordar la variable de sesion
    session_start();
    include 'include/conecta.php';
    //Validar que se cree una variable de sesion al pasar por el login
    $usuario=$_SESSION['nickname'];
    if (!isset($usuario)) {
        header("location:InicioTrabajador.php");
    }elseif ($_SESSION['tipo']==false) {
        header("location:PerfilBarbero.php");
    }
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Dueño</title>
    <link rel="stylesheet" href="PerfilDueño/PerfilDueño.css">
    <link rel="icon" href="PerfilDueño/img/logo2.ico"> <!-- Para el icono de la pagina -->

</head>
<body>
    <!-- Cabecera del titulo y menu de barber talk -->
    <h1>Barber Talk</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="PerfilDueño.html">Perfil</a></li>
            <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
            <li><a href="Informacion.html">Información</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
    </nav>


    <!-- Aqui va lo del perfil del dueño -->
     <div class="container">
        <div class="Complicated">
             <br>
             <br>
             <h3>Dueño: </h3>
             <input class="nombredueño" type="text" name="nombre" id="nombre" placeholder="Jóse Martinez" readonly>
             <img class="imagenbarbero" src="PerfilDueño/img/PerfiB.png" width="150" height="150" alt="no se encontro">



             <!-- Tercer cuadro -->
             <div class="containerDatos">
                <div class="ComplicatedDatos">
                     <br>
                     <h5>Datos Generales</h5>
                     <br>
                     <p class="correoP">Correo electronico</p>
                     <input class="correo" type="email" name="correo" id="correo" placeholder="joseM@hotmail.com" readonly>
                     
                     <p class="telefonoT">Telefono</p>
                     <input class="telefono" type="telefono" name="telefono" id="telefono" placeholder="3121394567" readonly>
                    
                     <p class="ubicacionU">Ubicacion de la barberia</p>
                     <p class="ubicaciona">Emiliano Zapata 1, </p>
                     <p class="ubicacionb"> Centro, 28510 Quesería, Col.</p>    
                     <br>
                     <img class="imagenMapa" src="PerfilDueño/img/MapaBT.png" width="140" height="140" alt="no se encontro">
                
                     <hr class="lineavertical">

                     <h6>Herramientas de configuración</h6>
                     <div class="botonI"> <p><a href="ConfiguracionD.php"><input  class="boton" type="button" value="Configuración"href="PerfilDueño.html"></a></p></div> 
                     <div class="botonR"> <p><a href="Tabla_Dueño.php"><input  class="botonr" type="button" value="Registro Citas"href="PerfilDueño.html"></a></p></div> 
                     <div class="botonP"> <p><a href="TablaPDueño.html"><input  class="botonp" type="button" value="Detalles de Barberos"href="PerfilDueño.html"></a></p></div> 
                     <img class="imgfe" src="PerfilDueño/img/fe.png" width="200" height="200" alt="no se encontro">
                     <img class="imgEngrane" src="PerfilDueño/img/eengrane.png" width="220" height="220" alt="no se encontro">
     
                 



                     <br>
                    </div>
             </div>
             




        </div><!--Este cierra el Complicated -->
     </div><!--Este cierra el container -->



</body>
</html>