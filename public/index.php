<?php
session_start();
require_once("../boostrap.php");
require_once("../vendor/autoload.php");
require_once("../app/Controllers/ProfileController.php");
require_once("../app/Controllers/PortfolioController.php");

use App\Controllers\JobController;
use App\Core\Router;
use App\Controllers\ProfileController;
use App\Controllers\PortfolioController;
use App\Controllers\ProjectController;
use App\Controllers\SkillsController;
use App\Controllers\SocialController;

$router = new Router();

$router->add(array(
    "name" => "primera",
    'path' => '/^\/$/',
    'action' => [ProfileController::class, 'IndexAction']
));

$router->add(array(
    "name" => "showRegisterForm",
    'path' => '/^\/register\/user$/',
    'action' => [ProfileController::class, 'showRegisterForm']
));

$router->add(array(
    "name" => "register",
    'path' => '/^\/register$/',
    'action' => [ProfileController::class, 'register']
));

$router->add(array(
    "name" => "showLoginForm",
    'path' => '/^\/login\/user$/',
    'action' => [ProfileController::class, 'showLoginForm']
));

$router->add(array(
    "name" => "login",
    'path' => '/^\/login$/',
    'action' => [ProfileController::class, 'login']
));

$router->add(array(
    "name" => "welcome",
    'path' => '/^\/welcome$/',
    'action' => [ProfileController::class, 'welcomePage']
));

$router->add(array(
    "name" => "logout",
    'path' => '/^\/logout$/',
    'action' => [ProfileController::class, 'logout']
));




// Rutas para los proyectos

$router->add(array(
    "name" => "create-project",
    'path' => '/^\/proyecto\/crear$/',
    'action' => [ProjectController::class, 'showCreateProjectForm']
));

$router->add(array(
    "name" => "create-project-post",
    'path' => '/^\/create-project$/',
    'action' => [ProjectController::class, 'createProject']
));

$router->add(array(
    "name" => "edit-project",
    'path' => '/^\/proyecto\/editar\/\d+$/',
    'action' => [ProjectController::class, 'EditProjectForm']
));

$router->add(array(
    "name" => "delete-project",
    'path' => '/^\/proyecto\/eliminar\/\d+$/',
    'action' => [ProjectController::class, 'deleteProject']
));



// Rutas para las redes sociales

$router->add(array(
    "name" => "create-social",
    'path' => '/^\/social\/crear$/',
    'action' => [SocialController::class, 'showCreateSocialForm']
));

$router->add(array(
    "name" => "create-social-post",
    'path' => '/^\/create-social$/',
    'action' => [SocialController::class, 'createSocial']
));

$router->add(array(
    "name" => "edit-social",
    'path' => '/^\/social\/editar\/\d+$/',
    'action' => [SocialController::class, 'EditSocialForm']
));

$router->add(array(
    "name" => "delete-social",
    'path' => '/^\/social\/eliminar\/\d+$/',
    'action' => [SocialController::class, 'deleteSocial']
));

// Rutas para los skills

$router->add(array(
    "name" => "create-skill",
    'path' => '/^\/skill\/crear$/',
    'action' => [SkillsController::class, 'showCreateSkillsForm']
));

$router->add(array(
    "name" => "create-skill-post",
    'path' => '/^\/create-skill$/',
    'action' => [SkillsController::class, 'createSkills']
));

$router->add(array(
    "name" => "delete-skill",
    'path' => '/^\/skill\/eliminar\/\d+$/',
    'action' => [SkillsController::class, 'deleteSkills']
));


// Rutas para los trabajos

$router->add(array(
    "name" => "create-job",
    'path' => '/^\/trabajo\/crear$/',
    'action' => [JobController::class, 'showCreateJobForm']
));

$router->add(array(
    "name" => "create-job-post",
    'path' => '/^\/create-job$/',
    'action' => [JobController::class, 'createJob']
));

$router->add(array(
    "name" => "edit-job",
    'path' => '/^\/trabajo\/editar\/\d+$/',
    'action' => [JobController::class, 'editJobForm']
));

$router->add(array(
    "name" => "delete-job",
    'path' => '/^\/trabajo\/eliminar\/\d+$/',
    'action' => [JobController::class, 'deleteJob']
));

// Rutas para ver el portfolio de un usuario

$router->add(array(
    "name" => "portfolio",
    'path' => '/^\/portfolio\/view\/\d+$/',
    'action' => [ProfileController::class, 'showPortfolios']
));

$request = $_SERVER['REQUEST_URI'];
$route = $router->match($request);

if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
} else {
    echo "No route";
}

?>