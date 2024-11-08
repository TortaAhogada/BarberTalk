<?php
    error_reporting(0);
    include 'include/conecta.php';
    //Validar que exista un boton enviar
    if (isset($_POST['Registrar'])) {
        $mensaje="";
        $nombre=$conecta->real_escape_string($_POST['nombre']);
        $apellido1=$conecta->real_escape_string($_POST['apellido1']);
        $apellido2=$conecta->real_escape_string($_POST['apellido2']);
        $correo=$conecta->real_escape_string($_POST['correo']);
        $nickname=$conecta->real_escape_string($_POST['nickname']);
        $contraseña=$conecta->real_escape_string($_POST['contraseña']);
        $telefono=$conecta->real_escape_string($_POST['telefono']);

        //Consulta para insertar los datos
        if ($nombre=='' or $apellido1=='' or $correo=='' or $nickname=='' or $contraseña=='' or $telefono=='') {
            $mensaje="Por favor ingresa todos los datos";
        }else{
            //Consulta para verificar que el registro no exista
            $validar="select * from cliente where correo='$correo' or nickname='$nickname'";
            $validando=$conecta->query($validar);
            if ($validando->num_rows > 0) {
                $mensaje.="Usuario y/o Email ya esta registrado";
            }else {
                $insertar="INSERT INTO cliente(nombre,first_apellido,second_apellido,correo,
                nickname,contraseña,num_telefono)Values('$nombre','$apellido1','$apellido2','$correo','$nickname','$contraseña','$telefono')";
                $guardando=$conecta->query($insertar);
                if ($guardando > 0) {
                    $mensaje.="Usuario registrado";
                }else{
                    $mensaje.="Error en la consulta";
            }
            }

            
        }
    }

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="Registro\Registro.css">
    <link rel="icon" href="Registro/img/logo2.ico"> <!-- Para el icono de la pagina -->
    <!-- Aqui van las reglas de estilo -->

</head>
<body>
    <!-- Cabecera del titulo y menu de barber talk -->
    <div class="FondoRegistro"> 
        <header>
        <h1>Barber Talk</h1>
            <nav>
                <ul>  
                    <form class="d-flex" role="search">          
                        <li><a href="index.html">Home</a></li>
                        <li><a href="Inicio2.php">Iniciar sesión</a></li>
                        <li><a href="Informacion.html">Información</a></li>
                        <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
                        <li><a href="include/cerrar.php">Cerrar sesión</a></li>
                  </form>
                </ul>
            </nav>
        </header>

<br>
<form class="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="miFormulario">
    <div class="container">
        <div class="Complicated">
    <!-- <section class="formulario-registro"> -->
     
        <h4>Registro</h4>
        
            <div class="cuadro1">
            <input class="controls" type="text" name="nombre" id="nombre" placeholder="Ingrese su Nombre" autocomplete="nombre" autofocus placeholder="nombre" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require>


            <input class="controls" type="text" name="apellido1" id="apellido1" placeholder="Primer Apellido" autocomplete="apellido1" autofocus placeholder="apellido1" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require>

            <input class="controls" type="text" name="apellido2" id="apellido2" placeholder="Segundo Apellido" autocomplete="apellido2" autofocus placeholder="apellido2" onkeyup="maximacadena(this,this.value)" 
            maxlength="100" size="100" onkeypress="return onlyLetterKey(event)" require>

            <input class="controls" type="email" name="correo" id="correo" placeholder="Ingrese su Correo" require>
            </div>

            <div class="cuadro2">
            <input class="controls" type="text" name="nickname" id="nickname" placeholder="Nombre de Usuario" require>
            <input class="controls" type="password" name="contraseña" id="contraseña" placeholder="Ingrese una Contraseña" require>
            <input class="controls" type="number" name="telefono" id="telefono" autocomplete="telefono" autofocus placeholder="10 dígitos ej. 3121231231" pattern="\d{10}" 
            onkeypress="return onlyNumberKey(event)" onkeyup="maximacadena(this,this.value)" maxlength="10" 
            size="10" require>
            <?php echo $mensaje; ?>

            </div>
           
            <br>
            <input  class="botones" type="submit" value="Registrar" name="Registrar">
            <p class="cuenta" style="height: 5%;"><a href="Inicio2.php">¿Ya tengo cuenta?</a></p>
            
        

       
        

    <!-- </section> -->
    </div>
    
</div>
</form>
    <br>
    <br>
    <br>
    
    

</div>

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