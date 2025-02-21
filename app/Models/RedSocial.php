<?php

namespace App\Models;

require_once('DBAbstractModel.php');

class RedSocial extends DBAbstractModel
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

    /**Creo los parametros */

    private $redes_sociales;
    private $url;
    private $usuarios_id;
    private $created_at;
    private $updated_at;
    private $id;

    // Metodos setters y getters

    public function setRedesSociales($redes_sociales)
    {
        $this->redes_sociales = $redes_sociales;
    }

    public function getRedesSociales()
    {
        return $this->redes_sociales;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    // Método para crear una red social


    public function set()
    {
        $this->query = "INSERT INTO redes_sociales (redes_sociales, url, created_at, updated_at, usuarios_id) 
                     VALUES (:redes_sociales, :url, :created_at, :updated_at, :usuarios_id)";

        $this->parametros['redes_sociales'] = $this->redes_sociales;
        $this->parametros['url'] = $this->url;
        $this->parametros['created_at'] = $this->created_at;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['usuarios_id'] = $this->usuarios_id;

        $this->get_results_from_query();
    }

    // Método para editar una red social

    public function edit($id = '')
    {
        $this->query = "UPDATE redes_sociales 
                     SET redes_sociales = :redes_sociales, url = :url, updated_at = :updated_at 
                     WHERE id = :id";

        $this->parametros['redes_sociales'] = $this->redes_sociales;
        $this->parametros['url'] = $this->url;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['id'] = $id;
        $this->parametros['usuarios_id'] = $this->usuarios_id;

        $this->get_results_from_query();
    }

    // Método para eliminar una red social

    public function delete($id = '')
    {
        $this->query = "DELETE FROM redes_sociales WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
    }




    // Método para obtener una red social por ID
    public function getRedSocialById($id)
    {
        $this->query = "SELECT * FROM redes_sociales WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

    // Método para obtener un portfolio por ID
    public function get($id = '')
    {
        $this->query = "SELECT * FROM redes_sociales WHERE id = :id OR usuarios_id = :usuarios_id";
        $this->parametros['usuarios_id'] = $id;
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }
}
