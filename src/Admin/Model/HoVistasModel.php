<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\{
    All, Commun, Logs
};
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 15/09/2017
 * @version: 1.0
 */ 
class HoVistasModel extends Main
{
   use Logs;
   public function __construct()
   {
       $this->tabla = 'ho_vistas';
       $this->campoid = array('id');
       $this->campos = array('apps','conexiones_id','entidad','nombre','field','type','dimension', 'fijo','restrincion','label','mascara','nulo','place_holder','relacionado','tabla_vista','vista_campo','cart_separacion','orden','hidden_form','hidden_list');
       parent::__construct();
   }

    /**
     * Creacion de nuevas vistas del sistema
     * @param $data
     * @return $val;
     */
   public function setConfiguracionVistaNew($data)
   {
   //All::pp($data);
        $temp = array();
        for ($a=0;$a<count($data->field);$a++){
            if(!empty(trim($data->etiqueta[$a]))) {
                $this->fijarValor('id', @$data->id[$a]);
                $this->fijarValor('apps', $data->apps);
                $this->fijarValor('conexiones_id', $data->conexiones_id);
                $this->fijarValor('entidad', $data->tabla);
                $this->fijarValor('nombre', $data->name);
                $this->fijarValor('field', $data->field[$a]);
                $this->fijarValor('type', $data->type[$a]);
                $this->fijarValor('dimension', self::validarDimensionCampo($data->type[$a],$data->dimension[$a]));
                $this->fijarValor('fijo', $data->fijo[$a]);
                $this->fijarValor('restrincion', $data->restrincion[$a]);
                $this->fijarValor('label', $data->etiqueta[$a]);
                $this->fijarValor('mascara', $data->mascara[$a]);
                $this->fijarValor('nulo', (@$data->nulo[$a]=='on')?'NO':'YES');
                $this->fijarValor('place_holder', $data->place_holder[$a]);
                $this->fijarValor('relacionado', $data->relacionado[$a]);
                $this->fijarValor('tabla_vista', (!empty((string)$data->tabla_vista[$a])?$data->tabla_vista[$a]:''));
                // Vista_campo es la relacion de las opciones que tienes para seleccionar y campCombox es el que lo procesa
                $this->fijarValor('vista_campo', (!empty((string)@$data->campCombox[$a])?$data->campCombox[$a]:''));
                // Caracter de sepacion cuando la persona desea agregar algo adicional que separcion por espacio
                $this->fijarValor('cart_separacion', (!empty((string)@$data->extra[$a])?$data->extra[$a]:''));
                $this->fijarValor('orden', $a);
                $this->fijarValor('hidden_form', (@$data->hidden_form[$a]=='on')?true:false);
                $this->fijarValor('hidden_list', (@$data->hidden_list[$a]=='on')?true:false);
                $this->guardar();
            }
        }
       //$this->fijarValores($datos);
       $val = $this->lastId();
       return $val;
   }

    /**
     * Permite extraer el detalle completo de la entidad que ya esta registrada
     * @return array $tmp, informacion de los diferentes entidades
     */
    public function extraerDetalleEntidade($data)
    {
        $vista = explode('-',$data['vista']);
        $sql = "SELECT * FROM ".$this->tabla." WHERE conexiones_id=".$data['connect']." AND  entidad='".$data['tabla']."' AND nombre='".$vista[1]."'";
        $temp = $this->executeQuery($sql);
        return $temp;
    }

    public function extraerDetalleEntidadListado($data)
    {
        $registro = array();
        // Recibimos todas las entidades seleccionadas dependiendo de la conexion enviada y la pasamos a un arreglo
        $data['entidad']=explode(',',$data['tabla']);
        // Recorremos las entidades y verificamos las las vistas existentes
        for ($a=0;$a<count($data['entidad']);$a++) {

            // Hacemos las consultas para identificar cuales vistas tiene
            $sql1 = "SELECT * FROM view_list_vist_gene WHERE conexiones_id=".$data['connect']." AND entidad='".$data['entidad'][$a]."'";
            $val[$data['entidad'][$a]] = $this->executeQuery($sql1);

            $sql2 = "SELECT * FROM ho_entidades WHERE conexiones_id=".$data['connect']." AND entidad='".$data['entidad'][$a]."'";
            $registro[$data['entidad'][$a]]['columnas'] = $this->executeQuery($sql2);
            //All::pp($this->executeQuery($sql1));
            foreach ($val AS $key => $value){
                foreach ($value AS $key => $value2) {
                    $sql = "SELECT * FROM ho_vistas WHERE conexiones_id=".$value2->conexiones_id." AND entidad='".$value2->entidad."' AND nombre='".$value2->nombre."'";
                    $obj = $this->executeQuery($sql);
                    $registro[$value2->entidad][$value2->nombre] = $obj;
                }
            }
        }

        return $registro;
    }


    /**
     * Permite solicitar las vistas disponibles
     */
    public function getShowVista($request)
    {
        $sql='';
        if ($request->tipo == 'combo'){
            $sql = "SELECT entidad AS entidad, nombre AS vista, pk  FROM view_list_vist_gene WHERE apps='$request->apps' AND conexiones_id=$request->conexionId GROUP BY entidad,nombre,pk ";
        }else{
            $sql = "SELECT entidad AS entidad, nombre AS vista, pk, orden  FROM view_selec_grilla WHERE apps='$request->apps' AND conexiones_id=$request->conexionId GROUP BY entidad,nombre,pk,orden ORDER BY entidad,nombre,orden ";
        }
        $tabla = $this->executeQuery($sql);
        $retu['datos'] = $tabla;
        return $retu;
    }


    /**
     * Permite ver los campos asociados a las vistas
     */
    public function getShowVistaRow($request)
    {
        /**
         *  stdClass Object
            (
                [apps] => Admin
                [conexionId] => 1
                [entidad] => test_autos--autos--id
            )
         */
        $response = explode('--',$request->entidad);
        $app = $request->apps;
        $conexion = $request->conexionId;
        $entidad = $response[0];
        $vista = $response[1];
        $sql = "SELECT field AS campos, orden FROM ho_vistas WHERE apps='$app' AND conexiones_id=$conexion AND entidad='$entidad' AND nombre='$vista' AND field NOT in('created_usuario_id','updates_usuario_id','created_at','updated_at') GROUP BY field, orden ORDER by orden";
        $tabla = $this->executeQuery($sql);
        $retu['rows'] = $tabla;
        return $retu;
    }



    /**
     * Permite actualizar que fue procesada la vista
     */
    public function updateStatusVista($apps, $conn, $entidad,$vita)
    {
        $sql = "UPDATE ho_vistas SET procesado=1  WHERE apps='$apps' AND conexiones_id=$conn AND  entidad='$entidad' AND nombre='$vita'";
        $temp = $this->execute($sql);
        return $temp;
    }

    /**
     * Permite validar y redimensionar campos que el manejador de base de datos no toma la dimension correcta y se le asigna la definida en los tipos de datos
     * @param String $type, typo de dato a ser procesado
     * @param String $dimension, dimension del capos actual
     * @return Integer $dimension
    */
    public function validarDimensionCampo($type,$dimension)
    {

        if($dimension=='-1') {
            $hoTipoDatoModel = new HoTipoDatosModel();
            $data = $hoTipoDatoModel->getTipoDatosShow($type);
            if(is_null($data)){
                // Logs de Error
                $obj = array('type' => $type);
                $msj = All::getMsjException('Model', 'type-data-vacia',$obj);
                $this->logInfo($msj);
                return $dimension;
            }else{;
                return $data[0]->length;
            }

        }else{
            return $dimension;
        }

    }


}
?>
