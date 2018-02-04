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
class PropertiesModel extends Main
{
   public function __construct()
   {
       parent::__construct();
   }

 /**
	 * Metodo para obtener las propiedades predeterminadas para todos los elementos
	 * Se obtienen las propiedades con "father_property = 2" para seleccionar solo 
	 * las propiedades que tengan como padre el registro con id 2 (Default)
	 * @return array propiedades predeterminadas
	 */ 
    public function getPropertiesDefault()
    {
      return $this->select("SELECT * FROM properties WHERE father_property = 2 AND activated = 1 ORDER BY name_property ASC;");
    } 

	 /**
	 * Metodo para obtener las propiedades predeterminadas para todos los elementos
	 * Se obtienen las propiedades con "father_property = 2" para seleccionar solo 
	 * las propiedades que tengan como padre el registro con id 2 (Default)
	 * @return array propiedades predeterminadas
	 */ 
    public function getPropertiesByFatherId($id)
    {
      return $this->select("SELECT * FROM properties WHERE father_property in ($id) AND activated = 1 ORDER BY id ASC;");
    }       


   /**
   * Metodo para obtener las propiedades predeterminadas para todos los elementos
   * Se obtienen las propiedades con "father_property = 2" para seleccionar solo 
   * las propiedades que tengan como padre el registro con id 2 (Default)
   * @return array propiedades predeterminadas
   */ 
    public function getValuesSelectById($id)
    {
      return $this->select("SELECT value FROM properties_values WHERE id_property = $id;");
    }       

}
?>
