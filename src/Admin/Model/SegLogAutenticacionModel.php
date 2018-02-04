<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\All;
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 08/11/2017
 * @version: 1.0
 */

class SegLogAutenticacionModel extends Main
{
    public function __construct()
    {
        $this->tabla = 'seg_log_autenticacion';
        $this->campoid = array('id');
        $this->campos = array('host','navegador','accion','sistema','usuario','created_at');
        parent::__construct();
    }
    public function segLogCreateLogin($ip,$navegador,$accion,$sistema,$usuario_id)
    {
        $query = "INSERT INTO seg_log_autenticacion(host,navegador,accion,sistema,usuario,created_at) VALUES('$ip','$navegador','$accion','$sistema','$usuario_id','".All::now()."')";
        $this->db->execute($query);
    }

    /**
     * Extraer todos los registros de SegUsuarios
     * @param Request $request los datos enviado por el navegador
     * @param Array $result inluyendo el resultado de los campos
     * @return array $tablas
     */
    public function getSegLogUsuariosListar($request,$result)
    {
        // Extraer los datos del usuario
        $user=explode('|',base64_decode($request->token));
        //define variables from incoming values
        if(isset($request->posStart))
            $posStart = $request->posStart;
        else
            $posStart = 0;
        if(isset($request->count))
            $count = $request->count;
        else
            $count = 100;

        // If ternario para mostrar si filtra por persona o muestra el universo
         $where = (empty($user[0]))?'':'WHERE usuario='.$user[0];

        // Primero extraer la cantidad de registros
        $sqlCount = "Select count(*) as items FROM ".$this->tabla." ".$where;
        $resCount = $this->executeQuery($sqlCount);

        //create query to products table
        $sql = implode(',', $result['select']).", id FROM ".$this->tabla." ".$where;

        //if this is the first query - get total number of records in the query result
       $sqlCount = "SELECT * FROM (
				SELECT ROW_NUMBER() OVER( ORDER BY id ASC ) AS row, ".$resCount[0]->items." AS cnt, $sql ) AS sub";
        $resQuery = $this->get($sqlCount);
        $rowCount =  $this->fetch();

        $totalCount = @$rowCount->cnt;

        //add limits to query to get only rows necessary for the output
       echo  $sqlCount.= " WHERE row>=".$posStart." AND row<=".$count;

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
                        $row->$col = $val->format("d/m/Y h:i:s");
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
}
?>