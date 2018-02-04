<?php
namespace APP\admin\Controller;
use JPH\Core\Commun\Security;
use APP\Admin\Model AS Model;
use JPH\Core\Commun\All;
use JPH\Core\Console\App;

/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 15/11/2017
 * @version: 1.0
 */ 
class MenuController extends Controller
{
    public $hoSegUsuariosModel;
    public $hoMenuModel;
    public $segUsuarioPerfil;
    public $session;
    use Security;

    public function __construct()
   {
        parent::__construct();
        $this->authenticated();
        $this->hoSegUsuariosModel = new Model\SegUsuariosModel();
        $this->hoMenuModel = new Model\HoMenuModel();
       $this->segUsuarioPerfil = new Model\SegUsuariosPerfilModel();
   }
   
   /**
    * Permite extraer el menu asociado a un perfil para mostrar
    * @param resource $request
    * @return \JsonSerializable $this->json;
    */
   public function runRefreshMenu($request)
   {
           $user=$this->getSession('usuario');
           $perfiles = $this->getSession('usuarioPerfil');

           // Permite extraer los datos del perfil primero con el objetivo de hacer comparaciones con el menu
           //$appConMenu = $this->segUsuarioPerfil->reCargarMenuApp($perfiles);
            $appConMenu = $this->segUsuarioPerfil->reCargarMenuApp($perfiles);

           $menu = array();

           $appConMenu = self::extrerMenu($appConMenu);

           $menu['menu'] = $appConMenu;
           $this->json($menu);   
   }


   /**
    * Permite ver los perfiles disponibles para el menu
    * @param resource $request
    * @return \JsonSerializable $this->json;
    */
   public function runShowPerfil($request)
   {
       $dataJson = $this->hoSegUsuariosModel->reCargarPerfiles();
       $this->json($dataJson);
   }

   /**
    * Permite ver los perfiles disponibles para el menu
    * @param resource $request
    * @return \JsonSerializable $this->json;
    */
   public function runSetProcesarPrincipalMenu($request)
   {
       $result = '';
       // Recorrer todos los elementos que vienen del arreglos de los parametros
        foreach ($request->postParameter('id') AS $kay => $value){

            $hoMenuId = $request->postParameter('id')[$kay];
            $apps = $request->postParameter('apps')[$kay];
            $entidad = $request->postParameter('entidad')[$kay];
            $nombreUrl = $request->postParameter('nombreUrl')[$kay];
            $iconoUrl = $request->postParameter('iconoUrl')[$kay];
            $result = $this->hoMenuModel->setUpdateMenuPrincipal($hoMenuId,$apps,$entidad,$nombreUrl,$iconoUrl);

        }
       if(is_null($result)){
           $dataJson['error']='0';
           $dataJson['msj']='Actualizacion efectuado exitosamente';
       }else{
           $dataJson['error']='1';
           $dataJson['msj'] = 'Error en procesar la actualizacion';
       }
       $this->json($dataJson);
   }

    /**
     * Permite procesar el menu principal del sistema
     * @param resource $request
     * @return \JsonSerializable $this->json;
     */
    public function runSendProcesarPrincipalMenu($request)
    {
        // Permite verificar las aplicaciones existente si no tiene item a crea
        $apps = new App();
        $data = $apps->showApps();
        $tmp = explode('.',base64_decode($data));
        $dataJson = array();
        $itemPrinc = array();
        foreach($tmp AS $idx){
            if(!empty($idx))
            {
                $tmp2 = explode(',',$idx);
                $tmp3 = explode(' ',$tmp2[0]);
                $app = $tmp3[1];
                $entidad = $request->postParameter('entidad');
                $itemPrinc = $this->hoMenuModel->reVerificarSiExisteMenu($app,$entidad);
                if(empty($itemPrinc)) {
                    // No existe ningun item
                    $this->hoMenuModel->setMenu($app, $entidad, $entidad,'menuPrincipal');
                    $itemPrinc = $this->hoMenuModel->reVerificarSiExisteMenu($apps,$entidad);
                }
            }

        }


        $dataJson['itemPrinc'] = $itemPrinc;
        $this->json($dataJson);
    }

   /**
    * Permite procesar el menu para hacer el registro en base de datos de los datos luego de haber tenido configurado
    * @param resource $request
    * @return \JsonSerializable $this->json;
    */
   public function runSetGestionMenu($request){
       $hoMenuId=$request->postParameter('hoMenuId');
       $apps=$request->postParameter('apps');
       $entidad=$request->postParameter('entidad');
       $baseUrl=$request->postParameter('baseUrl');
       $nombreUrl=$request->postParameter('nombreUrl');
       $iconoUrl=$request->postParameter('iconoUrl');
       $targetUrl=$request->postParameter('targetUrl');
       // Recorrer el primer nivel para armar elementos
       $result = $this->hoMenuModel->setUpdateSubMenu($hoMenuId,$apps,$entidad,$baseUrl,$nombreUrl,$iconoUrl,$targetUrl);
       if(is_null($result)){
           $dataJson['error']='0';
           $dataJson['msj']='Actualizacion efectuado exitosamente';
       }else{
           $dataJson['error']='1';
           $dataJson['msj'] = 'Error en procesar la actualizacion';
       }
       $this->json($dataJson);
   }

