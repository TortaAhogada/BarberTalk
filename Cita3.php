<?php
session_start();
include 'include/conecta.php';

// Validar que se cree una variable de sesión al pasar por el login
$usuario = $_SESSION['nickname'];
if (!isset($usuario)) {
    header("location:Inicio2.php");
}if (($_SESSION['tipo'])) {
    header("location:PerfilDueño.php");
}else if (($_SESSION['tipo'])===false) {
    header("location:PerfilBarbero.php");
}

$query_cliente = "SELECT c.ID_cliente FROM cliente c WHERE c.nickname = '$usuario'";
$resultado_cliente = $conecta->query($query_cliente);
$cliente = $resultado_cliente->fetch_assoc();
$id_cliente = $cliente['ID_cliente'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar cita</title>
    <link rel="stylesheet" href="CIta3/style.css">
</head>
<body>
    <h1>Barber Talk</h1>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="PerfilUsuario.php">Perfil</a></li>
            <li><a href="PreguntasF.html">Preguntas frecuentes</a></li>
            <li><a href="Informacion.html">Información</a></li>
            <li><a href="include/cerrar.php">Cerrar sesión</a></li>
        </ul>
    </nav>

<br>

    <div class="container">
        <h3>Registro de citas</h3>

        <div id="fecha" class="pantalla active">
            <label for="fechaCita">Fecha de la cita:</label>
            <input type="hidden" id="idCliente" value="<?php echo $id_cliente ?>">
            <input type="date" id="fechaCita" name="fechaCita" required>
            <button id="btnSiguienteFecha" type="button" name="btnSiguienteFecha">Siguiente</button>
        </div>

        <div id="hora" class="pantalla">
            <label for="horaCita">Hora de la cita:</label>
            <select name="horaCita" id="horaCita">
                <option value="0">Elige una de los horarios disponibles a continuación</option>
            </select>
            <button id="btnAnteriorHora" type="button">Anterior</button>
            <button id="btnSiguienteHora" type="button">Siguiente</button>
        </div>

        <div id="barbero" class="pantalla">
            <h2>Elige tu barbero:</h2>
            <select id="barberoSeleccionado">
                <option value="">Selecciona un barbero</option>
            </select>
            <button id="btnAnteriorBarbero" type="button">Anterior</button>
            <button id="btnSiguienteBarbero" type="button">Siguiente</button>
        </div>

        <div id="servicio" class="pantalla">
            <h2>Elige el servicio:</h2>
            <label for="servicioCorteCabello">
                <input type="radio" id="servicioCorteCabello" name="servicio" value="Corte cabello" checked required>
                Corte de cabello
            </label>
            <label for="servicioCorteBarba">
                <input type="radio" id="servicioCorteBarba" name="servicio" value="Corte barba">
                Corte de barba
            </label>
            <button id="btnAnteriorServicio" type="button">Anterior</button>
            <button id="btnSiguienteInformacion" type="button">Siguiente</button>
        </div>

        <div id="informacion" class="pantalla">
            <h2>Resumen de cita:</h2>
            <div id="resumenCita"></div>
            <button id="btnAnteriorInformacion" type="button">Anterior</button>
            <button id="btnEnviar" type="submit" name="btnEnviar">Enviar</button>
        </div>
    </div>

    <script src="CIta3/script.js"></script>
</body>
</html>
