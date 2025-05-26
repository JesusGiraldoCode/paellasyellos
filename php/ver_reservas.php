<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reservas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h1>Listado de Reservas</h1>

    <?php
    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "web_rest");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");

    // Consulta SQL
    $sql = "SELECT * FROM reservas ORDER BY res_fecha, res_hora";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Comensales</th>
                <th>Ubicación</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Comentarios</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['res_fecha']}</td>";
            echo "<td>{$row['res_hora']}</td>";
            echo "<td>{$row['res_com']}</td>";
            echo "<td>{$row['res_ubi']}</td>";
            echo "<td>{$row['res_nom']}</td>";
            echo "<td>{$row['res_tel']}</td>";
            echo "<td>{$row['res_ema']}</td>";
            echo "<td>" . nl2br(htmlspecialchars($row['res_comentarios'])) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No hay reservas registradas.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
