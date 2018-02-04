<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\{All,Security};
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 14/11/2017
 * @version: 1.0
 */ 

class PruebaModel extends Main
{
   use Security;
   public function __construct()
   {
       $this->tabla = 'prueba';
       $this->campoid = array('id');
       $this->campos = array('apellido','nombre');
       // Clase de registro de auditoria de las acciones
       $this->segLogAccionesModel = new SegLogAccionesModel();
       parent::__construct();
   }

    /**
    * Extraer todos los registros de Prueba
    * @return array $tablas
    */ 
   public function getPruebaListarCombo($request,$result)
   {
     $tablas=$this->leerTodos($datos);
     return $tablas;
   }

    /**
    * Extraer todos los registros de Prueba
    * @return array $tablas
    */ 
   public function getPruebaListar($request,$result)
   {
       //All::pp($_SERVER);
    //define variables from incoming values
    if(isset($request->posStart))
        $posStart = $request->posStart;
    else
        $posStart = 0;
    if(isset($request->count))
        $count = $request->count;
    else
        $count = 100;

    // Elemento cuando hay relacion
    $relation = All::formatRelacio(@$request->relacion);
    $where = '';
    if(!empty($relation[2])){
       $where="  WHERE $relation[1]=$relation[2]";
    }

    // Primero extraer la cantidad de registros
    $sqlCount = "Select count(*) as items FROM ".$this->tabla.$where ;
    $resCount = $this->executeQuery($sqlCount);
    //create query to products table
    $sql = implode(',', $result['select']).", id FROM ".$this->tabla.$where ;
    //if this is the first query - get total number of records in the query result
    $sqlCount = "SELECT * FROM (SELECT ROW_NUMBER() OVER( ORDER BY id ASC ) AS row, ".$resCount[0]->items." AS cnt, $sql ) AS sub";
    $resQuery = $this->get($sqlCount);
    $rowCount =  $this->fetch();
    $totalCount = (empty($rowCount->cnt))?0:$rowCount->cnt;
    //add limits to query to get only rows necessary for the output
    $sqlCount.= " WHERE row>=".$posStart." AND row<=".$count;
    // Definir las variables para el uso para el XML
    $items = array();
    $items['data'] = $this->executeQuery($sqlCount);
    $items['totalCount'] = $totalCount;
    $items['posStart'] = $posStart;
    //$res = $this->get($sqlCount);
    //output data in XML format
    /*$items = array();
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
    }*/

    return $items;
   }

    /**
    * Crear registros nuevos de Prueba
    * @param: Array $datos
    * @return array $tablas
    */ 
   public function setPruebaCreate($datos)
   {
     $this->fijarValores($datos);
     $this->guardar();
     $val = $this->lastId();

    // Registra log de auditoria de registro de acciones
    $user = $this->getSession('usuario');
    $this->segLogAccionesModel->cargaAcciones($this->tabla, 'id',serialize($datos),'', $val, parent::LOG_ALTA);
     return $val;
   }

    /**
    * Extraer un registros de Prueba
    * @param: String $id
    * @return array $tablas
    */ 
   public function getPruebaShow($data)
   {
     $sql = "SELECT * FROM ".$this->tabla." WHERE id=".$data->data;
     $tmp=$this->executeQuery($sql);
     $tablas['datos'] = $tmp[0];
     $tablas['error'] = 0;
     // Registro de Auditoria
     $user = $this->getSession('usuario');
     $this->segLogAccionesModel->cargaAcciones($this->tabla, $data->data, '','', $user->id, parent::LOG_CONS);
     return $tablas;
   }

    /**
    * Eliminar registros de Prueba
    * @param: string $id
    * @return array $tablas
    */ 
   public function remPruebaDelete($datos)
   {
      $valor=base64_decode($datos->obj);
      $this->fijarValor('id',$valor);
      $val = $this->borrar();
      // Registro de Auditoria
      $user = $this->getSession('usuario');
      $this->segLogAccionesModel->cargaAcciones($this->tabla, $valor,'','', $user->id, parent::LOG_BAJA);
      return $val;
   }

    /**
    * Actualizar registros de Prueba
    * @param: arreglo $obj
    * @return array $tablas
    */ 
   public function setPruebaUpdate($datos)
   {
     $this->fijarValores($datos);
     $val = $this->guardar();
     // Setear log de registro de acciones
      $user = $this->getSession('usuario');
     $this->segLogAccionesModel->cargaAcciones($this->tabla, $datos->id,'', json_encode($datos), $user->id, parent::LOG_MODI);
     return $val;
   }
}
?>
