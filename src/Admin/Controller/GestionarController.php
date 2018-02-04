<?php
/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 16/09/2017
 * @version: 1.0
 */ 

namespace APP\admin\Controller;
use JPH\Core\Console\App;
use JPH\Core\Console\AppCrudVista;
use JPH\Core\Http\Request;
use JPH\Core\Load\Configuration;
use APP\Admin\Model AS Model;
use JPH\Core\Commun\{Constant,Security};


class GestionarController extends Controller
{
    public $session;
    public $model;
    public $hoConexionesModel;
    public $hoEntidadesModel;
    public $hoVistasModel;
    public $hoSegRolesModel;
    public $hoMascaraModel;
    public $segUsuariosModel;
    public $result;
    public $pathActivo;
    use Security;

    public function __construct()
   {
       parent::__construct();
       $this->session = $this->authenticated();
       $this->model = new Model\HomeModel();
       $this->hoConexionesModel = new Model\HoConexionesModel();
       $this->hoEntidadesModel = new Model\HoEntidadesModel();
       $this->hoVistasModel = new Model\HoVistasModel();
       $this->hoSegRolesModel = new Model\SegRolesModel();
       $this->hoMascaraModel = new Model\HoMascaraModel();
       $this->hoSegUsuariosModel = new Model\SegUsuariosModel();
   }

    public function runInformarProceso($request){
       $data['msj']='Procesando la Vista:'.$this->cache->get('proceso');
       $data['proceso']=$this->cache->get('proceso');
       $data['alter'] = $this->cache->get('alter');
       $this->json($data);
   }

    /**
     * Permite gestionar la parte de configuraciones de la definicion de los elementos
     * @param resource $request
     * @return static $tpl html de la plantilla
     */
   public function runGestionar($request)
    {
        $this->tpl->addIni();
        $this->tpl->add('usuario', $this->getSession('usuario'));
        $this->tpl->renders('view::home/gestionar');
    }

    /**
     * Proceso encargado de controlar la generacion de la vistas luego de leer la base de datos de las configuraciones
     * @param resource $request
     * @return \JsonSerializable $ $dataJson
     */
    public function runProcesarCrudVistas($request)
   {
       $user=$this->getSession('usuario');
       // Definicion de todas las vistas disponibles en el sistema
       $schema = $this->hoVistasModel->extraerDetalleEntidadListado((array)$request->postParameter());

      // $this->pp($schema);
       if(count($schema)>0) {
           foreach ($schema AS $entidad => $views) {
               $columnsReal = NULL;
               $columnsReal = $views['columnas'];
               unset($views['columnas']);
               //print_r($columnsReal);die();
               // sleep(20);

               foreach ($views AS $nombreVista => $campos) {
                   //$this->pp($views);
                   if (count($campos) > 0) {
                       // Nombre de la Aplicacion seleccionada
                       $aplicativo = @$campos[0]->apps;

                       // Instanciar la clase de generacion de vista
                       $crudVista = new AppCrudVista();

                       // Mascaras disponibles dentro del sistemas para poder hacer comparacion con los definidos en la vista
                       $mascaras = $this->hoMascaraModel->getMascarasShowVista($nombreVista);

                       //$this->pp($mascaras);

                       // Crear estructura de la vista
                       $crudVista->createStructuraFileCRUD($aplicativo, $nombreVista, $entidad, $campos, $columnsReal, $mascaras);

                       // Actualizar el registro donde se notifica que ya fue generado
                       $this->hoVistasModel->updateStatusVista($aplicativo, $campos[0]->conexiones_id, $entidad, $nombreVista);

                       // Asignacion de roles para la vista creada
                       $this->hoSegRolesModel->setSegRolesGeneradorVistaAcceso($campos[0]->apps, $campos[0]->entidad, $campos[0]->nombre);
                   }
               }
               // Elemto encargado de procesar los roles automaticos de usuarios
           }
           // Refrescar datos
           $data = $this->hoSegUsuariosModel->reCargarRoles($user->id);
           $this->setSession('roles', $data);

           $result = true;
           if (is_null($result)) {
               $dataJson['error'] = '1';
               $dataJson['msj'] = 'Error en generar el sistema';
           } else {
               $dataJson['error'] = '0';
               $dataJson['msj'] = 'Todo fue procesado exitosamente';

           }
       }else{
           $dataJson['error'] = '1';
           $dataJson['msj'] = 'Uff!, debe tener al menos una vista generada.';
       }
       $this->json($dataJson);
   }

