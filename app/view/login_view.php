<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Portafolio</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css">
</head>

<body>
    
<?php
include 'includes/header.php'; 
?>
    <h1>Inicio de Sesión</h1>
    <form method="POST" action="/login">
        <input type="email" name="email" placeholder="Correo electrónico">
        <input type="password" name="password" placeholder="Contraseña">
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>