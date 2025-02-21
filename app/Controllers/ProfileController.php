<?php

namespace App\Controllers;

use App\Models\Profile;
use App\Models\Portfolio;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Exception;

class ProfileController extends BaseController
{
    public function IndexAction()
    {
        $perfil = Profile::getInstancia();
        $data['profiles'] = $perfil->getActiveProfiles();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
            $nombre = trim($_POST['nombre']);
            $data['profiles'] = $perfil->get($nombre);
        }

        $this->renderHTML('../app/view/public_view.php', $data);
    }

    public function showRegisterForm()
    {
        $this->renderHTML('../app/view/register_view.php');
    }

    public function register()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $apellidos = trim($_POST['apellidos'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $categoria_profesional = trim($_POST['categoria_profesional'] ?? '');
            $resumen_perfil = trim($_POST['resumen_perfil'] ?? '');
            $foto = $_FILES['foto'] ?? null;

            // Validaciones
            if (empty($nombre)) $errors[] = "El nombre es obligatorio.";
            if (empty($apellidos)) $errors[] = "Los apellidos son obligatorios.";
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "El email no es válido.";
            if (empty($password)) $errors[] = "La contraseña es obligatoria.";
            if (empty($categoria_profesional)) $errors[] = "La categoría profesional es obligatoria.";
            if (empty($resumen_perfil)) $errors[] = "El resumen del perfil es obligatorio.";
            if (!$foto || $foto['error'] !== UPLOAD_ERR_OK) $errors[] = "La foto es obligatoria.";

            if (empty($errors)) {
                $uploadDir = '../public/uploads/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                // Asegurar que el nombre del archivo sea único
                $fotoName = time() . '_' . basename($foto['name']);
                $fotoPath = $uploadDir . $fotoName;

                if (!move_uploaded_file($foto['tmp_name'], $fotoPath)) {
                    $errors[] = "Error al subir la foto.";
                } else {
                    $token = uniqid('', true) . base64_encode(random_bytes(32));
                    $fecha_creacion_token = date('Y-m-d H:i:s');
                    $cuenta_activa = 0;

                    $perfil = Profile::getInstancia();
                    $perfil->setNombre($nombre);
                    $perfil->setApellidos($apellidos);
                    $perfil->setEmail($email);
                    $perfil->setPassword(password_hash($password, PASSWORD_BCRYPT));
                    $perfil->setCategoriaProfesional($categoria_profesional);
                    $perfil->setResumenPerfil($resumen_perfil);
                    $perfil->setFoto('/uploads/' . $fotoName);
                    $perfil->setToken($token);
                    $perfil->setFechaCreacionToken($fecha_creacion_token);
                    $perfil->setCuentaActiva($cuenta_activa);
                    $perfil->set();

                    session_start();
                    $_SESSION['id'] = $perfil->getId();
                    $_SESSION['nombre'] = $nombre;
                    header('Location: /');
                    exit();
                }
            }

            $this->renderHTML('../app/view/register_view.php', ['errors' => $errors]);
        }
    }

    public function showLoginForm()
    {
        $this->renderHTML('../app/view/login_view.php');
    }

    public function welcomePage()
    {

         $portfolio = null;

         if (isset($_SESSION['id'])) {
            $portfolioModel = Portfolio::getInstancia();
            $portfolio = $portfolioModel->getPortfolioByUserId($_SESSION['id']);
            $portfolio['nombre'] = $_SESSION['nombre'];
         }

        $this->renderHTML('../app/view/welcome_view.php', ['portfolio' => $portfolio]);
    }

    public function showPortfolios($userId)
    {

       $portfolio = [];
       $user_id = explode('/', $_SERVER['REQUEST_URI'])[3];
       $portfolioModel = Portfolio::getInstancia();
       $portfolio = $portfolioModel->getPortfolioByUserId($user_id);
       /** Obtener el nombre del usuario */
        $perfil = Profile::getInstancia();
        $usuario = $perfil->getUserById($user_id);
        $portfolio['nombre'] = $usuario[0]['nombre'];
       if(empty($portfolio)) {
           die("Error: Portafolio no encontrado.");
       }
       
         $this->renderHTML('../app/view/welcome_view.php', ['portfolio' => $portfolio]);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $this->renderHTML('../app/view/login_view.php', ['error' => "Por favor, complete todos los campos."]);
                return;
            }

            $perfil = Profile::getInstancia();
            $usuario = $perfil->verifyLogin($email, $password);

            if ($usuario) {
                session_start();
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['email'] = $email;
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['foto'] = $usuario['foto'];
                header('Location: /welcome');
                exit();
            } else {
                $this->renderHTML('../app/view/login_view.php', ['error' => "Correo electrónico o contraseña incorrectos, o cuenta no activada."]);
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login/user');
        exit();
    }
}
