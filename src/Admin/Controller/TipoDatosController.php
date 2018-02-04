<?php
namespace APP\Admin\Controller;
 use JPH\Core\Commun\Security;
 use APP\Admin\Model AS Model;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 02/12/2017
 * @version: 1.0
 */ 
class TipoDatosController extends Controller
{
    use Security;
    public $hoTipoDatosModel;
    public $session;
   public function __construct()
   {
       parent::__construct();
        $this->session = $this->authenticated();
        $this->hoTipoDatosModel = new Model\HoTipoDatosModel();
   }

   public function runTipoDatosListar()
   {
       $dataJson['data'] = $this->hoTipoDatosModel->getTipoDatosListar();
       $this->json($dataJson);
   }


    public function runTipoDatosShow($request)
    {
        $dataJson['data'] = $this->hoTipoDatosModel->getTipoDatosShow($request->postParameter('type'));
        $this->json($dataJson);
    }
}
?>
