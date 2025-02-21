<?php
/** Modelo para los trabajos */
namespace App\Models;

require_once('DBAbstractModel.php');

class Jobs extends DBAbstractModel{

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

    /** Parametros: */

    private $titulo;
    private $descripcion;
    private $fecha_inicio;
    private $fecha_final;
    private $logros;
    private $visible;
    private $created_at;
    private $updated_at;
    private $usuarios_id;
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

    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    public function setFechaFinal($fecha_final)
    {
        $this->fecha_final = $fecha_final;
    }

    public function getFechaFinal()
    {
        return $this->fecha_final;
    }

    public function setLogros($logros)
    {
        $this->logros = $logros;
    }

    public function getLogros()
    {
        return $this->logros;
    }

    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    public function getVisible()
    {
        return $this->visible;
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

    // Metodo set basado en el DBAbstractModel

    public function set()
    {
        $this->query = "INSERT INTO trabajos (titulo, descripcion, fecha_inicio, fecha_final, logros, visible, created_at, updated_at, usuarios_id) VALUES (:titulo, :descripcion, :fecha_inicio, :fecha_final, :logros, :visible, :created_at, :updated_at, :usuarios_id)";

        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['logros'] = $this->logros;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['created_at'] = $this->created_at;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['usuarios_id'] = $this->usuarios_id;

        $this->get_results_from_query();

        $this->mensaje = 'Trabajo agregado exitosamente';
    }

    // Metodo edit basado en el DBAbstractModel

    public function edit($id = '')
    {
        $this->query = "UPDATE trabajos SET titulo = :titulo, descripcion = :descripcion, fecha_inicio = :fecha_inicio, fecha_final = :fecha_final, logros = :logros, visible = :visible, updated_at = :updated_at WHERE id = :id";

        $this->parametros['titulo'] = $this->titulo;
        $this->parametros['descripcion'] = $this->descripcion;
        $this->parametros['fecha_inicio'] = $this->fecha_inicio;
        $this->parametros['fecha_final'] = $this->fecha_final;
        $this->parametros['logros'] = $this->logros;
        $this->parametros['visible'] = $this->visible;
        $this->parametros['updated_at'] = $this->updated_at;
        $this->parametros['id'] = $id;

        $this->get_results_from_query();

        $this->mensaje = 'Trabajo editado exitosamente';
    }


    // Metodo delete basado en el DBAbstractModel

    public function delete($id = '')
    {
        $this->query = "DELETE FROM trabajos WHERE id = :id";

        $this->parametros['id'] = $id;

        $this->get_results_from_query();

        $this->mensaje = 'Trabajo eliminado exitosamente';
    }


    // Metodo get basado en el DBAbstractModel

    public function get($id = ''){
        $this -> query = "SELECT * FROM trabajos WHERE id = :id OR usuarios_id = :usuarios_id";
        $this -> parametros['usuarios_id'] = $id;
        
    }

    // Metodo getJobById

    public function getJobById($id)
    {
        $this->query = "SELECT * FROM trabajos WHERE id = :id";
        $this->parametros['id'] = $id;
        $this->get_results_from_query();
        return $this->rows;
    }

}



?>