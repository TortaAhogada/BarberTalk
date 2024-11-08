<?php
//Declarar las variables en donde se guardarán los valores de la conexión
$servidor="localhost";
$usuario="root";
$password="";
$bd="barbershop";
$conecta= mysqli_connect($servidor,$usuario,$password,$bd);
if ($conecta->connect_error) {
    die("Error al conectar la base de datos de la página".$conecta->connect_error);
}
?>

