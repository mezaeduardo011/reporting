<?php
namespace APP\Reportes\Router;
use JPH\Core\Router\Route;
/**
 * Generado por el generador de codigo de router de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */ 
class ReportesConfiguration
{
    public function initApp($application,$folder)
    {
      $config_file = $folder.'Router.xml';
      $config = simplexml_load_file($config_file);
      new Route($application,$config);
    }
}
?>
