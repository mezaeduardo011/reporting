<?php
namespace APP\reportes\Controller;
// use JPH\Core\Commun\Security;
use APP\Reportes\Model AS Model;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */ 
class ElementsController extends Controller
{
   // use Security;
   public $model;
   // public $session;
   public function __construct()
   {
       parent::__construct();
       $this->model = new Model\ElementsModel();
       $this->propertiesModel = new Model\PropertiesModel();
   }
   
   public function runIndex($request)
   {     
     $this->tpl->addIni();
     $this->tpl->add('nombre','PRUEBA DE CONTROLLER');
     $this->tpl->renders('view::home/home');
   }

   public function getAllElements(){
      $this->json($this->model->getAllElements());
   }


   public function getPropertiesDefault(){
      $this->json($this->propertiesModel->getPropertiesDefault());
   }   

   public function getPropertiesByFatherId($request){
      $id = $request->getParameter('id');
      $this->json($this->propertiesModel->getPropertiesByFatherId($id));
   }      

   public function getValuesSelectById($request){
      $id = $request->getParameter('id');
      $this->json($this->propertiesModel->getValuesSelectById($id));
   }         

   
}
?>
