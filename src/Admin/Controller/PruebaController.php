<?php
namespace APP\Admin\Controller;
use JPH\Core\Commun\Security;
use APP\Admin\Model AS Model;

/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 15/11/2017
 * @version: 2.0
 */ 

class PruebaController extends Controller
{
   use Security;
   public $model;
   public $session;

   // Variables de Seguridad asociado a los roles
   private $apps;
   private $entidad;
   private $vista;
   private $permisos;
   public $comps;

   public function __construct()
   {
       parent::__construct();
       $this->session = $this->authenticated();
       $this->hoPruebaModel = new Model\PruebaModel();
       $this->valSegPerfils = new Model\SegUsuariosPerfilModel();
       $this->apps = $this->pathApps(__DIR__);
       $this->entidad = $this->hoPruebaModel->tabla;
       $this->vista = $this->pathVista();
       $this->comps = $this->apps .' - '. $this->entidad .' - '. $this->vista;
   }

    /**
    * Listar registros de Prueba
    * @param: GET $resquest
    */ 
   public function runPruebaIndex($request)
   {
       // Validar roles de acceso;
     $this->permisos = 'CONSULTA|CONTROL TOTAL';
     $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos));
     $this->tpl->addIni();
     $this->tpl->add('usuario', $this->getSession('usuario'));
     $this->tpl->renders('view::vistas/prueba/'.$this->pathVista().'/index');
   }

    /**
    * Listar registros de Prueba
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runPruebaListar($request)
   {
      // Validar roles de acceso;
      $this->permisos = 'CONSULTA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      // Bloque de proceso de la grilla
      $result = $this->formatRows($request->getParameter('obj'));

      $rows = $this->hoPruebaModel->getPruebaListar($request->getParameter(),$result);
      //$valor = array();
      //$valor['head']=$result['campos'];
       //$valor['rows']=$rows;
       //$this->json($valor);
      $this->xmlGridList($rows);
   }

    /**
    * Crear registros de Prueba
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runPruebaCreate($request)
   {
       // Verificar permisologia
      $this->permisos = 'ALTA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      // Verificar las mascaras
      parent::runValidarMascarasVista($this->pathVista(),$request->postParameter());

      $result = $this->hoPruebaModel->setPruebaCreate($request->postParameter());
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
    * Ver registros de Prueba
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runPruebaShow($request)
   {
       // Verificar permisologia
      $this->permisos = 'CONSULTA|CONTROL TOTAL';

      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);
      $result = $this->hoPruebaModel->getPruebaShow($request->postParameter());
      $this->json($result);
   }

    /**
    * Eliminar registros de Prueba
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runPruebaDelete($request)
   {
       // Verificar permisologia
      $this->permisos = 'BAJA|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      $result = $this->hoPruebaModel->remPruebaDelete($request->postParameter());
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
    * Actualizar registros de Prueba
    * @param: POST $resquest
    * @return: JSON $result
    */ 
   public function runPruebaUpdate($request)
   {
       // Verificar permisologia
      $this->permisos = 'MODIFICACION|CONTROL TOTAL';
      $this->validatePermisos($this->valSegPerfils->valSegPerfilRelacionUser($this->comps,$this->permisos),true);

      // Verificar las mascaras
       parent::runValidarMascarasVista($this->pathVista(),$request->postParameter());

       $result = $this->hoPruebaModel->setPruebaUpdate($request->postParameter());
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
