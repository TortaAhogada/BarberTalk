<?php
session_start();
include 'include/conecta.php';

// Validar que se cree una variable de sesión al pasar por el login
$usuario = $_SESSION['nickname'];
if (!isset($usuario)) {
    header("location:Inicio2.php");
    exit();
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar el tipo de solicitud
    $action = $_POST['action'] ?? '';

    if ($action == 'getHorarios') {
        // Obtener la fecha enviada desde el formulario
        $fecha = $_POST['fecha'];

        // Realizar operaciones con la fecha (por ejemplo, sumarle un día)
        $fechaDate = new DateTime($fecha);
        $fechaFormateada = $fechaDate->format('Y-m-d');

        // Realizar la consulta SQL para obtener los horarios disponibles
        $query = "SELECT h.Hora 
                  FROM horarios h
                  LEFT JOIN cita c ON h.id = c.hora AND c.fecha_cita = '$fechaFormateada'
                  LEFT JOIN trabajador t ON c.ID_trabajador = t.ID_trabajador
                  WHERE (t.tipo = 0 OR c.ID_trabajador IS NULL) AND h.status = 1
                  GROUP BY h.Hora
                  HAVING COUNT(DISTINCT c.ID_trabajador) = 0 OR COUNT(DISTINCT c.ID_trabajador) < (SELECT COUNT(*) FROM trabajador WHERE tipo = 0);";

        // Ejecutar la consulta SQL y obtener los resultados
        $resultados = $conecta->query($query);
        $horarios_disponibles = array();

        // Verificar si se encontraron resultados
        if ($resultados->num_rows > 0) {
            // Iterar sobre los resultados y guardar cada hora en el array
            while ($fila = $resultados->fetch_assoc()) {
                $horarios_disponibles[] = $fila['Hora'];
            }
        }

        // Devolver los horarios disponibles como respuesta
        echo json_encode($horarios_disponibles);

    } elseif ($action == 'getTrabajadores') {
        // Obtener la fecha y la hora enviadas desde el formulario
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];

        // Realizar la consulta SQL para obtener los trabajadores disponibles
        $query = "SELECT t.ID_trabajador, t.nombre
                    FROM trabajador t
                    LEFT JOIN cita c ON t.ID_trabajador = c.ID_trabajador AND c.fecha_cita = '$fecha' AND c.hora = (SELECT id FROM horarios WHERE Hora = '$hora')
                    WHERE t.tipo = 0 and t.status =1
                    GROUP BY t.ID_trabajador
                    HAVING COUNT(c.ID_cita) = 0";

        // Ejecutar la consulta SQL y obtener los resultados
        $resultados = $conecta->query($query);
        $trabajadores_disponibles = array();

        // Verificar si se encontraron resultados
        if ($resultados->num_rows > 0) {
            // Iterar sobre los resultados y guardar cada trabajador en el array
            while ($fila = $resultados->fetch_assoc()) {
                $trabajadores_disponibles[] = array(
                    "ID_trabajador" => $fila['ID_trabajador'],
                    "nombre" => $fila['nombre']
                );
            }
        }

        // Devolver los trabajadores disponibles como respuesta
        echo json_encode($trabajadores_disponibles);

    } } elseif ($action == 'enviarDatos') {
        // Obtener los datos enviados desde el cliente
        $datos = $_POST['datos'] ?? null;
    
        // Devolver los datos como respuesta al cliente
        echo json_encode($datos);
    }
?>
