<?php
    //Recordar la variable de sesion
    error_reporting(0);
    session_start();
    include 'include/conecta.php';
    //Validar que se cree una variable de sesion al pasar por el login
    $usuario = $_SESSION['nickname'];
    if (!isset($usuario)) {
        header("location:InicioTrabajador.php");
    }if (($_SESSION['tipo'])==null) {
        header("location:PerfilUsuario.php");
    }if (($_SESSION['tipo'])==false) {
        header("location:PerfilBarbero.php");
    }
    $mensaje=null;
    // Consulta los precios
    $query_cliente = "SELECT p.precio FROM precio p WHERE p.ID_precio = 2";
    $resultado_cliente = $conecta->query($query_cliente);
    $precio = $resultado_cliente->fetch_assoc();
    $cabello = $precio['precio'];

    $query_cliente = "SELECT p.precio FROM precio p WHERE p.ID_precio = 1";
    $resultado_cliente = $conecta->query($query_cliente);
    $precio = $resultado_cliente->fetch_assoc();
    $barba = $precio['precio'];

    if (isset($_POST['botonRegistrar'])) {
        $nombre=$conecta->real_escape_string($_POST['nombre']);
        $nickname=$conecta->real_escape_string($_POST['nomU']);
        $primerApellido=$conecta->real_escape_string($_POST['Papellido']);
        $segundoApellido=$conecta->real_escape_string($_POST['Sapellido']);
        $correo=$conecta->real_escape_string($_POST['correo']);
        $telefono=$conecta->real_escape_string($_POST['telefono']);
        $tipo=$conecta->real_escape_string($_POST['tipo']);
        $contraseña=$conecta->real_escape_string($_POST['contraseña']);

        //Consulta para insertar los datos
        if ($nombre=='' or $primerApellido=='' or $segundoApellido=='' or $correo=='' or $nickname=='' or $contraseña=='' or $telefono=='') {
        }else{
            //Consulta para verificar que el registro no exista
            $validar="select * from trabajador t where correo='$correo' or nickname='$nickname'";
            $validando=$conecta->query($validar);
            if ($validando->num_rows > 0) {
                $mensaje.="<script> alert('Usuario existente')</script>";
                echo($mensaje);
            }else {
                $insertar="INSERT INTO `trabajador`(`nombre`, `nickname`, `first_apellido`, `second_apellido`, `correo`, `num_telefono`, `contraseña`, `status`, `tipo`) 
                VALUES ('$nombre','$nickname','$primerApellido','$segundoApellido','$correo','$telefono','$contraseña','1','$tipo')";
                $guardando=$conecta->query($insertar);
                if ($guardando > 0) {
                    header("location:TablaPDueño.php");

                }else{
                    
            }
            }

            
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuracion</title>
    <link rel="stylesheet" href="Configuracion del Dueño/Configuracion.css">
    <link rel="icon" href="img/logo2.ico"> <!-- Para el icono de la pagina -->
   
    <style>
        /*Estilo de botones de guardar cambios*/
        .botonGuardar > p > a > .boton{
            font: bold 12px Arial, sans-serif;
            color: white;
            background-color: black;
            position: absolute;
            top: 91%;
            left: 18%;
            width: 19.4%;
            background: #757575;
            padding: 2px;
            border-radius: 13%;
            margin-bottom: 10px;
            border: 2px solid black;
        }

        /*Estilo de botones de registrar nuevos barberos*/
        .botonRegistrar > p > a > .boton{
            font: bold 12px Arial, sans-serif;
            color: white;
            background-color: black;
            position: absolute;
            top: 91%;
            left: 68%;
            width: 19.4%;
            background: #757575;
            padding: 2px;
            border-radius: 13%;
            margin-bottom: 10px;
            border: 2px solid black;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("guardarCambios").addEventListener("click", function() {
                const corteP = document.getElementById("CorteP").value;
                const corteB = document.getElementById("CorteB").value;

                fetch("guardar_cambios.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ CorteP: corteP, CorteB: corteB })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Precios actualizados correctamente");
                        window.location.href = 'ConfiguracionD.php';
                    } else {
                        alert("Por favor ingrese todos los datos del precio");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            });
        });
    </script>
        
    <script>
        
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("botonRegistrar").addEventListener("click", function() {
                const nombre= document.getElementById("nombre").value;
                const nickname= document.getElementById("nomU").value;
                const apellido= document.getElementById("Papellido").value;
                const Sapellido= document.getElementById("Sapellido").value;
                const correo= document.getElementById("correo").value;
                const telefono= document.getElementById("telefono").value;
                const tipo= document.getElementById("tipo").value;
                const contra= document.getElementById("contraseña").value;
                
                if (nombre === "" || nickname === "" || apellido === "" || Sapellido === "" || correo === "" || telefono === "" || tipo === "" || contra === "") {
                    alert("Por favor, complete todos los campos.");
                }
            })
        });
    </script>
