
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolios</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css">
</head>
<body>

<?php
include 'includes/header.php';


use App\Models\Profile;

$perfilModel = Profile::getInstancia();

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $perfiles = $perfilModel->get($nombre); // Devuelve un array o un solo perfil.
    $_SESSION['resultados'] = $perfiles; // Almacena los resultados en la sesión
} else {
    $perfiles = $perfilModel->getActiveProfiles(); // Obtener todos los perfiles con la cuenta activa
    $_SESSION['resultados'] = $perfiles; // Almacena los resultados en la sesión
}
?>

<div class="container">
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Buscar perfiles...">
        <button type="submit">Buscar</button>
    </form>
    <br>

    <?php
    // Si existen resultados en la sesión, mostrarlos.
    if (isset($_SESSION['resultados'])) {
        $perfiles = $_SESSION['resultados'];
        if ($perfiles) {
            // Si es un solo perfil, mostramos sus datos.
            if (is_array($perfiles)) {
                echo '<div class="card-container">';
                foreach ($perfiles as $perfil) {
                    echo '<div class="card">';
                    echo "<img src='{$perfil['foto']}' alt='Foto de {$perfil['nombre']}' class='card-img'>";
                    echo "<div class='card-content'>";
                    echo "<h2>{$perfil['nombre']} {$perfil['apellidos']}</h2>";
                    echo "<p>{$perfil['categoria_profesional']}</p>";
                    echo "<a href='/portfolio/view/{$perfil['id']}' class='view-portfolio-button'>Ver Portfolio</a>";
                    echo "</div>";
                    echo "</div>";
                }
                echo '</div>';
            } 
        } else {
            echo "<p>No se encontraron perfiles</p>";
        }
    }
    ?>
</div>


</style>
</body>
</html>