 <?php
 use JPH\Core\Router\RouterGenerator;
/**
 * @propiedad: PROPIETARIO DEL CODIGO
 * @Autor: Gregorio Bolivar * @email: elalconxvii@gmail.com
 * @Fecha de Creacion: 26/02/2018
 * @Auditado por: Gregorio J Bolívar B
 * @Descripción: Generado por el generador de codigo de router de webStores * @package: datosClass
 * @version: 1.0
 */

$request = $_SERVER;
$router = new RouterGenerator();
/** Inicio  del Bloque de instancia al proceso de /home  */
$datos0 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/home", 'apps'=>"Reportes", 'controller'=>"home",'method'=>'runIndex');
$process0 = $router->setRuta($datos0);
/** Fin del caso de /home */
/** Inicio  del Bloque de instancia al proceso de /getAllElements  */
$datos1 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/getAllElements", 'apps'=>"Reportes", 'controller'=>"elements",'method'=>'getAllElements');
$process1 = $router->setRuta($datos1);
/** Fin del caso de /getAllElements */
/** Inicio  del Bloque de instancia al proceso de /getPropertiesDefault  */
$datos2 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/getPropertiesDefault", 'apps'=>"Reportes", 'controller'=>"elements",'method'=>'getPropertiesDefault');
$process2 = $router->setRuta($datos2);
/** Fin del caso de /getPropertiesDefault */
/** Inicio  del Bloque de instancia al proceso de /getPropertiesByFatherId  */
$datos3 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/getPropertiesByFatherId", 'apps'=>"Reportes", 'controller'=>"elements",'method'=>'getPropertiesByFatherId');
$process3 = $router->setRuta($datos3);
/** Fin del caso de /getPropertiesByFatherId */
/** Inicio  del Bloque de instancia al proceso de /getValuesSelectById  */
$datos4 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/getValuesSelectById", 'apps'=>"Reportes", 'controller'=>"elements",'method'=>'getValuesSelectById');
$process4 = $router->setRuta($datos4);
/** Fin del caso de /getValuesSelectById */
/** Inicio  del Bloque de instancia al proceso de /staticTextModal  */
$datos5 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/staticTextModal", 'apps'=>"Reportes", 'controller'=>"modals",'method'=>'staticText');
$process5 = $router->setRuta($datos5);
/** Fin del caso de /staticTextModal */
/** Inicio  del Bloque de instancia al proceso de /createConnection  */
$datos6 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/createConnection", 'apps'=>"Reportes", 'controller'=>"modals",'method'=>'createConnection');
$process6 = $router->setRuta($datos6);
/** Fin del caso de /createConnection */
/** Inicio  del Bloque de instancia al proceso de /testConnection  */
$datos7 = array('petition'=>"POST", 'request'=>$request, 'name'=>"/testConnection", 'apps'=>"Reportes", 'controller'=>"connection",'method'=>'testConnection');
$process7 = $router->setRuta($datos7);
/** Fin del caso de /testConnection */
/** Inicio  del Bloque de instancia al proceso de /useConnection  */
$datos8 = array('petition'=>"POST", 'request'=>$request, 'name'=>"/useConnection", 'apps'=>"Reportes", 'controller'=>"connection",'method'=>'useConnection');
$process8 = $router->setRuta($datos8);
/** Fin del caso de /useConnection */
/** Inicio  del Bloque de instancia al proceso de /saveConnection  */
$datos9 = array('petition'=>"POST", 'request'=>$request, 'name'=>"/saveConnection", 'apps'=>"Reportes", 'controller'=>"connection",'method'=>'saveConnection');
$process9 = $router->setRuta($datos9);
/** Fin del caso de /saveConnection */
/** Inicio  del Bloque de instancia al proceso de /getTables  */
$datos10 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/getTables", 'apps'=>"Reportes", 'controller'=>"connection",'method'=>'getTables');
$process10 = $router->setRuta($datos10);
/** Fin del caso de /getTables */
/** Inicio  del Bloque de instancia al proceso de /tables  */
$datos11 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/tables", 'apps'=>"Reportes", 'controller'=>"modals",'method'=>'tables');
$process11 = $router->setRuta($datos11);
/** Fin del caso de /tables */
/** Inicio  del Bloque de instancia al proceso de /addTag  */
$datos12 = array('petition'=>"POST", 'request'=>$request, 'name'=>"/addTag", 'apps'=>"Reportes", 'controller'=>"jrxml",'method'=>'addTag');
$process12 = $router->setRuta($datos12);
/** Fin del caso de /addTag */
/** Inicio  del Bloque de instancia al proceso de /readBase  */
$datos13 = array('petition'=>"POST", 'request'=>$request, 'name'=>"/readBase", 'apps'=>"Reportes", 'controller'=>"jrxml",'method'=>'readBase');
$process13 = $router->setRuta($datos13);
/** Fin del caso de /readBase */
/** Inicio  del Bloque de instancia al proceso de /createConditionStyle  */
$datos14 = array('petition'=>"GET", 'request'=>$request, 'name'=>"/createConditionStyle", 'apps'=>"Reportes", 'controller'=>"modals",'method'=>'createConditionStyle');
$process14 = $router->setRuta($datos14);
/** Fin del caso de /createConditionStyle */
/** Inicio  del Bloque de instancia al proceso de /getTypeColumn  */
$datos15 = array('petition'=>"POST", 'request'=>$request, 'name'=>"/getTypeColumn", 'apps'=>"Reportes", 'controller'=>"elements",'method'=>'getTypeColumn');
$process15 = $router->setRuta($datos15);
/** Fin del caso de /getTypeColumn */
 
?>