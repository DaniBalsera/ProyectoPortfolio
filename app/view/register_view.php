<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css">
</head>
<body>
    
<?php
include 'includes/header.php'; 
?>
    <h1>Registro</h1>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="/register" enctype="multipart/form-data">
        <input type="text" name="nombre" placeholder="Nombre" value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>">
        <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo isset($apellidos) ? htmlspecialchars($apellidos) : ''; ?>">
        <input type="email" name="email" placeholder="Correo electrónico" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        <input type="password" name="password" placeholder="Contraseña">
        <input type="text" name="categoria_profesional" placeholder="Categoría Profesional" value="<?php echo isset($categoria_profesional) ? htmlspecialchars($categoria_profesional) : ''; ?>">
        <textarea name="resumen_perfil" placeholder="Resumen del Perfil"><?php echo isset($resumen_perfil) ? htmlspecialchars($resumen_perfil) : ''; ?></textarea>
        <input type="file" name="foto">
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>