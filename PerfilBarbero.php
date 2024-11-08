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
    
    $consulta="select t.correo, t.num_telefono from trabajador t where t.nickname ='$usuario'";
    $ejecuta= $conecta->query($consulta);
    $row=$ejecuta->fetch_assoc();


    $consulta="select count(c.ID_cliente) as total,
    (select count(c.ID_cita) from cita c where ID_trabajador =(select ID_trabajador from trabajador t where t.nickname='$usuario') and c.status=false) as rechazada,
    (select count(c.ID_cita) from cita c where ID_trabajador =(select ID_trabajador from trabajador t where t.nickname='$usuario') and c.status=true) as aceptadas
    from cita c 
    where ID_trabajador =(select ID_trabajador from trabajador t where t.nickname='$usuario')";
    $ejecuta= $conecta->query($consulta);
    $row2=$ejecuta->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Barbero</title>
    <link rel="stylesheet" href="PerfilBarbero/PerfilBarbero.css">
    <link rel="icon" href="PerfilBarbero/img/logo2.ico">
    
     <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  -->
    <style>
        /* Datos de como contactar con el barbero */
        .botonTabla > p > a > .boton{
            font: bold 13px Arial, sans-serif;
            color: white;
            background-color: black;
            position: absolute;
            top: 49.5%;
            left: 58%;
            width: 20%;
            background: rgb(224, 161, 60);
            padding: 3px;
            /* border-radius: 20px; */
            margin-bottom: 10px;
            border: 1.5px solid black;
        }
     </style>

</head>



<body>
    <!-- Cabecera del titulo y menu de barber talk -->
    <div> 
        <header>
        <h1>Barber Talk</h1>
            <nav>
                <ul>  
                    <form class="d-flex" role="search">           
                        <li><a href="index.html">Home</a></li>
						<li><a href="PerfilBarbero.php">Perfil</a></li>
                        <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
                        <li><a href="Informacion.html">Informacion</a></li>
                        <li><a href="include/cerrar.php">Cerrar sesión</a></li>
                  </form>
                </ul>
            </nav>
        </header>

        <div class="container">
            <div class="Complicated">
                <br>
                <br>
                <br>              
                 <h2>Barbero 1</h2>
                 <h3>Nombre: </h3>
                 <input class="nombrebarbero" type="text" name="nombre" id="nombre" placeholder="<?php echo $usuario; ?>">
                 <p class="años">Tengo 6 años de experiencia en esta profesión,</p>
                 <p class="años2">otorgando un gran servicio a mis clientes</p>
                 <img class="imagenbarbero" src="PerfilBarbero/img/usuario.png" style="position: absolute; top:45%;  border: 1px solid black;" width="150" height="150" alt="no se encontro">
                 <p class="areas">Mi especialidad es: </p>
                <button class="especialidad1">Estilista de cabello</button>
                <button class="especialidad2">Estilista de barba</button>
                <hr class="lineavertical">

                  <!-- Segundo cuadro -->
                  <div class="containerCitas">
                    <div class="ComplicatedCitas">
                        <br>           
                         <h4>Resumen de citas</h4>
                         <input class="citasRealizadas" type="citasR" name="citasR" id="citasR" placeholder="<?php echo $row2['aceptadas'] ?>" readonly>
                         <p class="citasR">Aceptadas</p>
                         <input class="citasCanceladas" type="citasC" name="citasC" id="citasC" placeholder="<?php echo $row2['rechazada'] ?>" readonly>
                         <p class="citasC">Canceladas</p>
                         <input class="citasTotales" type="citasT" name="citasT" id="citasT" placeholder="<?php echo $row2['total'] ?>" readonly>
                         <p class="citasT">Total</p>   
                    </div>
                </div>



                <div class="botonTabla"> <p><a href="Tabla_Barbero.php"><input  class="boton" type="button" value="Registro Citas"></a></p></div> 
                
                <button class="telefono"><?php echo $row['correo'] ?></button> 
                <button class="correo"><?php echo $row['num_telefono'] ?></button>
                <img class="imagenT" src="img/telefono.png" width="35" height="25" alt="no se encontro">
                <img class="imagenC" src="img/correo.png" width="35" height="25" alt="no se encontro">
               
                  
            </div>
        </div>



</body>
</html>