<?php
namespace JPH\Complements\Database;
use JPH\Core\Commun\Constant;
use JPH\Core\Store\Cache;


/**
 * Clase integradora de herencia multiple de la conexion a base de datos
 * @author: Ing Gregorio Bolivar <elalconxvii@gmail.com>
 * @author: Blog: <http://gbbolivar.wordpress.com>
 * @creation Date: 07/08/2017
 * @version: 4.1
 */

class Main extends Comun implements Constant
{
    use GenerateConexion, GenerateTablesConfigs, ConfigDatabase, Db ;
    /**
     * Constructor de la clase integradora que permite hacer funcionar todas las herencias
     */
    public function __construct() 
    {
        try{
            // Construir las variables de conexion
            $this->constructConexion();
            // Recibe variable de conexion
            $a = func_get_args();
            // Verifica si existe indice del grupo de conexion
            //$conex = new ConfigDatabase();
           
            if(isset($a[0])){ 
                // Conexion enviada por parametro
                 $indx = $a[0];
                 $datos = $this->$indx();
                 //echo "Conexion ".$indx;
            }else{
                // Conexion por defualt
                $datos = $this->default();
                //echo "Conexion Default";
            }
            //var_dump((bool)Cache::get('conecDb')); die();
            if((bool)Cache::get('conecDb')) {
                $this->connect($datos);
                parent::__construct();
            }

            
        }catch(\Throwable $t){
            die("Excepcion capturadao: " . $t->getMessage());
        }
        return $this;
    }
}
