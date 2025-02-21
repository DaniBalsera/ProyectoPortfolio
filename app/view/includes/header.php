<!-- filepath: /c:/xampp/htdocs/DWES/UD6/portfolioDaniel/app/view/includes/header.php -->
<?php
// Iniciar sesión si no está iniciada aún
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <h1>Portfolios y Perfiles</h1>
</header>

<nav>
    <ul>
        <?php if (isset($_SESSION['id'])): ?>
            <li><a href="/welcome">Perfil</a></li>
            <li><a href="/">Home</a></li>
            <li><a href="/logout">Cerrar Sesión</a></li>
            <li class="header-profile">
                <img src="<?php echo htmlspecialchars($_SESSION['foto']); ?>" alt="Foto de perfil">
                <h4><?php echo htmlspecialchars($_SESSION['nombre']); ?></h4>
            </li>
        <?php else: ?>
            <li><a href="/login/user">Inicio Sesión</a></li>
            <li><a href="/">Home</a></li>
            <li><a href="/register/user">Registrarse</a></li>
        <?php endif; ?>
    </ul>
</nav>