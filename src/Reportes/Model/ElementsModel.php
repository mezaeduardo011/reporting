<?php
namespace APP\Reportes\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\All;
/**
 * Generador de codigo del Modelo de la App Reportes
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */ 
class ElementsModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'elements';
       $this->campoid = array('id');
       $this->campos = array('name_element','xml_tag');
       parent::__construct();
   }




    /**
    * Metodo para obtener todos los elementos disponbiles para mostrar 
    * en el panel de control.
    * @return array elementos
    */ 
    public function getAllElements()
    {
      return $this->select("SELECT * FROM elements ORDER BY name_element ASC;");
    }   

	

}
?>
