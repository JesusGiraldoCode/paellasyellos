<?php
// Configuración de la conexión
$servername = "localhost";
$username = "root";
$password = "";
$database = "web_rest";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");


// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger y sanitizar datos del formulario
$res_fecha = $_POST['res_fecha'];
$res_hora = $_POST['res_hora'];
$res_com  = (int) $_POST['res_com'];
$res_ubi  = $_POST['res_ubi'];
$res_nom  = $conn->real_escape_string($_POST['res_nom']);
$res_tel  = $conn->real_escape_string($_POST['res_tel']);
$res_ema  = $conn->real_escape_string($_POST['res_ema']);
$res_comentarios = $conn->real_escape_string($_POST['res_comentarios']);

// Validar formato de email (opcional pero recomendable)
if (!filter_var($res_ema, FILTER_VALIDATE_EMAIL)) {
    die("El correo electrónico no tiene un formato válido.");
}

// Preparar la consulta SQL con comentarios
$sql = "INSERT INTO reservas (res_fecha, res_hora, res_com, res_ubi, res_nom, res_tel, res_ema, res_comentarios)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}

// Enlazar parámetros y ejecutar
$stmt->bind_param("ssisssss", $res_fecha, $res_hora, $res_com, $res_ubi, $res_nom, $res_tel, $res_ema, $res_comentarios);

if ($stmt->execute()) {
    echo "¡Reserva realizada con éxito!";
} else {
    echo "Error al guardar la reserva: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
