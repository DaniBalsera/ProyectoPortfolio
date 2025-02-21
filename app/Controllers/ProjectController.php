<?php
// Controlador para el projecto

namespace App\Controllers;

use App\Models\Project;

class ProjectController extends BaseController
{


    public function showCreateProjectForm()
    {
        $this->renderHTML('../app/view/create_project_view.php');
    }


    public function createProject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['id']; // Obtenemos el ID del usuario de la sesión
            $titulo = trim($_POST['titulo']);
            $descripcion = trim($_POST['descripcion']);
            $tecnologias = trim($_POST['tecnologias']);
            $logo = $_FILES['logo'];

            // Validaciones
            if (empty($titulo)) {
                $errors[] = "El título es obligatorio.";
                $this->renderHTML('../app/view/create_project_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'tecnologias' => $tecnologias]);
                return;
            }
            if (empty($descripcion)) {
                $errors[] = "La descripción es obligatoria.";
                $this->renderHTML('../app/view/create_project_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'tecnologias' => $tecnologias]);
                return;
            }
            if (empty($tecnologias)) {
                $errors[] = "Las tecnologías son obligatorias.";
                $this->renderHTML('../app/view/create_project_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'tecnologias' => $tecnologias]);
                return;
            }
            if ($logo['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "El logo es obligatorio.";
                $this->renderHTML('../app/view/create_project_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'tecnologias' => $tecnologias]);
                return;
            }

            if (empty($errors)) {
                // Manejar la carga del logo
                $logoPath = '/uploads/' . basename($logo['name']);
                $targetFilePath = __DIR__ . '/../../public' . $logoPath;

                if (!move_uploaded_file($logo['tmp_name'], $targetFilePath)) {
                    $errors[] = "Error al subir el logo.";
                    $this->renderHTML('../app/view/create_project_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'tecnologias' => $tecnologias]);
                    return;
                }

                // Guardar el proyecto en la base de datos
                $portfolio = Project::getInstancia();
                $portfolio->setTitulo($titulo);
                $portfolio->setDescripcion($descripcion);
                $portfolio->setLogo($logoPath);
                $portfolio->setTecnologias($tecnologias);
                $portfolio->setUsuariosId($user_id);

                $portfolio->set();
                // Redirigir al welcome view
                header('Location: /welcome');
                exit();
            }
        }
    }


    // Editar proyecto
    public function EditProjectForm()
    {
        if (empty($_SESSION['id'])) {
            header("Location: /");
            exit;
        }

        $proyecto = Project::getInstancia();
        $proyectoId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $data['proyecto'] = $proyecto->get($proyectoId);

        if (empty($data['proyecto'][0])) {
            die("Error: Proyecto no encontrado.");
        }

        $data['titulo'] = $data['proyecto'][0]['titulo'] ?? '';
        $data['descripcion'] = $data['proyecto'][0]['descripcion'] ?? '';
        $data['tecnologias'] = $data['proyecto'][0]['tecnologias'] ?? '';
        $data['logoPath'] = $data['proyecto'][0]['logo'] ?? '';

        $data['msjErrorTitulo'] = $data['msjErrorDescripcion'] = $data['msjErrorTecnologias'] = $data['msjErrorLogo'] = '';

        $procesaForm = false;

        if (!empty($_POST)) {
            $procesaForm = true;

            // Obtener datos del formulario con validación y sanitización
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
            $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
            $tecnologias = filter_input(INPUT_POST, 'tecnologias', FILTER_SANITIZE_STRING);
            $logo = $_FILES['logo'] ?? null;

            // Validaciones
            if (empty($titulo)) {
                $data['titulo'] = $data['proyecto'][0]['titulo'];
            } elseif (strlen($titulo) > 128) {
                $data['msjErrorTitulo'] = "El título no puede sobrepasar los 128 caracteres.";
                $procesaForm = false;
            }

            if (empty($descripcion)) {
                $data['descripcion'] = $data['proyecto'][0]['descripcion'];
            } elseif (strlen($descripcion) > 256) {
                $data['msjErrorDescripcion'] = "La descripción no puede sobrepasar los 256 caracteres.";
                $procesaForm = false;
            }

            if (empty($tecnologias)) {
                $data['tecnologias'] = $data['proyecto'][0]['tecnologias'];
            } elseif (strlen($tecnologias) > 256) {
                $data['msjErrorTecnologias'] = "Las tecnologías no pueden sobrepasar los 256 caracteres.";
                $procesaForm = false;
            }

            // Manejo del logo
            if (isset($_POST['logo']) && $_POST['logo'] === 'true') {
                $data['logoPath'] = $data['proyecto'][0]['logo'];
            } else {
                if ($logo && $logo['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $logo['tmp_name'];
                    $fileName = basename($logo['name']);
                    $uploadFileDir = '/uploads/';
                    $targetFilePath = __DIR__ . '/../../public' . $uploadFileDir . $fileName;

                    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                        $data['logoPath'] = $uploadFileDir . $fileName;
                    } else {
                        $data['msjErrorLogo'] = "Error al subir el logo.";
                        $procesaForm = false;
                    }
                } else {
                    $data['logoPath'] = $data['proyecto'][0]['logo'];
                }
            }
        }

        if ($procesaForm) {
            $proyecto->setTitulo($titulo);
            $proyecto->setDescripcion($descripcion);
            $proyecto->setLogo($data['logoPath']);
            $proyecto->setTecnologias($tecnologias);
            $proyecto->setId($proyectoId);
            $proyecto->edit();

            header('Location: /welcome');
            exit();
        } else {
            $this->renderHTML('../app/view/edit_project_view.php', $data);
        }
    }


    // Funcion para eliminar

    public function deleteProject()
    {
        session_start();
        $project = Project::getInstancia();
        $projectId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $project->delete($projectId);
        header('Location: /welcome');
        exit();
    }
}
