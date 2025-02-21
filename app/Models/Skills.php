<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class Skills extends DBAbstractModel
{
    private static $instancia;

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function __clone()
    {
        trigger_error('La clonación no es permitida.', E_USER_ERROR);
    }


    // Propiedades
    private $habilidades;
    private $visible;
    private $id;
    private $created_at;
    private $updated_at;
    private $categorias_skills_id;
    private $usuarios_id;

    // Métodos Setters y Getters

    public function setHabilidades($habilidades)
    {
        $this->habilidades = $habilidades;
    }

    public function getHabilidades()
    {
        return $this->habilidades;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function getVisible()
    {
        return $this->visible;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
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

    public function setCategoriasSkillsId($categorias_skills_id)
    {
        $this->categorias_skills_id = $categorias_skills_id;
    }

    public function getCategoriasSkillsId()
    {
        return $this->categorias_skills_id;
    }

    public function setUsuariosId($usuarios_id)
    {
        $this->usuarios_id = $usuarios_id;
    }

    public function getUsuariosId()
    {
        return $this->usuarios_id;
    }

    // Método para crear una habilidad
    public function set()
    {
        $this->query = "INSERT INTO skills (habilidades, visible, created_at, updated_at, visible, categorias_skills_id , usuarios_id) VALUES (:habilidades, :visible, :created_at, :updated_at, :visible, :categorias_skills_id, :usuarios_id)";
        $this->parametros['habilidades'] = $this->habilidades;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['created_at'] = $this->created_at;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['categorias_skills_id'] = $this->categorias_skills_id;
        $this->parametros['usuarios_id'] = $this->usuarios_id;
        
        $this->get_results_from_query();
    }

    // Método para editar una habilidad
    public function edit($id = '')
    {
        $this->query = "UPDATE skills 
                     SET habilidades = :habilidades, visible = :visible, updated_at = :updated_at, categorias_skills_id = :categorias_skills_id, usuarios_id = :usuarios_id
                     WHERE id = :id";

        $this->parametros['habilidades'] = $this->habilidades;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['categorias_skills_id'] = $this->categorias_skills_id;
        $this->parametros['usuarios_id'] = $this->usuarios_id;
        $this->parametros['id'] = $id;

        $this->get_results_from_query();
    }

    // Método para eliminar una habilidad
    public function delete($id = '')
    {
        $this->query = "DELETE FROM skills WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
    }

    // Método para obtener una habilidad por ID
    public function getSkillById($id)
    {
        $this->query = "SELECT * FROM skills WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para obtener todas las habilidades
    public function get($id = '')
    {
        $this->query = "SELECT * FROM skills WHERE id = :id OR usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $id;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

}
?>
