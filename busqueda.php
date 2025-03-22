<?php
require_once "config.php";
require_once "Libro.php";
require_once "Usuario.php";
require_once "Prestamo.php";
require_once "Biblioteca.php";

//Crear instancia de la biblioteca y cargar los datos
$biblioteca = new Biblioteca();
$biblioteca->loadData();

//Obtener término de búsqueda desde el formulario
$resultados = [];
if(isset($_GET['buscar']) && !empty($_GET['termino'])) {
    $termino = $_GET['termino'];
    $resultados = $biblioteca->searchBook($termino);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Libros</title>
</head>
<body>
    <h1>Buscar Libros</h1>
    <form method="get">
        <input type="text" name="termino" placeholder="Título, autor o materia" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if (!empty($resultados)): ?>
        <h2>Resultados:</h2>
        <ul>
            <?php foreach ($resultados as $libro): ?>
                <li>
                    <strong><?= htmlspecialchars($libro->titulo) ?></strong><br>
                    Autor: <?= htmlspecialchars($libro->autor) ?><br>
                    Materia: <?= htmlspecialchars($libro->materia) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif (isset($_GET['buscar'])): ?>
        <p>No se encontraron resultados para: <strong><?= htmlspecialchars($_GET['termino']) ?></strong></p>
    <?php endif; ?>
</body>
</html>