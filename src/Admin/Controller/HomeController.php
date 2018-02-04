<?php
/**
 * Generador de codigo de Controller de Hornero 0.8
 * @propiedad: Hornero 0.8
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 04/08/2017
 * @version: 1.0
 */

namespace APP\Admin\Controller;
use JPH\Core\Commun\Security;

class HomeController extends Controller{
     public $model;
     public $session;
     public $result;
     use Security;

     public function __construct()
     {
         parent::__construct();
         $this->session = $this->authenticated();
     }
     /**
      * Method encargado de mostrar la pantalla de inicio del sistema
      * @param resource $request
      * @return \JsonSerializable $view
      */
     public function runIndex($request)
     {
         //echo session_id();
         $this->tpl->addIni();
         $this->tpl->add('usuario', $this->getSession('usuario'));
         $this->tpl->renders('view::home/home');
     }
}
?>