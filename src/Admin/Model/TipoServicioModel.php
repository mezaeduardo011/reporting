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

class TipoServicioModel extends Main
{
   use Security;
   public function __construct()
   {
       $this->tabla = 'tipo_servicio';
       $this->campoid = array('id');
       $this->campos = array('descripcion');
       // Clase de registro de auditoria de las acciones
       $this->segLogAccionesModel = new SegLogAccionesModel();
       parent::__construct();
   }

    /**
    * Extraer todos los registros de TipoServicio
    * @return array $tablas
    */ 
   /*public function getTipoServicioListarCombo($request,$result)
   {
     $tablas=$this->leerTodos($datos);
     return $tablas;
   }*/

    /**
    * Extraer todos los registros de TipoServicio
    * @return array $tablas
    */ 
   public function getTipoServicioListar($request,$result)
   {
    //define variables from incoming values
    if(isset($request->posStart))
        $posStart = $request->posStart + 300;
    else
        $posStart = 0;

    if(isset($request->count))
        $count = $request->posStart;
    else
        $count = 300;

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
    $res = $this->get($sqlCount);
    //output data in XML format
    $items = array();
    $temp = array();
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
        array_push($temp,$tmp);

    }
    $items['data'] = $temp;
    $items['countAll'] = $resCount[0]->items;
    $items['count'] = $count;
    $items['posStart'] = $posStart;
    return $items;

   }

    /**
    * Crear registros nuevos de TipoServicio
    * @param: Array $datos
    * @return array $tablas
    */ 
   public function setTipoServicioCreate($datos)
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
    * Extraer un registros de TipoServicio
    * @param: String $id
    * @return array $tablas
    */ 
   public function getTipoServicioShow($data)
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
    * Eliminar registros de TipoServicio
    * @param: string $id
    * @return array $tablas
    */ 
   public function remTipoServicioDelete($datos)
   {
      $valor=base64_decode($datos->obj);
      $this->fijarValor('id',$valor);
      $val = $this->borrar();
      // Registro de Auditoria
      $user = $this->getSession('usuario');
      $this->segLogAccionesModel->cargaAcciones($this->tabla, $valor,'','', $user->id,parent::LOG_BAJA);
      return $val;
   }

    /**
    * Actualizar registros de TipoServicio
    * @param: arreglo $obj
    * @return array $tablas
    */ 
   public function setTipoServicioUpdate($datos)
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
