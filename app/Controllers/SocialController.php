<?php

namespace App\Controllers;

use App\Models\RedSocial;

class SocialController extends BaseController
{
    public function showCreateSocialForm()
    {
        $this->renderHTML('../app/view/create_social_view.php');
    }

    public function createSocial()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {           
            $user_id = $_SESSION['id']; // Obtenemos el ID del usuario de la sesión
            $red_social = trim($_POST['red_social']);
            $url = trim($_POST['url']);

            // Validaciones

            if (empty($red_social)) {
                $errors[] = "El nombre de la red social es obligatorio.";
                $this->renderHTML('../app/view/create_social_view.php', ['errors' => $errors, 'red_social' => $red_social, 'url' => $url]);
                return;
            }

            if (empty($url)) {
                $errors[] = "La URL es obligatoria.";
                $this->renderHTML('../app/view/create_social_view.php', ['errors' => $errors, 'red_social' => $red_social, 'url' => $url]);
                return;
            }

            if (empty($errors)) {
                $redes_sociales = RedSocial::getInstancia();
                $redes_sociales->setUrl($url);
                $redes_sociales->setRedesSociales($red_social);
                $redes_sociales->setUsuariosId($user_id);
                $redes_sociales->set();
                header('Location: /welcome');
                exit();
            }
        }
    }


    public function EditSocialForm()
    {
        if (empty($_SESSION['id'])) {
            header("Location: /");
            exit;
        }
    
        $redSocial = RedSocial::getInstancia();
        $socialId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $data['redSocial'] = $redSocial-> getRedSocialById($socialId);
    
        if (empty($data['redSocial'][0])) {
            die("Error: Red social no encontrada.");
        }
    
        $data['redes_sociales'] = $data['redSocial'][0]['redes_sociales'] ?? '';
        $data['url'] = $data['redSocial'][0]['url'] ?? '';
        $data['msjErrorRedSocial'] = $data['msjErrorURL'] = '';
        $data['errors'] = [];  // Añadir la clave para errores
        $userId = $_SESSION['id'];
        $procesaForm = false;
    
        if (!empty($_POST)) {
            $procesaForm = true;
    
            // Obtener datos del formulario con validación y sanitización
            $redes_sociales = filter_input(INPUT_POST, 'red_social', FILTER_SANITIZE_STRING);
            $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
    
            // Validaciones
            if (empty($redes_sociales)) {
                $data['redes_sociales'] = $data['redSocial'][0]['redes_sociales'];
            } elseif (strlen($redes_sociales) > 64) {
                $data['msjErrorRedSocial'] = "El nombre de la red social no puede sobrepasar los 128 caracteres.";
                $data['errors'][] = $data['msjErrorRedSocial']; // Añadir el error
                $procesaForm = false;
            }
    
            if (empty($url)) {
                $data['url'] = $data['redSocial'][0]['url'];
            } elseif (!filter_var($url, FILTER_VALIDATE_URL) || strlen($url) > 256) {
                $data['msjErrorURL'] = "La URL no es válida o sobrepasa el límite de 256 caracteres.";
                $data['errors'][] = $data['msjErrorURL']; // Añadir el error
                $procesaForm = false;
            }
        }
    
        if ($procesaForm) {
            $redSocial->setRedesSociales($redes_sociales);
            $redSocial->setUrl($url);
            $redSocial->setUpdatedAt(date('Y-m-d H:i:s'));
            $redSocial->setId($socialId);
            $redSocial->setUsuariosId($userId);
            $redSocial->edit($socialId);
            header('Location: /welcome');
            exit();
        } else {
            $this->renderHTML('../app/view/edit_social_view.php', $data);
        }
    }

    public function deleteSocial()
    {
        session_start();
        $red_social = RedSocial::getInstancia();
        $socialId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $red_social->delete($socialId);
        header('Location: /welcome');
        exit();
    }
    
}
