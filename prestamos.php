<?php include("menu.php"); ?>
<?php include("conexion.php"); ?>

<h2>Registrar Préstamo</h2>

<form method="POST">

Usuario:
<select name="ID_USUARIO">
<?php
$usuarios = $conexion->query("SELECT * FROM usuario");
while ($u = $usuarios->fetch_assoc()) {
    echo "<option value='{$u['ID_USUARIO']}'>{$u['NOMBRE']}</option>";
}
?>
</select>

Ejemplar:
<select name="ID_EJEMPLAR">
<?php
$ejemplares = $conexion->query("SELECT * FROM Ejemplar");
while ($e = $ejemplares->fetch_assoc()) {
    echo "<option value='{$e['ID_EJEMPLAR']}'>Ejemplar {$e['ID_EJEMPLAR']}</option>";
}
?>
</select>

Fecha préstamo:
<input type="date" name="FECHA_PREST" required>

Fecha devolución:
<input type="date" name="FECHA_DEVO" required>

<button type="submit">Guardar</button>

</form>

<?php
if ($_POST) {
    $conexion->query("INSERT INTO Prestamo (ID_EJEMPLAR, ID_USUARIO, FECHA_PREST, FECHA_DEVO)
                      VALUES ('{$_POST['ID_EJEMPLAR']}','{$_POST['ID_USUARIO']}','{$_POST['FECHA_PREST']}','{$_POST['FECHA_DEVO']}')");

    $conexion->query("UPDATE Ejemplar SET Disponibilidad = 0 WHERE ID_EJEMPLAR = {$_POST['ID_EJEMPLAR']}");
}
?>

<hr>

<h2>Préstamos</h2>

<table border="1">
<tr>
    <th>ID</th>
    <th>Usuario</th>
    <th>Ejemplar</th>
    <th>Fecha préstamo</th>
    <th>Fecha devolución</th>
    <th>Acción</th>
</tr>

<?php
$sql = "SELECT p.ID_PRESTAMO, u.Nombre as usuario, p.ID_EJEMPLAR,
               p.FECHA_PREST, p.FECHA_DEVO
        FROM Prestamo p
        JOIN Usuario u ON p.ID_USUARIO = u.ID_USUARIO";

$resultado = $conexion->query($sql);

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
        <td>{$fila['ID_PRESTAMO']}</td>
        <td>{$fila['usuario']}</td>
        <td>{$fila['ID_EJEMPLAR']}</td>
        <td>{$fila['FECHA_PREST']}</td>
        <td>{$fila['FECHA_DEVO']}</td>
        <td>
            <a href='prestamos.php?devolver={$fila['ID_EJEMPLAR']}'>Devolver</a>
        </td>
    </tr>";
}
?>
</table>

<?php
// DEVOLVER LIBRO
if (isset($_GET['devolver'])) {
    $conexion->query("UPDATE Ejemplar SET Disponibilidad = 1 WHERE ID_EJEMPLAR={$_GET['devolver']}");
    header("Location: prestamos.php");
    exit();
}
?>