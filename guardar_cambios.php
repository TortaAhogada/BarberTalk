<?php
    session_start();
    include 'include/conecta.php';
    $usuario = $_SESSION['nickname'];
    if (!isset($usuario)) {
        header("location:InicioTrabajador.php");
        exit();
    } elseif ($_SESSION['tipo'] == false) {
        header("location:PerfilBarbero.php");
        exit();
    }

    // Solo aceptar solicitudes POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos JSON del cuerpo de la solicitud
        $data = json_decode(file_get_contents("php://input"), true);
        $corteP = $data['CorteP'];
        $corteB = $data['CorteB'];

        // Validar y procesar los datos
        if (is_numeric($corteP) && is_numeric($corteB)) {
            // Actualizar los precios en la base de datos
            $query_update = "UPDATE precio SET precio = ? WHERE ID_precio = 2";
            $stmt = $conecta->prepare($query_update);
            $stmt->bind_param("d", $corteP);
            $stmt->execute();

            $query_update = "UPDATE precio SET precio = ? WHERE ID_precio = 1";
            $stmt = $conecta->prepare($query_update);
            $stmt->bind_param("d", $corteB);
            $stmt->execute();

            // Devolver una respuesta JSON
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Datos inválidos"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Método no permitido"]);
    }
?>
