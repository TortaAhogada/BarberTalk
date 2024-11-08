<?php 
session_start();
error_reporting(0);
//Llamar a la conexión de base de datos
include 'include/conecta.php';

if (isset($_POST['entrar'])) {

    $usuario= $conecta->real_escape_string($_POST['nickname']);
    $rpass= $conecta->real_escape_string($_POST['contraseña']);

    if ($usuario=="" or $rpass=="") {
        $mensaje.="<Strong>Por favor ingrese los datos correctamente</Strong>";
    }else{
            //Generar una consulta que extraiga los datos de la bd
            $consulta="select c.nickname, c.contraseña from cliente c where c.nickname = '$usuario' and c.contraseña = '$rpass'";
            if ($resultado=$conecta->query($consulta)) {
            while($row= $resultado->fetch_array()){
                $userok= $row['nickname'];
                $passwordok= $row['contraseña'];
            }
            $resultado->close();
            }
    
        $conecta->close(); 
    
        if (isset($usuario) && isset($rpass)) {
            if ($usuario == $userok && $rpass == $passwordok)  {
                $_SESSION['login']= TRUE;
                $_SESSION['nickname']= $usuario;
                $_SESSION['tipo']=null;
                header("location:PerfilUsuario.php");
            }else {
    
                $mensaje.="<Strong>Nombre de usuario o contraseña incorrecto</Strong>";
                
            }
        }else {
            $mensaje.="<Strong>Nombre de usuario o contraseña incorrecto</Strong>";
    
            }
    
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
    <link rel="stylesheet" href="Inicio sesión/inicio2.css">
    <link rel="icon" href="Inicio sesión/img/logo2.ico"> <!-- Para el icono de la pagina -->
    
</head>
<body>
   
    <!-- Cabecera del titulo y menu de barber talk -->
    <div class="FondoInicio">  
        <header>
        <h1>Barber Talk</h1>
            <nav>
                <ul>  
                    <form class="d-flex" role="search">             
                        <li><a href="index.html">Home</a></li>
                        <li><a href="Registro.php">Registrarse</a></li>
                        <li><a href="Informacion.html">Información</a></li>
                        <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
                  </form>
                </ul>
            </nav>
        </header> 
        
<br>


    <!-- Esto es del incio de sesion -->
    <section class="formulario-registro">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?> " method="post">
            <h4>Iniciar sesión</h4>
            <input class="controls" type="text" name="nickname" id="correo" placeholder="Ingrese su nombre de usuario">
            <input class="controls" type="password" name="contraseña" id="contraseña" placeholder="Ingrese su Contraseña">
            <input  class="botones" type="submit" name="entrar" value="Iniciar" href="PerfilUsuario.html">
            <br>
            <p><a class="No tengo cuenta" href="Registro.php">¿Aún no tengo cuenta?</a></p>
            <br>
            <div class="mensaje">
                <?php echo $mensaje ?>
            </div>

        </form>
    </section>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    </div> 
</body>
</html>