<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Habilidad</title>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>/css/style.css">
    <style>
        .errors {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h1>Agregar Habilidad</h1>
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="../create-skill">
            <input type="text" name="habilidades" placeholder="Habilidad" value="<?php echo isset($habilidades) ? htmlspecialchars($habilidades) : ''; ?>">
            <label for="visible">Visible</label>
            <input type="checkbox" name="visible" <?php echo isset($visible) && $visible ? 'checked' : ''; ?>>
            <button type="submit">Agregar Habilidad</button>
        </form>
    </div>
</body>
</html>
