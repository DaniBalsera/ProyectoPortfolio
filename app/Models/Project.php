<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Project extends DBAbstractModel
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

    /** Creo los parametros */

    private $titulo;
    private $descripcion;
    private $logo;
    private $tecnologias;
    private $usuarios_id;
    private $created_at;
    private $updated_at;
    private $visible;
    private $id;

    // Metodos setters y getters

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setTecnologias($tecnologias)
    {
        $this->tecnologias = $tecnologias;
    }

    public function getTecnologias()
    {
        return $this->tecnologias;
    }

    public function setUsuariosId($usuarios_id)
    {
        $this->usuarios_id = $usuarios_id;
    }

    public function getUsuariosId()
    {
        return $this->usuarios_id;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    // Creamelo pal id

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    // Método para crear un proyecto basado en el DBAbstractModel

    public function set()
    {
        $this->query = "INSERT INTO proyectos (titulo, descripcion, logo, tecnologias, usuarios_id, created_at, updated_at, visible) VALUES (:titulo, :descripcion, :logo, :tecnologias, :usuarios_id, :created_at, :updated_at, :visible)";

        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['logo'] = $this->logo;
        $this->parametros['tecnologias'] = $this->tecnologias;
        $this->parametros['usuarios_id'] = $this->usuarios_id;
        $this->parametros['created_at'] = $this->created_at;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['visible'] = $this->visible;
        $this->get_results_from_query();
    }



    //Implementame el metodo edit del dbabstractmodel

    public function edit()
    {
        $this->query = "UPDATE proyectos SET titulo = :titulo, descripcion = :descripcion, logo = :logo, tecnologias = :tecnologias, updated_at = :updated_at WHERE id = :id";

        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['logo'] = $this->logo;
        $this->parametros['tecnologias'] = $this->tecnologias;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['id'] = $this->id;
        $this->get_results_from_query();
    }

    // Método para editar un proyecto

    // public function edit($id, $titulo, $descripcion, $logoPath, $tecnologias)
    // {
    //     // Construcción de la consulta
    //     $this->query = "UPDATE proyectos SET titulo = :titulo, descripcion = :descripcion, tecnologias = :tecnologias";
    //     $this->parametros = [
    //         'titulo' => $titulo,
    //         'descripcion' => $descripcion,
    //         'tecnologias' => $tecnologias,
    //         'id' => $id
    //     ];
    //     // Solo agregar el logo si se subió uno nuevo
    //     if ($logoPath) {
    //         $this->query .= ", logo = :logo";
    //         $this->parametros['logo'] = $logoPath;
    //     }
    //     // Agregar la cláusula WHERE correctamente
    //     $this->query .= " WHERE id = :id";

    //     // Ejecutar la consulta
    //     $this->execute_single_query();
    // }


    // Método para obtener el portfolio por ID de usuario
    public function getPortfolioByUserId($user_id)
    {


        // Obtener datos de la tabla proyectos
        $this->query = "SELECT id AS id_p, titulo AS proyecto_titulo, descripcion AS proyecto_descripcion, logo AS proyecto_logo, tecnologias AS proyecto_tecnologias FROM proyectos WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $proyectos = $this->rows;

        // Obtener datos de la tabla redes_sociales (datos: id, redes_sociales, url)
        $this->query = "SELECT id AS id_s, redes_sociales, url FROM redes_sociales WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $redes_sociales = $this->rows;

        // Obtener datos de la tabla skills
        $this->query = "SELECT habilidades FROM skills WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $skills = $this->rows;

        // Obtener datos de la tabla trabajos
        $this->query = "SELECT titulo AS trabajo_titulo, descripcion AS trabajo_descripcion, fecha_inicio AS trabajo_fecha_inicio, fecha_final AS trabajo_fecha_final FROM trabajos WHERE usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $user_id;
        $this->get_results_from_query();
        $trabajos = $this->rows;

        return [
            'proyectos' => $proyectos,
            'redes_sociales' => $redes_sociales,
            'skills' => $skills,
            'trabajos' => $trabajos
        ];
    }


    // Funcion para eliminar

    public function delete($id = '')
    {
        $this->query = "DELETE FROM proyectos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
    }



    // Método para obtener un portfolio por ID
    public function get($id = '')
    {
        $this->query = "SELECT * FROM proyectos WHERE id = :id OR usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $id;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }



}
