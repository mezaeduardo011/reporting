<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\{
    All, Constant, Security
};/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 01/12/2017
 * @version: 1.0
 */ 
class HoMascaraModel extends Main
{
    use Security;
    public function __construct()
    {
        $this->tabla = 'ho_mascaras';
        $this->campoid = array('id');
        $this->campos = array('ho_tipo_dato_type','label', 'mascara', 'mensaje', 'clase_input', 'created_usuario_id', 'updated_usuario_id', 'created_at', 'updated_at');
        parent::__construct();
    }

    /**
     * Permite ver todas las nascaras del sistema
     * @return array $tablas
     */
    public function getMascarasListar()
    {
        $sql = "select * FROM " . $this->tabla . " ";
        $datos = $this->executeQuery($sql);
        return $datos;
    }

    /**
     * Permite ver todas las mascaras relacionada a una vista determinada
     * @param string $vista, vista que se desae ver las mascaras
     * @return array $datos, todas las vistas asociadas a la vista
     */
    public function getMascarasShowVista($vista)
    {
        $sql = "select * from view_list_mascaras WHERE vista='$vista'";
        $datos = $this->executeQuery($sql);
        return $datos;
    }

    /**
     * Crear registros nuevos de Mascara
     * @param: Array $datos
     * @return array $tablas
     */
    public function setProductosCreate($datos)
    {
        $user = $this->getSession('usuario');
        $this->fijarValores($datos);
        // Campos de Auditoria
        $this->fijarValor('created_usuario_id',$user->id);
        $this->fijarValor('created_at',All::now());
        $this->guardar();
        $val = $this->lastId();
        return $val;
    }

    /**
     * Extraer las mascaras especificas asociado al tipo de datos ingresado
     * @param String $type, tipo de datos pk
     * @return array $datos
     */
    public function getMascaraShow($type)
    {
        $sql = "select * FROM " . $this->tabla . " WHERE ho_tipo_dato_type='$type' ";
        $datos = $this->executeQuery($sql);
        return $datos;
    }
}
?>
