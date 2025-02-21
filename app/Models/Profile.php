<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Profile extends DBAbstractModel {
    private static $instancia;

    public static function getInstancia() {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone() {
        trigger_error('La clonación no es permitida.', E_USER_ERROR);
    }

    private $id;
    private $nombre;
    private $apellidos;
    private $foto;
    private $categoria_profesional;
    private $email;
    private $resumen_perfil;
    private $password;
    private $visible;
    private $created_at;
    private $updated_at;
    private $token;
    private $fecha_creacion_token;
    private $cuenta_activa;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function setCategoriaProfesional($categoria_profesional) {
        $this->categoria_profesional = $categoria_profesional;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setResumenPerfil($resumen_perfil) {
        $this->resumen_perfil = $resumen_perfil;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function setFechaCreacionToken($fecha_creacion_token) {
        $this->fecha_creacion_token = $fecha_creacion_token;
    }

    public function setCuentaActiva($cuenta_activa) {
        $this->cuenta_activa = $cuenta_activa;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function set() {
        $fecha = new \DateTime();
        $this->query = "INSERT INTO usuarios (nombre, apellidos, foto, categoria_profesional, email, resumen_perfil, password, token, fecha_creacion_token, cuenta_activa) VALUES (:nombre, :apellidos, :foto, :categoria_profesional, :email, :resumen_perfil, :password, :token, :fecha_creacion_token, :cuenta_activa)";
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['categoria_profesional'] = $this->categoria_profesional;
        $this->parametros['email'] = $this->email;
        $this->parametros['resumen_perfil'] = $this->resumen_perfil;
        $this->parametros['password'] = $this->password;
        $this->parametros['token'] = $this->token;
        $this->parametros['fecha_creacion_token'] = $this->fecha_creacion_token;
        $this->parametros['cuenta_activa'] = $this->cuenta_activa;
        $this->get_results_from_query();
        $this->mensaje = 'Perfil añadido';
    }

    public function get($nombre = '') {
        $nombre = strtolower($nombre);
        $nombre = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'],
            ['a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u'],
            $nombre
        );
        $this->query = "SELECT * FROM usuarios WHERE LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(nombre, 'á', 'a'), 'é', 'e'), 'í', 'i'), 'ó', 'o'), 'ú', 'u')) LIKE :nombre";
        $this->parametros['nombre'] = "%$nombre%";
        $this->get_results_from_query();
        
        if (count($this->rows) > 0) {
            return $this->rows;
        } else {
            $this->mensaje = 'Perfil no encontrado';
            return null;
        }
    }

    public function getByEmail($email) {
        $this->query = "SELECT * FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        
        if (count($this->rows) == 1) {
            return $this->rows[0];
        } else {
            $this->mensaje = 'Perfil no encontrado';
            return null;
        }
    }

    public function verifyLogin($email, $password) {
        $this->query = "SELECT * FROM usuarios WHERE email = :email";
        $this->parametros['email'] = $email;
        $this->get_results_from_query();
        
        if (count($this->rows) == 1) {
            $usuario = $this->rows[0];
            if (password_verify($password, $usuario['password'])) {
                return $usuario;
            }
        }
        return null;
    }

    public function getAll() {
        $this->query = "SELECT * FROM usuarios";
        $this->get_results_from_query();
        return $this->rows;
    }


    public function getActiveProfiles() {
        $this->query = "SELECT * FROM usuarios WHERE cuenta_activa = 1";
        $this->get_results_from_query();
        return $this->rows;
    }



    public function getNombre(){
        return $this->nombre;
    }

    public function edit($id = '') {
        $fecha = new \DateTime();
        $this->query = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, foto = :foto, categoria_profesional = :categoria_profesional, email = :email, resumen_perfil = :resumen_perfil, password = :password, visible = :visible, updated_at = :updated_at, token = :token, fecha_creacion_token = :fecha_creacion_token, cuenta_activa = :cuenta_activa WHERE id = :id";
        $this->parametros['id'] = $this->id;
        $this->parametros['nombre'] = $this->nombre;
        $this->parametros['apellidos'] = $this->apellidos;
        $this->parametros['foto'] = $this->foto;
        $this->parametros['categoria_profesional'] = $this->categoria_profesional;
        $this->parametros['email'] = $this->email;
        $this->parametros['resumen_perfil'] = $this->resumen_perfil;
        $this->parametros['password'] = $this->password;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['updated_at'] = date('Y-m-d H:i:s', $fecha->getTimestamp());
        $this->parametros['token'] = $this->token;
        $this->parametros['fecha_creacion_token'] = $this->fecha_creacion_token;
        $this->parametros['cuenta_activa'] = $this->cuenta_activa;
        $this->get_results_from_query();
        $this->mensaje = 'Perfil modificado'; 
    }

    public function delete($id = '') {
        $this->query = "DELETE FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        $this->mensaje = 'Perfil eliminado';
    }

    public function getUserById($id = '') {
        $this->query = "SELECT * FROM usuarios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
}

?>