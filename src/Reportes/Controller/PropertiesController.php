<?php
namespace APP\reportes\Controller;
// use JPH\Core\Commun\Security;
// use APP\Admin\Model AS Model;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */ 
class PropertiesController extends Controller
{
   // use Security;
   // public $model;
   // public $session;
   public function __construct()
   {
       parent::__construct();
       // $this->session = $this->authenticated();
       // $this->model = new Model\HomeModel();
   }
   public function runIndex($request)
   {     $this->tpl->addIni();
     $this->tpl->add('nombre','PRUEBA DE CONTROLLER');
     $this->tpl->renders('view::home/home');
   }
}
?>
