<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Portfolio extends DBAbstractModel
{
    private static $instancia;

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            $miclase = __CLASS__;
            self::$instancia = new $miclase;
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('La clonación no es permitida.', E_USER_ERROR);
    }


    public function edit(){}

    public function delete(){}


    // Método para obtener el portfolio por ID de usuario
    public function getPortfolioByUserId($user_id)
    {


        // Obtener datos de la tabla proyectos
        $this->query = "SELECT * FROM proyectos WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $proyectos = $this->rows;

        // Obtener datos de la tabla redes_sociales (datos: id, redes_sociales, url)
        $this->query = "SELECT * FROM redes_sociales WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $redes_sociales = $this->rows;

        // Obtener datos de la tabla skills
        $this->query = "SELECT * FROM skills WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $skills = $this->rows;

        // Obtener datos de la tabla trabajos
        $this->query = "SELECT * FROM trabajos WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $trabajos = $this->rows;

        return [
            'proyectos' => $proyectos,
            'redes_sociales' => $redes_sociales,
            'skills' => $skills,
            'trabajos' => $trabajos,
            'usuario_id' => $user_id
        ];
    }

    // Método para obtener un portfolio por ID
    public function get($id = '')
    {
        $this->query = "SELECT * FROM portfolios WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para establecer los valores de las propiedades
    public function set($data = array())
    {
        foreach ($data as $campo => $valor) {
            $this->$campo = $valor;
        }
    }

    // public function getProjectById($id)
    // {
    //     $this->query = "SELECT * FROM proyectos WHERE id = :id OR usuarios_id = :usuarios_id";
    //     $this->parametros['usuarios_id'] = $id;
    //     $this->parametros['id'] = $id;
    //     $this->get_results_from_query();
    //     return $this->rows;
    // }

    // public function getRedSocialById($id)
    // {
    //     $this->query = "SELECT * FROM redes_sociales WHERE usuarios_id = :usuarios_id";
    //     $this->parametros['usuarios_id'] = $id;
    //     $this->get_results_from_query();
    //     return $this->rows;
    // }


    // // Método para obtener el usuario por ID
    // public function getUserById($user_id)
    // {
    //     $this->query = "SELECT foto FROM usuarios WHERE id = :id";
    //     $this->parametros['id'] = $user_id;
    //     $this->get_results_from_query();
    //     return $this->rows[0];
    // }
}
