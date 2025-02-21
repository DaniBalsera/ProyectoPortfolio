<!--Vista de edición de trabajo!-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trabajo</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h1>Editar Trabajo</h1>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Título del Trabajo" value="<?php echo htmlspecialchars($data['titulo'] ?? ''); ?>">
            <textarea name="descripcion" placeholder="Descripción del Trabajo"><?php echo htmlspecialchars($data['descripcion'] ?? ''); ?></textarea>
            <input type="text" name="logros" placeholder="Logros del Trabajo" value="<?php echo htmlspecialchars($data['logros'] ?? ''); ?>">
            <input type="date" name="fecha_inicio" placeholder="Fecha de Inicio" value="<?php echo htmlspecialchars($data['fecha_inicio'] ?? ''); ?>">
            <input type="date" name="fecha_final" placeholder="Fecha de Finalización" value="<?php echo htmlspecialchars($data['fecha_final'] ?? ''); ?>">
            <label for="visible">Visible</label>
            <input type="checkbox" name="visible" <?php echo isset($data['visible']) && $data['visible'] ? 'checked' : ''; ?>>
            <br><br>
            <button type="submit">Guardar Cambios</button>
        </form>
</body>
</html>