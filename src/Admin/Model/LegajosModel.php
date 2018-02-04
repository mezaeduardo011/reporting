<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\Security;
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 02/11/2017
 * @version: 1.0
 */ 

class LegajosModel extends Main
{
   use Security;
   public function __construct()
   {
       $this->tabla = 'legajos';
       $this->campoid = array('id');
       $this->campos = array('nombres','apellidos','dni');
       parent::__construct();
       $this->segLogAccionesModel = new SegLogAccionesModel();
   }

    /**
    * Extraer todos los registros de Legajos
    * @return array $tablas
    */ 
   public function getLegajosListarCombo($request,$result)
   {
     $tablas=$this->leerTodos($datos);
     return $tablas;
   }

    /**
    * Extraer todos los registros de Legajos
    * @return array $tablas
    */ 
   public function getLegajosListar($request,$result)
   {
    //define variables from incoming values
    if(isset($request->posStart))
        $posStart = $request->posStart;
    else
        $posStart = 0;
    if(isset($request->count))
        $count = $request->count;
    else
        $count = 100;
    // Primero extraer la cantidad de registros
    $sqlCount = "Select count(*) as items FROM ".$this->tabla;
    $resCount = $this->executeQuery($sqlCount);
    //create query to products table
    $sql = implode(',', $result['select']).", id FROM ".$this->tabla;
    //if this is the first query - get total number of records in the query result
    $sqlCount = "SELECT * FROM (SELECT ROW_NUMBER() OVER( ORDER BY id ASC ) AS row, ".$resCount[0]->items." AS cnt, $sql ) AS sub";
    $resQuery = $this->get($sqlCount);
    $rowCount =  $this->fetch();
    $totalCount = (empty($rowCount->cnt))?0:$rowCount->cnt;
    //add limits to query to get only rows necessary for the output
    $sqlCount.= " WHERE row>=".$posStart." AND row<=".$count;
    $sqlCount;
    $res = $this->get($sqlCount);
    //output data in XML format
    $items = array();
    while($row=$this->fetch($res)){
        $tmp['id'] = $row->id;
        $tep = array();
        foreach ($row as $key => $value) {
            foreach ($row as $col => $val) {
                if (gettype($val) == "object" && get_class($val) == "DateTime") {
                $row->$col = $val->format("d/m/Y");
                }
            }
            if($key!='id' AND $key!='cnt' AND $key!='row'){
                $tep[] = $value;
            }
        }
        $tmp['data'] = $tep;
        array_push($items,$tmp);
    }
    return $items;

   }

    /**
    * Crear registros nuevos de Legajos
    * @param: Array $datos
    * @return array $tablas
    */ 
   public function setLegajosCreate($datos)
   {
     $this->fijarValores($datos);
     $this->guardar();
     $val = $this->lastId();
     return $val;
   }

    /**
    * Extraer un registros de Legajos
    * @param: String $id
    * @return array $tablas
    */ 
   public function getLegajosShow($data)
   {
     $sql = "SELECT * FROM ".$this->tabla." WHERE id=".$data->data;
     $tmp=$this->executeQuery($sql);
     $tablas['datos'] = $tmp[0];
     $tablas['error'] = 0;
     return $tablas;
   }

    /**
    * Eliminar registros de Legajos
    * @param: string $id
    * @return array $tablas
    */ 
   public function remLegajosDelete($datos)
   {
      $valor=base64_decode($datos->obj);
      $this->fijarValor('id',$valor);
      $val = $this->borrar();
      return $val;
   }

    /**
    * Actualizar registros de Legajos
    * @param: arreglo $obj
    * @return array $tablas
    */ 
   public function setLegajosUpdate($datos)
   {
     $this->fijarValores($datos);
     $val = $this->guardar();
     return $val;
   }
}
?>
