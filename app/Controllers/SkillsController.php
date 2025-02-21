<?php

namespace App\Controllers;

use App\Models\Skills;

class SkillsController extends BaseController
{
    // Mostrar formulario para crear habilidades
    public function showCreateSkillsForm()
    {
        $this->renderHTML('../app/view/create_skill_view.php');
    }

    // Crear una nueva habilidad
    public function createSkills()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user_id = $_SESSION['id']; // Obtenemos el ID del usuario de la sesión
            $habilidades = trim($_POST['habilidades']);
            $visible = $_POST['visible'] ?? 0;

            // Validaciones
            if (empty($habilidades)) {
                $errors[] = "El nombre de la habilidad es obligatorio.";
                $this->renderHTML('../app/view/create_skill_view.php', ['errors' => $errors, 'habilidades' => $habilidades]);
                return;
            }

            if (empty($errors)) {
                $skills = Skills::getInstancia();
                $skills->setHabilidades($habilidades);
                $skills->setVisible($visible);
                $skills->setUsuariosId($user_id);
                $skills->set();
                header('Location: /welcome');
                exit();
            }
        }
    }

    // Eliminar habilidad
    public function deleteSkills()
    {
        session_start();
        $skills = Skills::getInstancia();
        $skillId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $skills->delete($skillId);
        header('Location: /welcome');
        exit();
    }
}
?>