   /**
    * Methodos encargado de procesar los datos del menu para verificar la existencia de los item
    * @param resource $request, peticiones hechar desde el cliente
    * @return \JsonSerializable $this->json;
    */
   public function runSetProcesarSubMenu($request){
       $dataJson = [];
       $apps = $request->postParameter('apps');
       $tablas = $request->postParameter('entidad');
       $vista = $request->postParameter('vista');
       $itemPrinc = $this->hoMenuModel->reVerificarSiExisteMenu($apps,$tablas);
       $itemSegun = $this->hoMenuModel->reVerificarSiExisteSubMenu($apps,$tablas,$vista);
       // Permite verificar la existencia de los item del menu
       if(empty($itemPrinc) AND empty($itemSegun)) {
           // No existe ningun item
           $this->hoMenuModel->setMenu($apps, $tablas, $vista);
           $itemPrinc = $this->hoMenuModel->reVerificarSiExisteMenu($apps,$tablas);
           $itemSegun = $this->hoMenuModel->reVerificarSiExisteSubMenu($apps,$tablas,$vista);

       }elseif(!empty($itemPrinc) AND empty($itemSegun)){
           // Existe el item principal menos el segundo
           $this->hoMenuModel->setSubMenu($itemPrinc[0]->id,$apps,$tablas,$vista);
           $itemSegun = $this->hoMenuModel->reVerificarSiExisteSubMenu($apps,$tablas,$vista);

       }
       $dataJson['itemPrinc'] = $itemPrinc;
       $dataJson['itemSegun'] = $itemSegun;
       $this->json($dataJson);
   }

    /**
     * Permite extraer el contenido del arreglo mutidimencional de la captura del rol de la session
     */
    public function extrerMenu($appConMenu)
    {
        // Bloque encargado de extraer el el primer parte del arreglo
        //print_r($appConMenu);
        $menu = array();
        foreach ($appConMenu AS $kry => $value1) {
            $item = explode('-', $value1->roles);
            $v = count($item) - 1;
            unset($item[$v]);
            $menu[] = trim(implode('|', $item)) ;
        }
        $bufer = array_unique($menu);

        $menu2 = array();

        $it = '';
        // Bloque de proceso del sub menu principal para sacar el item principal
        foreach ($bufer AS $key => $value2) {
            $item2 = explode('|', $value2);
            $v = count($item2) - 1;
            // nombre de la app
            $it = trim($item2[0]);
            unset($item2[0]);
            $menu2[$it][] = trim(implode('|', $item2));
        }

        $menu3 = array();
        $menu4 = array();
        $menuPrincipalCompleto = array();
        $it2 = '';

        // Bloque encargado del ultimo menu
        foreach ($menu2 AS $key3 => $value3) {
            for ($a = 0; $a < count($value3); $a++) {
                $item3 = explode('|', $value3[$a]);
                // Menu prncipal
                $it2 = trim($item3[0]);
                $menuPrincipalCompleto = $this->hoMenuModel->reCargarMenuPrimer($it,trim($item3[0]));
                $menu3[$it2]['item'] = (count($menuPrincipalCompleto)==0)?'':$menuPrincipalCompleto[0];
                // Verificar que exista el contenido el continue hace que salta la iteracion y pasa al siguiente
                if($menu3[$it2]['item']==''){ unset($menu3); continue;}
                unset($item3[0]);

                    //$menu3[$it2]['submenu'][$a] = trim(implode($item3));
                    $menuSegundoCompleto = $this->hoMenuModel->reCargarMenuSegundo($it,$it2,trim(implode($item3)));
                    $menu3[$it2]['submenu'][] = (count($menuSegundoCompleto)==0)?'':$menuSegundoCompleto[0];

            }
            $menu4[$key3]=$menu3;

        }
        return $menu4;
    }

    /**
     * Permite extraer el contenido del arreglo mutidimencional de la captura del rol de la session
     */
    public function extrerMenuBKP($appConMenu)
    {
        // Bloque encargado de extraer el el primer parte del arreglo
        $menu = array();
        foreach ($appConMenu AS $kry => $value1) {
            $item = explode('-', $value1->roles);
            $v = count($item) - 1;
            unset($item[$v]);
            $menu[] = trim(implode('|', $item)) ;
        }
        $bufer = array_unique($menu);

        $menu2 = array();


        // Bloque de proceso del sub menu
        foreach ($bufer AS $key => $value2) {
            $item2 = explode('|', $value2);
            $v = count($item2) - 1;
            $it = trim($item2[0]);
            unset($item2[0]);
            $menu2[$it][] = trim(implode('|', $item2));
        }

        $menu3 = array();
        $menu4 = array();
        // Bloque encargado del ultimo menu
        foreach ($menu2 AS $key3 => $value3) {
            for ($a = 0; $a < count($value3); $a++) {
                $item3 = explode('|', $value3[$a]);
                $it2 = $item3[0];
                unset($item3[0]);

                $menu3[$it2][] = trim(implode($item3));


            }
            $menu4[$key3]=$menu3;
        }
        return $menu4;
    }
}
?>
