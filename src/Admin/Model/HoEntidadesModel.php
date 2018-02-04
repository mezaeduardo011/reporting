<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\{
    All, Constant, Security
};
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 14/09/2017
 * @version: 1.0
 */ 
class HoEntidadesModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'ho_entidades';
       $this->campoid = array('id');
       $this->campos = array('conexiones_id','entidad','field','type', 'nulo', 'dimension','restrincion');
       parent::__construct();
   }

    /**
     * Permite Agregar entidades nueva a la tabla de configuracion
     * @param Integer $db , Identificador de la base de datos
     * @param String $data , entidad encargada de procesar los datos
     * @return bool
     */
    public function registrarEntidadesConfig($db,$data )
    {
        // Seleccu
        $sql = "SELECT * FROM ho_conexiones WHERE id=".$db;
        $conect = $this->executeQuery($sql);
        // Esta linea permite eliminar cada vez que se porcesa para volver a registrar
        $sql = "DELETE FROM ho_entidades WHERE conexiones_id=$db";
        $this->execute($sql);
        for ($a=0;$a<count($data);$a++) {
            $t = $this->showColumns($data[$a],$conect[0]->db);
            $sql = "";
            foreach ($t AS $key => $value) {
                $da = explode('(', $value->Type);
                $dim = str_replace(')', ' ', $da[1]);
                $bus = array("(",")","'");
                $rem = array('','','');
                $fijo = str_replace($bus,$rem,$value->Default);
                $sql = "INSERT INTO ho_entidades (conexiones_id,entidad,field,type,nulo,dimension,fijo,restrincion) VALUES($db,'".$data[$a]."','".$value->Field."','".$da[0]."','".$value->Null."','".$dim."','".$fijo."','".$value->Key."');";
                $return = $this->execute($sql);
            }
        }
        return true;
    }

    /**
     * Permite extraer etidades y detalles de las vistas relacionadas a una conexion seleccionada
     * @return array $tmp, informacion de los diferentes entidades
     */
    public function extraerTodasLasEntidades($data)
    {
        // Proceso la entidad que llega en un string separado por ,
        $data['entidad']=explode(',',$data['entidad']);
        $val = array();
        for ($a=0;$a<count($data['entidad']);$a++) {
           $sql = "SELECT * FROM view_list_enti_regi AS a WHERE a.entidad='".$data['entidad'][$a]."' AND conexiones_id=".$data['conn'];
            $val[$data['entidad'][$a]] = $this->executeQuery($sql);
        }
        return $val;
    }

    /**
     * Permite extraer el detalle completo de la entidad que ya esta registrant
     * @param array $data, Valores del arreglo de la entidad
     * @return array $tmp, informacion de los diferentes entidades
     */
    public function extraerDetalleEntidade($data)
    {
        $sql = "SELECT * FROM ".$this->tabla." WHERE conexiones_id=".$data['connect']." AND  entidad='".$data['tabla']."'";
        $temp = $this->executeQuery($sql);
        return $temp;
    }

    /**
     * Permite crear la una estructura de la entidad a partir de una configuracion desde la vista del generador
     * @param object $data
     * @return bool
     */
    public function setEstructuraCreateTabla($data)
    {
        // BLOQUE DE DEFINIR TABLA
        $ldd0='CREATE TABLE '.$data->entidad.' ('.PHP_EOL;
        $constraint = array();
        $unico = array();
        foreach($data->campos AS $key=>$value){
            if($data->baseDatosDriver=='sql'){
                $incremento = 'IDENTITY(1,1)';
                $boleano = 'bit';
            }
            if($data->index[$key]=='PRIMARY KEY'){
                array_push($constraint,$value);
            }elseif ($data->index[$key]=='UNIQUE'){
                array_push($unico,$value);
            }
            // Asignacion de elementos autoincremento
            $autoIncreme = (!empty($data->extra[$key]))?"$incremento ":'';
            // Definicion para la cantidad de varchar
            $cantVarchar = (!empty($data->varcharValor[$key]))?'('.$data->varcharValor[$key].')':'';
            // Valore default
            $valoDefault = (!empty($data->default[$key]))?'DEFAULT \''.$data->default[$key].'\'':'';

            $ldd0.='  '.$value.' '.strtoupper($data->tipos[$key]).$cantVarchar.' '.$autoIncreme.''.$data->requerido[$key].' '.$valoDefault.','.PHP_EOL;
        }
        $ldd0.='  CONSTRAINT '.$data->entidad.'_PK PRIMARY KEY('.implode(',',$constraint).')'.PHP_EOL;
        $ldd0.=');';
        $return = $this->execute($ldd0);
        // END DEFINICION

        // ALTER TABLE SI HAY -unique
        if(count($unico)>0) {
            $ldd1 = 'ALTER TABLE ' . $data->entidad . PHP_EOL;
            $ldd1 .= ' ADD UNIQUE (' . implode(',', $unico) . ')';
            $return1 = $this->execute($ldd1);
        }
        return true;
    }


}
?>
