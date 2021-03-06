<?php
namespace APP\Reportes\Controller;
// use JPH\Core\Commun\Security;
 use APP\Reportes\Model AS Model;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */
class ConnectionController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model\ConnectionModel();
        $this->propertiesModel = new Model\PropertiesModel();
    }

    public function testConnection($request)
    {
        $driver = $request->postParameter('driver');
        $database = $request->postParameter('database');
        $user = $request->postParameter('user');
        $password = $request->postParameter('password');
        $host = $request->postParameter('host');
        $connectionInfo = array( "Database"=> $database, "UID"=>$user , "PWD"=>$password);
        $conn = sqlsrv_connect( $host, $connectionInfo);

        if( !$conn ) {
            //No se pudo conectar
            foreach( sqlsrv_errors() as $error ) {
                //Se muestra el mensaje de error
                echo sqlsrv_errors()[0][ 'message'];
            }
            die();
        }

    }

    public  function useConnection($request)
    {
        $data = true;

        if(count( (array)$request->postParameter()) != 0)
        {
            $database = $request->postParameter('database');
            $user = $request->postParameter('user');
            $password = $request->postParameter('password');
            $host = $request->postParameter('host');
        }else if(count( (array)$request->getParameter()) != 0)
        {
            $database = $request->getParameter('database');
            $user = $request->getParameter('user');
            $password = $request->getParameter('password');
            $host = $request->getParameter('host');
        }else
        {
            $data = false;
        }

        if($data)
        {
            $connectionInfo = array( "Database"=> $database, "UID"=>$user , "PWD"=>$password);
            $conn = sqlsrv_connect( $host, $connectionInfo);

            if( !$conn ) {
                //No se pudo conectar
                foreach( sqlsrv_errors() as $error ) {
                    //Se muestra el mensaje de error
                    echo sqlsrv_errors()[0][ 'message'];
                }
                die();
            }

            return $conn;
        }
    }

    public function saveConnection($request)
    {
        echo $this->model->saveConnections($request->postParameter());
    }

    public function getTables($request)
    {
        echo json_encode($this->model->getTables($request->postParameter()));
    }

    public function getDescTables($request)
    {
        $data = [];
        $idField = 1;
        $conn = $this->useConnection($request);
        $tables = $this->model->getTables($conn);

        if($tables)
        {
            foreach ($tables as $t)
            {
                $f = (array) $this->model->showColumnsReport($t['tables'],$conn);
                $fields = [];

                foreach ($f as $i => $field)
                {
                    $fields[] =  array('field' => trim($field['name']),'type' => $field['type'],'idField' => $idField);
                    $idField++;
                }
                $data[] =  array('table' => $t['tables'], 'fields' => $fields);
            }
        }

        return $data;
    }


    public function getTypeColumn($request)
    {
        $conn = $this->useConnection($request);
        $column = $request->postParameter('column');
        $table = $request->postParameter('table');

        $this->json($this->model->getTypeColumn($conn,$column,$table));
    }

    public function validateQuery($request)
    {
        $conn = $this->useConnection($request);
        echo json_encode($this->model->validateQuery($conn,$request->postParameter('query')));
    }

}
?>
