<?php
include '../db_connection.php';

$resultado = '';
$error = false;

$config = include '../config.php';
$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    try {
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    } catch (PDOException $error) {
        echo 'Error en la base de datos: ' . $error->getMessage();
        exit();
    }

if (isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $ID_Cliente = $_POST['ID_Cliente'];
    $ID_Mascota = $_POST['ID_Mascota'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $ID_Servicio = $_POST['servicio'];

    // Preparar y ejecutar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO citas (ID_Cliente, ID_Mascota, fecha, hora, ID_Servicio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $ID_Cliente, $ID_Mascota, $fecha, $hora, $ID_Servicio);

    if ($stmt->execute()) {
        $resultado = "Cita agendada con exito.";
    } else {
        $resultado = "Error: " . $stmt->error;
        $error = true;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include "../template/header.php"; ?>

<?php if (!empty($resultado)) { ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-<?= $error ? 'danger' : 'success' ?>" role="alert">
                    <?= $resultado ?>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="container" id="formucita">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mt-4">Agendar una cita</h2>
            <hr>
            <form method="post">
                <div class="form-group">
                    <label for="ID_Cliente">ID Cliente</label>
                    <input type="text" name="ID_Cliente" id="ID_Cliente" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="ID_Mascota">ID Mascota</label>
                    <input type="text" name="ID_Mascota" id="ID_Mascota" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="servicio">Servicio</label>
                    <select name="servicio" id="servicio" class="form-control" required>
                        <?php
                        // Obtener los servicios preestablecidos desde la base de datos
                        $sqlServicios = "SELECT * FROM servicios";
                        foreach ($conexion->query($sqlServicios) as $servicio) {
                            echo "<option value='" . $servicio['ID_Servicios'] . "'>" . htmlspecialchars($servicio['nombre']) . " - $" . htmlspecialchars($servicio['precio']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="hora">Hora</label>
                    <input type="time" name="hora" id="hora" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Enviar"> 
                </div>
                <br>
            </form>
        </div>
    </div>
</div>

<?php include "../template/footer.php"; ?>