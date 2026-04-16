<?php include("menu.php"); ?>
<?php include("conexion.php"); ?>

<h2>Alta de Libro</h2>

<form method="POST">
    Título: <input type="text" name="Titulo" required>
    ISBN: <input type="text" name="ISBN" required>
    Editorial: <input type="text" name="Editorial" required>
    Páginas: <input type="number" name="Paginas" required>
    <button type="submit" name="guardar">Guardar</button>
</form>

<?php

if (isset($_POST['guardar'])) {
    $conexion->query("INSERT INTO Libro (Titulo, ISBN, Editorial, Paginas)
                      VALUES ('{$_POST['Titulo']}','{$_POST['ISBN']}','{$_POST['Editorial']}','{$_POST['Paginas']}')");
}
?>

<hr>

<h2>Listado de Libros</h2>

<table border="1">
<tr>
    <th>Título</th>
    <th>ISBN</th>
    <th>Editorial</th>
    <th>Páginas</th>
    <th>Acciones</th>
</tr>

<?php
$resultado = $conexion->query("SELECT * FROM Libro");

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
        <td>{$fila['Titulo']}</td>
        <td>{$fila['ISBN']}</td>
        <td>{$fila['Editorial']}</td>
        <td>{$fila['Paginas']}</td>
        <td>
            <a href='libros.php?eliminar={$fila['ID_LIBRO']}'>Eliminar</a>
        </td>
    </tr>";
}
?>
</table>

<?php
// ELIMINAR
if (isset($_GET['eliminar'])) {
    $conexion->query("DELETE FROM Libro WHERE ID_LIBRO={$_GET['eliminar']}");
    header("Location: libros.php");
}
?>