    public function runConfiguracionConexiones($request)
    {
        $this->verificarConfiguracionDataBase();
        if(empty(@$request->postParameter('conexion'))) {
            $dataJson['data'] = $schema=$this->hoConexionesModel->getExtraerConexiones();
            $dataJson['items'] = count($schema);
            $this->json($dataJson);
        }else{
            $dataJson['data'] = $schema=$this->hoConexionesModel->getExtraerConexiones($request->postParameter('conexion'));
            $dataJson['items'] = count($schema);
            $this->json($dataJson);
        }

    }

    /**
     * Permite registrar las entidades seleccionadas dependiendo de la conexion
     * @param request $request
     * @param \JsonSerializable $return
     */
    public function runSetEntidadesProcesar($request)
    {
        $result = $this->hoEntidadesModel->registrarEntidadesConfig($request->postParameter('db'), $request->postParameter('entidad'));
        $this->json($result);
    }

    /**
     * Verifica el archivo de configuracion de las conexiones a base de datos y si no tiene relacion con la
     * base de datos la registra para que pueda ser usada
     */
    private function verificarConfiguracionDataBase()
    {
        $conf = array();
        $temp = Configuration::fileConfigApp();
        $temp = $this->parseRutaAbsolut($temp);
        $itemsDB = parse_ini_file($temp->db,true);
        foreach ($itemsDB AS $key => $value){
            $condicion = $this->hoConexionesModel->getExtraerConexionesToken($key);
            if($condicion->existe=='NO'){
                $conf['label'] = $key;
                $conf['driver'] = $value['motor'];
                $conf['host'] = $value['host'];
                $conf['db'] = $value['db'];
                $conf['usuario'] = $value['user'];
                $conf['clave'] = $value['pass'];
                $conector = (object)$conf;
                $result=$this->hoConexionesModel->setDataBase($conector);
            }
        }
    }

    /**
     * Permite extraer el universo de entidades asociada a una conexion de base de dato
     * @param resource $request
     * @return \JsonSerializable $dataJson
     */
    public function runAllUniverso($request){
        $result=$this->hoConexionesModel->getAllUniverso($request->postParameter());
        if(is_null($result)){
            $dataJson['error']='2';
            $dataJson['msj']='No existen registros relacionados';
        }else{
            $dataJson['error']='0';
            $dataJson['data'] = $result;
        }
        $this->json($dataJson);
    }


    public function runVistaNuevaConfigurada($request)
    {
        $result=$this->hoVistasModel->setConfiguracionVistaNew($request->postParameter());
        if(is_null($result)){
            $dataJson['error']='0';
            $dataJson['msj']='¡Bien!, Registro actualizado exitosamente';
        }else{
            $dataJson['error']='0';
            $dataJson['msj']='¡Bien!, Registro efectuado exitosamente';
        }
        $this->json($dataJson);
    }

    /**
     * Permite agregar configuraciones nuevas de base de datos nuevas
     * @param resource $request, Proceso request enviado por el cliente
     * @return \JsonSerializable $dataJson
     */
    public function runSetDataBase($request){
        $conf = array();
        $fil = Configuration::fileConfigApp();
        $temp = $this->parseRutaAbsolut($fil);
        $result=$this->hoConexionesModel->setDataBase($request->postParameter());
        if(is_null($result)){
            $dataJson['error']='1';
            $dataJson['msj']='Uff!, ya el registro se encuentra registrado';
        }else{

            $itemsDB = parse_ini_file($temp->db,true);
            foreach ($itemsDB AS $key => $value){
                $conf[]=$key;
            }
            if (!in_array($request->postParameter('label'), $conf)) {
                App::createNewConexionItemApp($request->postParameter('label'), $request->postParameter('driver'), $request->postParameter('host'), $request->postParameter('db'), $request->postParameter('usuario'), $request->postParameter('clave'));
            }

            $dataJson['error']='0';
            $dataJson['msj']='¡Bien!, Registro efectuado exitosamente';
        }
        $this->json($dataJson);
    }

