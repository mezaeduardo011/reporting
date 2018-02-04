<?php
namespace APP\Admin\Controller;
 use JPH\Core\Commun\Security;
 use APP\Admin\Model AS Model;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 01/12/2017
 * @version: 1.0
 */ 
class MascaraController extends Controller
{
    use Security;
    public $model;
    public $session;

   public function __construct()
   {
       parent::__construct();
       $this->session = $this->authenticated();
       $this->hoMascaraModel = new Model\HoMascaraModel();
   }

   /**
    * Permite visualizar las mascaras disponibles
    * @param resource $request
    * @return \JsonSerializable $ $dataJson
    */
   public function runMascaraListar($request)
   {
       $dataJson['data'] = $this->hoMascaraModel->getMascarasListar();
       $this->json($dataJson);
   }

    /**
     * Permite almacenar las nuevas mascaras
     * @param resource $request
     * @return \JsonSerializable $ $dataJson
     */
   public function runMascaraCreate($request)
   {
       $result = $this->hoMascaraModel->setProductosCreate((array)$request->postParameter());
       if(is_null($result)){
           $dataJson['error']='1';
           $dataJson['msj']='Error en procesar el registro';
       }else{;
           $dataJson['error']='0';
           $dataJson['msj'] = 'Registro efectuado exitosamente';
       }
       $this->json($dataJson);
   }

    public function runMascaraShow($request)
    {
        $dataJson['data'] = $this->hoMascaraModel->getMascaraShow($request->postParameter('type'));
        $this->json($dataJson);
    }


}
?>
