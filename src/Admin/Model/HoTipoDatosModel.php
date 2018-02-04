<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\All;
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 02/12/2017
 * @version: 1.0
 */ 
class HoTipoDatosModel extends Main
{
    public function __construct()
    {
        $this->tabla = 'ho_tipo_dato';
        $this->campoid = array('type');
        $this->campos = array('label', 'length', 'orden', 'created_usuario_id', 'created_at');
        parent::__construct();
    }

    /**
 * Extraer todos los registros de TipoEstatus
 * @return array $datos
 */
    public function getTipoDatosListar()
    {
        $sql = "select * FROM " . $this->tabla . " ORDER BY orden ";
        $datos = $this->executeQuery($sql);
        return $datos;
    }

    /**
     * Extraer todos los registros de TipoEstatus
     * @param String $type, tipo de datos pk
     * @return array $datos
     */
    public function getTipoDatosShow($type)
    {
        $sql = "select * FROM " . $this->tabla . " WHERE type='$type' ";
        $datos = $this->executeQuery($sql);
        return $datos;
    }
}
?>