</head>
<body>
     <!-- Cabecera del titulo y menu de barber talk -->
     <h1>Barber Talk</h1>
     <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="PerfilDueño.php">Perfil</a></li>
            <li><a href="Cita3.php">Mis citas</a></li>
            <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
     </nav>

    <!-- Aqui va la configuracion que hace el dueño -->
    <!-- CUADRO 1-->
    <form action="" method="post" id="miFormulario">
    <div class="container">
        <div class="Complicated">
            <h2 style="height: 1%;">Ingrese el costo de cada servicio</h2>        
            <p class="p4" style="height: 1%;">Corte de pelo</p>
            <input class="corteP" type="number" name="CorteP" id="CorteP" placeholder="<?php echo $cabello; ?>" autocomplete="telefono" autofocus pattern="[0-9]{3}[0-9]{3}[0-9]{4}" 
            onkeypress="return onlyNumberKey(event)" onkeyup="maximacadena(this,this.value)" maxlength="10" 
            size="10">

            <p class="p5" style="width: 10%; left: 22%;">Corte de barba</p>
            <input class="corteB" type="number" name="CorteB" id="CorteB" placeholder="<?php echo $barba; ?>">

            <div class="botonI"> <p>></p></div>
            <div class="botonP"> <p><input id="guardarCambios" class="boton" type="button" value="Guardar cambios"></p></div>  
            <img class="imgbar" src="Configuracion del Dueño/img/barba_pelo.avif" width="280" height="180" alt="no se encontro">
             
            <hr class="lineahorizontal">

            <h3 style="height: 1%;">Registre un nuevo trabajador</h3>
             <p class="p7" style="height: 1%;">Nombre</p>
             <input class="nombreR" type="nombre" name="nombre" id="nombre" placeholder="escribe tu nombre" autocomplete="nombre" autofocus placeholder="nombre" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require>

             <p class="p8" style="height: 1%;">Nombre de Usuario</p>
             <input class="nomU" type="nomU" name="nomU" id="nomU" placeholder="nombre de usuario" autocomplete="nomU" autofocus placeholder="nomU" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require>

             <p class="p9" style="height: 1%;">Primer Apellido</p>
             <input class="Papellido" type="1apellido" name="Papellido" id="Papellido" placeholder="1apellido" autocomplete="Papellido" autofocus placeholder="Papellido" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require> 

             <p class="p10" style="height: 1%;">Segundo Apellido</p>
             <input class="Sapellido" type="Sapellido" name="Sapellido" id="Sapellido" placeholder="2apellido" autocomplete="Sapellido" autofocus placeholder="Sapellido" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require> 

             <p class="p11" style="height: 1%;">Correo</p>
             <input class="correo" type="email" name="correo" id="correo" placeholder="corrreo E" require> 

             <p class="p12" style="height: 1%;">Telefono</p>
             <input class="telefono" type="number" name="telefono" id="telefono" placeholder="num" autocomplete="telefono" autofocus pattern="\d{10}" 
            onkeypress="return onlyNumberKey(event)" onkeyup="maximacadena(this,this.value)" maxlength="10" 
            size="10" require>

             <p class="p13" style="height: 1%;">Tipo Empleado</p>
             <select name="tipo" id="tipo">
                <option value="">Seleccione tipo trabajador</option>
                <option value="0">Barbero</option>
                <option value="1">Dueño</option>
             </select>  
             <p class="p14" style="height: 1%;">Contraseña</p>
             <input class="contraseña" type="password" name="contraseña" id="contraseña" placeholder="" require>
             <div class="botonD"> <p>></p></div> 
             <div class="botonRegistrar"> <p><a><input class="boton" type="submit" value="Registrar Empleado" name="botonRegistrar" id="botonRegistrar"></a></p></div> 
             
        </div> <!-- Este cierra el Complicated -->
    </div> <!-- Este cierra el container -->
    </form>
</body>
</html>

<script>
        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        document.getElementById("miFormulario").addEventListener("submit", function(event) {
            const telefono = document.getElementById("telefono").value;

            if (telefono.length !== 10 || !/^\d{10}$/.test(telefono)) {
                alert("El número de teléfono debe contener exactamente 10 dígitos.");
                event.preventDefault(); // Evitar el envío del formulario
            }
        });
</script>

<script>
        function onlyLetterKey(e) {
            var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
            especiales = [8, 37, 39, 46],
            tecla_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }
    </script>

