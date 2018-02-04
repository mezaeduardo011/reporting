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
class HoConexionesModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'ho_conexiones';
       $this->campoid = array('id');
       $this->campos = array('label', 'driver', 'host', 'db', 'usuario', 'clave');
       parent::__construct();
   }

    /**
     *  Encargado de registrar todas las conexiona a base de datos que sean necesarias
     * @param Object $data
     * @return Boolean $val
     */
    public function setDataBase($data)
    {
        $this->fijarValores($data);
        $this->guardar();
        $val = $this->lastId();
        return $val;
    }

    /**
     * Permite extraer las conexiones existententes
     * @param Integer $data,identificador de las conexioes
     * @return array $val
     */
    public function getExtraerConexiones($data='NULL')
    {
        if($data=='NULL'){
            $where = '';
        }else{
            $where = ' WHERE id='.(int)$data;
        }
        $sql = "SELECT * FROM ho_conexiones".$where;
        $val = $this->executeQuery($sql);
        return $val;
    }

    /**
     * Permite Verificar si una conexion existe en base de datos
     * @param String $label, etiqueta de conexion o token
     * @param String $val, SI o NO
     */
    public function getExtraerConexionesToken($label)
    {
        $sql = "SELECT (CASE count(id) WHEN 0 THEN 'NO' ELSE 'SI' END) AS existe  FROM ho_conexiones WHERE label='$label'";
        $val = $this->executeQuery($sql);
        return $val[0];
    }

    /**
     * Permite extraer todas las entidades(Tablas) correspondiente a la conexion descartando las tablas necesarias del sistema
     * @param Array $data,identificador de la conexion para poder consultar la entidades relacionadas
     * @return Array $tablas;
     */
    public function getAllUniverso($data)
    {
        $sql = "SELECT * FROM ho_conexiones WHERE id=".$data->db;
        $val = $this->executeQuery($sql);
        // Permite extraer las entidades de la conexion actual desde la informacion schema
        //$sql = "SELECT * FROM ".$val[0]->db.".INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME not like 'ho_%' AND TABLE_TYPE='BASE TABLE' AND TABLE_NAME not like 'seg%'";
        $sql = "SELECT a.*, (SELECT COUNT(b.TABLE_NAME) from ".$val[0]->db.".INFORMATION_SCHEMA.COLUMNS AS b WHERE b.TABLE_NAME = a.TABLE_NAME) AS TABLE_COLUMNS, (SELECT (CASE count(*) WHEN 0 THEN 'NO' ELSE 'SI' END)   FROM ho_entidades AS c WHERE c.entidad = a.TABLE_NAME  ) AS TABLE_REGISTRADA ";
        $sql .= "FROM ".$val[0]->db.".INFORMATION_SCHEMA.TABLES AS a ";
        $sql .= "WHERE a.TABLE_NAME not like 'ho_%' AND a.TABLE_TYPE='BASE TABLE' AND a.TABLE_NAME not like 'seg_%' AND a.TABLE_NAME != 'sysdiagrams'";
        $temp=$this->executeQuery($sql);
        return $temp;
    }

    /**
     * Permite extraer las entidades comunes definidas en el sistema
     * @param datos pasado del controlador
     * @return  Array $retu
     */
    public function getExtraerDetallesComun($data)
    {
        /* stdClass Object
        (
            [tabla_vista] => personal--clientes--id
            [vista_campo] => nombres
            [cart_separacion] => cualquier
        )*/
         // Separacion del campo de la vista
        $detalle=explode('--',$data['tabla_vista']);
        /*
          Array
            (
                [0] => personal
                [1] => clientes
                [2] => id
            )
         */
        // indicador cuando es un combo
        if($data['tipo']=='combo')
        {
            $tmp = explode('|',$data['vista_campo']);
            $colums = $data['vista_campo'];
            if(count($tmp)>0){ $colums=implode("+' ".$data['cart_separacion']." '+",$tmp);}
            $sql = "SELECT  $detalle[2] AS id, ".$colums." AS nombre  FROM $detalle[0]";
        }else{
            $sql = "select field, label, hidden_list from ho_vistas WHERE entidad='$detalle[0]' and nombre='$detalle[1]'";
            $tabla = $this->executeQuery($sql);
            $valor = Array();
            foreach ($tabla AS $key => $value){
                $valor[$key] = $value->field;
            }
            $this->free();
            $sql = "SELECT  ".implode(',',$valor)."  FROM $detalle[0] WHERE $detalle[2] = '".$data['where']."'";
        }
        $tabla = $this->executeQuery($sql);
        $retu['datos'] = $tabla;
        return $retu;
    }

}

?>
