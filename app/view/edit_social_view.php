<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Red Social</title>
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
        <h1>Editar Red Social</h1>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
         <?php   var_dump($data); ?>
            <input type="text" name="red_social" id="red_social"
                
                value="<?php echo htmlspecialchars($data['redes_sociales'] ?? ''); ?>">

            <input type="url" name="url" id="url"
                value="<?php echo htmlspecialchars($data['url'] ?? ''); ?>">

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>

</body>

</html>