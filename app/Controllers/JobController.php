<?php

namespace App\Controllers;


use App\Models\Jobs;

class JobController extends BaseController
{

    public function showCreateJobForm()
    {
        $this->renderHTML('../app/view/create_job_view.php');
    }

    public function createJob()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['id']; // Obtenemos el ID del usuario de la sesión
            $titulo = trim($_POST['titulo']);
            $descripcion = trim($_POST['descripcion']);
            $fecha_inicio = trim($_POST['fecha_inicio']);
            $fecha_final = trim($_POST['fecha_final']);
            $logros = trim($_POST['logros']);

            // Validaciones

            if (empty($titulo)) {
                $errors[] = "El título del trabajo es obligatorio.";
                $this->renderHTML('../app/view/create_job_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'fecha_inicio' => $fecha_inicio, 'fecha_final' => $fecha_final, 'logros' => $logros]);
                return;
            }

            if (empty($descripcion)) {
                $errors[] = "La descripción del trabajo es obligatoria.";
                $this->renderHTML('../app/view/create_job_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'fecha_inicio' => $fecha_inicio, 'fecha_final' => $fecha_final, 'logros' => $logros]);
                return;
            }

            if (empty($fecha_inicio)) {
                $errors[] = "La fecha de inicio del trabajo es obligatoria.";
                $this->renderHTML('../app/view/create_job_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'fecha_inicio' => $fecha_inicio, 'fecha_final' => $fecha_final, 'logros' => $logros]);
                return;
            }

            if (empty($fecha_final)) {
                $errors[] = "La fecha final del trabajo es obligatoria.";
                $this->renderHTML('../app/view/create_job_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'fecha_inicio' => $fecha_inicio, 'fecha_final' => $fecha_final, 'logros' => $logros]);
                return;
            }

            if (empty($logros)) {
                $errors[] = "Los logros del trabajo son obligatorios.";
                $this->renderHTML('../app/view/create_job_view.php', ['errors' => $errors, 'titulo' => $titulo, 'descripcion' => $descripcion, 'fecha_inicio' => $fecha_inicio, 'fecha_final' => $fecha_final, 'logros' => $logros]);
                return;
            }

            if (empty($errors)) {
                $jobs = Jobs::getInstancia();
                $jobs->setTitulo($titulo);
                $jobs->setDescripcion($descripcion);
                $jobs->setFechaInicio($fecha_inicio);
                $jobs->setFechaFinal($fecha_final);
                $jobs->setLogros($logros);
                $jobs->setUsuariosId($user_id);
                $jobs->set();
                header('Location: /welcome');
                exit();
            }
        }
    }

    public function editJobForm()
    {
        if (empty($_SESSION['id'])) {
            header("Location: /");
            exit;
        }

        $job = Jobs::getInstancia();
        $jobId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $data['job'] = $job->getJobById($jobId);

        if (empty($data['job'][0])) {
            die("Error: Trabajo no encontrado.");
        }

        $data['titulo'] = $data['job'][0]['titulo'] ?? '';
        $data['descripcion'] = $data['job'][0]['descripcion'] ?? '';
        $data['fecha_inicio'] = $data['job'][0]['fecha_inicio'] ?? '';
        $data['fecha_final'] = $data['job'][0]['fecha_final'] ?? '';
        $data['logros'] = $data['job'][0]['logros'] ?? '';
        $data['visible'] = $data['job'][0]['visible'] ?? '';
        $data['errors'] = [];
        $userId = $_SESSION['id'];

        $procesaForm = false;

        if (!empty($_POST)) {
            $procesaForm = true;
            $titulo = trim($_POST['titulo']);
            $descripcion = trim($_POST['descripcion']);
            $fecha_inicio = trim($_POST['fecha_inicio']);
            $fecha_final = trim($_POST['fecha_final']);
            $logros = trim($_POST['logros']);
            $visible = isset($_POST['visible']) ? 1 : 0;

            if (empty($titulo)) {
                $data['errors'][] = "El título del trabajo es obligatorio.";
            }

            if (empty($descripcion)) {
                $data['errors'][] = "La descripción del trabajo es obligatoria.";
            }

            if (empty($fecha_inicio)) {
                $data['errors'][] = "La fecha de inicio del trabajo es obligatoria.";
            }

            if (empty($fecha_final)) {
                $data['errors'][] = "La fecha final del trabajo es obligatoria.";
            }

            if (empty($logros)) {
                $data['errors'][] = "Los logros del trabajo son obligatorios.";
            }

            if ($procesaForm) {
                $job->setTitulo($titulo);
                $job->setDescripcion($descripcion);
                $job->setFechaInicio($fecha_inicio);
                $job->setFechaFinal($fecha_final);
                $job->setLogros($logros);
                $job->setVisible($visible);
                $job->setUsuariosId($userId);
                $job->edit($jobId);
                header('Location: /welcome');
                exit();
            }
        } else {
            $this->renderHTML('../app/view/edit_job_view.php', $data);
        }
    }

    public function deleteJob()
    {
        if (empty($_SESSION['id'])) {
            header("Location: /");
            exit;
        }

        $job = Jobs::getInstancia();
        $jobId = explode('/', $_SERVER['REQUEST_URI'])[3];
        $job->delete($jobId);
        header('Location: /welcome');
        exit();
    }
}
