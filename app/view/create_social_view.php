<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Red Social</title>
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
        <h1>Agregar Red Social</h1>
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="../create-social">
            <input type="text" name="red_social" placeholder="Red Social" value="<?php echo isset($red_social) ? htmlspecialchars($red_social) : ''; ?>">
            <input type="url" name="url" placeholder="URL" value="<?php echo isset($url) ? htmlspecialchars($url) : ''; ?>">
            <button type="submit">Agregar Red Social</button>
        </form>
    </div>
</body>
</html>