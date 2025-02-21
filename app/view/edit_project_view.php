<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Proyecto</title>
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
        <h1>Editar Proyecto</h1>
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <span>Titulo: </span>
            <input type="text" name="titulo" placeholder="Título del Proyecto" value="<?php echo $data['proyecto'][0]['titulo'] ?>">
            <span>Descripción: </span>
            <textarea name="descripcion" placeholder="Descripción del Proyecto"><?php echo $data['proyecto'][0]['descripcion'] ?></textarea>
            <span>Tecnologías: </span>
            <input type="text" name="tecnologias" placeholder="Tecnologías utilizadas" value="<?php echo $data['proyecto'][0]['tecnologias'] ?>">
            <span>Logo: </span>
            <input type="file" name="logo">
          
        <button type="submit" >Guardar Cambios</button>
        </form>
    </div>
</body>
</html>