    /**
     * Ejecuta la todas las entidades deacuerdo a la conexion seleccionada
     * @param resource $request, todo lo que se enviea por el request definido en el router
     * @return \JsonSerializable $schema
     */
    public function runEntidadesSeleccionadas($request)
    {
        $schema=$this->hoEntidadesModel->extraerTodasLasEntidades((array)$request->postParameter());
        $this->json($schema);
    }

    public function runConfiguracionVista($request)
    {
        // stdClass Object(    [connect] => 1    [tabla] => test_abm    [vista] => 0)
        if(@$request->postParameter('vista')==0) {
            // Consulta cuando es nuevo
            $schema = $this->hoEntidadesModel->extraerDetalleEntidade((array)$request->postParameter());
        }else{
            // Consulta cuando existe la vista
            $schema = $this->hoVistasModel->extraerDetalleEntidade((array)$request->postParameter());
        }

        /*Array(    [0] => stdClass Object
        (
            [id] => 273
            [conexiones_id] => 1
            [tabla] => test_autos
            [field] => id
            [type] => int(-1)
            [nulo] => NO
            [dimension] => -1
            [restrincion] => PRI
         )
         */
        $campo = array();
        $temp = array();
        foreach ($schema AS $key => $value){
            $campo[] = array(
                'id' =>$value->id ,
                'name' =>$value->field ,
                'tipo' =>$value->type,
                'dimension' => $this->hoVistasModel->validarDimensionCampo($value->type,$value->dimension),
                'fijo' => (empty($value->fijo))?'':@$value->fijo,
                'restrincion' => $value->restrincion,
                'nombre' => (empty($value->nombre))?'':$value->nombre,
                'label' => (empty($value->label))?'':@$value->label,
                'mascara' => (empty($value->mascara))?'':@$value->mascara,
                'nulo' => $value->nulo,
                'place_holder' => (empty($value->place_holder))?'':@$value->place_holder,
                'relacionado' => (empty($value->relacionado))?0:@$value->relacionado,
                'vista_campo' => (empty($value->vista_campo))?'':@$value->vista_campo,
                'tabla_vista' => (empty($value->tabla_vista))?'':@$value->tabla_vista,
                'cart_separacion' => (empty($value->cart_separacion))?'':@$value->cart_separacion,
                'orden' => (empty($value->orden))?'':@$value->orden,
                'hidden_form' => (empty($value->hidden_form))?0:@$value->hidden_form,
                'hidden_list' => (empty($value->hidden_list))?0:@$value->hidden_list
            );
        }

        $temp['apps'] = (isset($schema[0]->apps))?$schema[0]->apps:0;
        $temp['conexion'] = $schema[0]->conexiones_id;
        $temp['tabla'] = $schema[0]->entidad;
        $temp['columns'] = $campo;
        $dataJson[] = $temp;
        $this->json($dataJson);
    }

    public function runShowVista($request)
    {
        $dataJson = $this->hoVistasModel->getShowVista($request->postParameter());
        $this->json($dataJson);
    }

    public function runGetVistasColumns($request){
        $dataJson = $this->hoVistasModel->getShowVistaRow($request->postParameter());
        $this->json($dataJson);
    }

    /**
     * Permite visualizar las aplicaciones que existen dentro del sistema
     */
    public function runGetListApp(){
        $list = array_diff(scandir(Constant::DIR_SRC), array('..', '.'));
        $a = 0;
        $valor=false;
        foreach ($list AS $key => $value){
            $valor[$a]=$value;
            $a++;
        }
        $dataJson['seleApps']=$valor;
        $this->json($dataJson);
    }

    public function runCreateTablas($request)
    {
        $result = $this->hoEntidadesModel->setEstructuraCreateTabla($request->postParameter());
        if(is_null($result)){
            $dataJson['error']='1';
            $dataJson['msj']='Uff, ya el registro se encuentra registrado';
        }else{
            $dataJson['error']='0';
            $dataJson['msj']='Bien, entidad creada exitosamente';
        }
        $this->json($dataJson);
    }

    public  function runGetEntidadComun($request)
    {
        $dataJson = $this->hoConexionesModel->getExtraerDetallesComun((array)$request->postParameter());
        $this->json($dataJson);
    }

}
?>
