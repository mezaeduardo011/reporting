<?php
namespace APP\Admin\Controller;
use JPH\Core\Commun\Security;
use APP\Admin\Model AS Model;

/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 25/09/2017
 * @version: 1.0
 */ 

class SegPerfilController extends Controller
{
   use Security;
   public $model;
   public $session;
   public function __construct()
   {
       parent::__construct();
       $this->session = $this->authenticated();
       $this->hoSegPerfilModel = new Model\SegPerfilModel();
       $this->hoSegPerfilRolesModel = new Model\SegPerfilRolesModel();
   }

    /**
    * Listar registros de SegPerfil
    * @param: GET $resquest
    */ 
   public function runSegPerfilIndex($request)
   {
     $this->tpl->addIni();
     $listado = $this->hoSegPerfilModel->getSegPerfilListarCombo($request->getParameter());
     $this->tpl->add('usuario', $this->getSession('usuario'));
     $this->tpl->renders('view::seguridad/segPerfil/'.$this->pathVista().'/index');
   }

    /**
     * Listar registros de SegRoles
     * @param: GET $resquest
     */
    public function runSegRolesAsignarRolesPerfil($request)
    {
        $this->tpl->addIni();
        $listado = $this->hoSegPerfilModel->getSegPerfilListarCombo($request->getParameter());
        $this->tpl->add('usuario', $this->getSession('usuario'));
        $this->tpl->renders('view::seguridad/segPerfil/perfil/asignarRolesPerfil');
    }

    /**
    * Listar registros de SegPerfil
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegPerfilListar($request)
   {
       $result = $this->formatRows($request->getParameter('obj'));
       $rows = $this->hoSegPerfilModel->getSegPerfilListar($request->getParameter(),$result);
       $valor = array();
       $valor['head']=$result['campos'];
       $valor['rows']=$rows; // return del modelo
       $this->json($valor);
   }

    /**
    * Crear registros de SegPerfil
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegPerfilCreate($request)
   {
      $result = $this->hoSegPerfilModel->setSegPerfilCreate($request->postParameter());
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
     * Crear registros de SegPerfil
     * @param: POST $resquest
     * @return: JSON $result
     */
    public function runSetAsociarRolesPerfil($request)
    {
        $result = $this->hoSegPerfilRolesModel->getSegPerfilRolesCreate($request->postParameter());
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
    * Ver registros de SegPerfil
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegPerfilShow($request)
   {
      $result = $this->hoSegPerfilModel->getSegPerfilShow($request->postParameter());
      $this->json($result);
   }

    /**
    * Eliminar registros de SegPerfil
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegPerfilDelete($request)
   {
      $result = $this->hoSegPerfilModel->remSegPerfilDelete($request->postParameter());
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
    * Actualizar registros de SegPerfil
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runSegPerfilUpdate($request)
   {
      $result = $this->hoSegPerfilModel->setSegPerfilUpdate($request->postParameter());
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
