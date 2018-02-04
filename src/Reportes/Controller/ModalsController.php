<?php
namespace APP\Reportes\Controller;
// use JPH\Core\Commun\Security;
 use APP\Reportes\Model\ConnectionModel AS ConnectionModel;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */ 
class ModalsController extends Controller
{

   public function __construct()
   {
       parent::__construct();
       $this->ConnectionController = new ConnectionController();
   }
 
   public function staticText($request)
   {    
     $this->tpl->addIni();
     $this->tpl->renders('view::modals/staticText');
   }

   public function createConnection($request)
   {    
     $this->tpl->addIni();
     $this->tpl->renders('view::modals/createConnection');
   }

    public function tables($request)
    {
        $fieldSelected = explode(',',$request->getParameter('fieldsSelecteds'));
        $this->tpl->addIni();
        $this->tpl->add('data',$this->ConnectionController->getDescTables($request));
        $this->tpl->add('fieldSelected',$fieldSelected);
        $this->tpl->renders('view::modals/tables');
    }


}
?>
