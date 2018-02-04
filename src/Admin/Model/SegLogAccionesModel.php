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

class SegLogAccionesModel extends Main
{
    public function __construct()
    {
        $this->tabla = 'seg_log_eventos';
        $this->campoid = array('id');
        $this->campos = array('host','base_datos','entidad','entidad_id','new_value','old_value','usuario_id','proceso','created_at');
        parent::__construct();
    }

    /**
     * Extraer todos los registros de SegUsuarios
     * @param Request $request los datos enviado por el navegador
     * @param Array $result inluyendo el resultado de los campos
     * @return array $tablas
     */
    public function getSegLogUsuariosAccionesListar($request,$result)
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


        // Primero extraer la cantidad de registros
        $sqlCount = "Select count(*) as items FROM ".$this->tabla." WHERE usuario_id=".$user[0];
        $resCount = $this->executeQuery($sqlCount);

        //create query to products table
        $sql = implode(',', $result['select']).", id FROM ".$this->tabla." WHERE usuario_id=".$user[0];

        //if this is the first query - get total number of records in the query result
        $sqlCount = "SELECT * FROM (
				SELECT ROW_NUMBER() OVER( ORDER BY id ASC ) AS row, ".$resCount[0]->items." AS cnt, $sql ) AS sub";
        $resQuery = $this->get($sqlCount);
        $rowCount =  $this->fetch();

        $totalCount = @$rowCount->cnt;

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

    public function showAcciones($id)
    {
        $sql = "SELECT * FROM ".$this->tabla." WHERE id=".$id;
        $tmp=$this->executeQuery($sql);
        $tablas['datos'] = $tmp[0];
        return $tablas;
    }


    /**
     * Permite cargar las acciones de auditoria de las acciones que haga el usuario en el sistema
     * @param string $entidad, Tabla en la cual se hacer el proceso
     * @param string $entidad_id, Identificador del registro que se esta trabajando
     * @param string $new_value, Datos cuando es nuevo
     * @param string $old_value, Datos cuando es old
     * @param string $usuario_id, usuario que hace el proceso
     * @param string $proceso, que proceso se esta haciendo, UPDATE, CREATE, SELECT, DELETE
     * @return bool true o false;
     */
    public function cargaAcciones($entidad,$entidad_id='',$new_value='',$old_value='',$usuario_id,$proceso)
    {
        $host = $_SERVER['REMOTE_ADDR'];
        $name_db=$this->database;
        $this->segLogCreateLogin($host,$name_db,$entidad,$entidad_id,$new_value,$old_value,$usuario_id,$proceso);
        return true;
    }
    /**
     * Permite registrar las acciones de auditoria de las acciones que haga el usuario en el sistema
     * @param string $host, Direccion ip del cliente
     * @param string $entidad, Nombre de la base de datos que se esta procesando
     * @param string $entidad, Tabla en la cual se hacer el proceso
     * @param string $entidad_id, Identificador del registro que se esta trabajando
     * @param string $new_value, Datos cuando es nuevo
     * @param string $old_value, Datos cuando es old
     * @param string $usuario_id, usuario que hace el proceso
     * @param string $proceso, que proceso se esta haciendo, UPDATE, CREATE, SELECT, DELETE
     * @return bool true o false;
     */

    private function segLogCreateLogin($host,$name_db,$entidad,$entidad_id,$new_value,$old_value,$usuario_id,$proceso)
    {
        $query = "INSERT INTO seg_log_eventos(host,base_datos,entidad,entidad_id,new_value,old_value,usuario_id,proceso,created_at) VALUES('$host','$name_db','$entidad','$entidad_id','$new_value','$old_value','$usuario_id','$proceso','".All::now()."')";
        $this->db->execute($query);
        return true;
    }
}
?>