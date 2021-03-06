<?php
namespace APP\Reportes\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\All;
/**
 * Generador de codigo del Modelo de la App Reportes
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 09/01/2018
 * @version: 1.0
 */ 
class ConnectionModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'connections';
       $this->campoid = array('id');
       $this->campos = array('host','db','password','users');
       parent::__construct();
   }

   public function saveConnections($data)
   {
       $this->fijarValores($data);
       $this->guardar();
       $val = $this->lastId();
       return $val;
   }

    public function getTables($conn)
    {
        $response = null;
        $sql = "SELECT name AS tables FROM sys.tables;";

        $stmt = sqlsrv_query( $conn, $sql );


        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC ) ) {
            $response[] = $row;
        }
        sqlsrv_free_stmt( $stmt);
        return $response;
    }

    public function validateQuery($conn,$query)
    {
        $response = null;

        $stmt = sqlsrv_query( $conn, $query );


        if( $stmt === false ) {
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    $response = $error[ 'message'];
                }
            }
        }else
        {
            $response = true;
        }



        return $response;
    }

    public function showColumnsReport($entidad,$conn)
    {
        $response = null;
        $sql = "SELECT c.COLUMN_NAME AS name,
                                  ( CASE c.DATA_TYPE
                                    WHEN 'varchar' 
                                      THEN  'String'
                                    WHEN 'int' 
                                      THEN  'Integer'
                                    ELSE
                                     c.DATA_TYPE
                                  END )
                                
                                  AS 'type'
                              , isnull(c.NUMERIC_SCALE,0) AS decimal ,c.IS_NULLABLE AS 'Null',isnull(LEFT(k.constraint_type, 3), '') AS 'Key',c.COLUMN_DEFAULT AS 'Default', CASE co.is_identity WHEN 1 THEN 'auto_increment' ELSE '' END AS Extra FROM INFORMATION_SCHEMA.COLUMNS AS c 
                 LEFT JOIN INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE  AS kc ON kc.COLUMN_NAME = c.COLUMN_NAME AND kc.TABLE_NAME = c.TABLE_NAME 
                 LEFT JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS as k ON k.CONSTRAINT_NAME = kc.CONSTRAINT_NAME AND k.TABLE_NAME = kc.TABLE_NAME 
                 LEFT JOIN sys.objects AS o ON o.name = c.TABLE_NAME 
                 LEFT JOIN sys.columns AS co ON o.object_id = co.object_id AND co.name = c.COLUMN_NAME 
                 WHERE c.TABLE_NAME = '$entidad';";

        $stmt = sqlsrv_query( $conn, $sql );
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC ) ) {
            $response[] = $row;
        }
        sqlsrv_free_stmt( $stmt);
        return $response;
    }

    public function getTypeColumn($conn, $column,$table)
    {
        $response = null;
        $query = "SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column';";

        $stmt = sqlsrv_query( $conn, $query );

        if( $stmt === false ) {
            if( ($errors = sqlsrv_errors() ) != null) {
                foreach( $errors as $error ) {
                    $response = $error[ 'message'];
                }
            }
        }else
        {
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC ) ) {
                $response[] = $row;
            }
        }
        return $response;
    }


}
?>
