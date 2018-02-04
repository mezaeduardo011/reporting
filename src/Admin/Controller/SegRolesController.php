<?php
namespace APP\Admin\Controller;
use APP\Admin\Model AS Model;;
use JPH\Core\Commun\Security;

/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 25/09/2017
 * @version: 1.0
 */ 

class SegRolesController extends Controller
{
   use Security;
   public $model;
   public $session;
   public function __construct()
   {
       parent::__construct();
       $this->session = $this->authenticated();
       $this->hoSegRolesModel = new Model\SegRolesModel();
   }

    /**
    * Listar registros de SegRoles
    * @param: GET $resquest
    */ 
   public function runSegRolesIndex($request)
   {
     $this->tpl->addIni();
     //$listado = $this->hoSegRolesModel->getSegRolesListar($request->postParameter());
     $this->tpl->add('usuario', $this->getSession('usuario'));
     $this->tpl->renders('view::seguridad/segRoles/'.$this->pathVista().'/index');
   }


    /**
    * Listar registros de SegRoles
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegRolesListar($request)
   {
       $result = $this->formatRows($request->getParameter('obj'));
       $rows = $this->hoSegRolesModel->getSegRolesListar($request->getParameter(),$result);
       $valor = array();
       $valor['head']=$result['campos'];
       $valor['rows']=$rows; // return del modelo
       $this->json($valor);
   }

    /**
    * Crear registros de SegRoles
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegRolesCreate($request)
   {
      $result = $this->hoSegRolesModel->setSegRolesCreate($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='1';
        $dataJson['msj']='Error en procesar el registro';
      }else{;
        $dataJson['error']='0';
        $dataJson['msj'] = 'Registro efectuado exitosamente';
      }
      $this->json($dataJson);
   }

    /**
    * Ver registros de SegRoles
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegRolesShow($request)
   {
      $result = $this->hoSegRolesModel->getSegRolesShow($request->postParameter());
      $this->json($result);
   }

    /**
    * Eliminar registros de SegRoles
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegRolesDelete($request)
   {
      $result = $this->hoSegRolesModel->remSegRolesDelete($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='0';
        $dataJson['msj']='Registro eliminado exitosamente';
      }else{
        $dataJson['error']='1';
        $dataJson['msj'] = 'Error en procesar la actualizacion';
      }
      $this->json($dataJson);
   }

    /**
    * Actualizar registros de SegRoles
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegRolesUpdate($request)
   {
      $result = $this->hoSegRolesModel->setSegRolesUpdate($request->postParameter());
      if(is_null($result)){
        $dataJson['error']='0';
        $dataJson['msj']='Actualizacion efectuado exitosamente';
      }else{
        $dataJson['error']='1';
        $dataJson['msj'] = 'Error en procesar la actualizacion';
      }
        $this->json($dataJson);
   }
}
?>
