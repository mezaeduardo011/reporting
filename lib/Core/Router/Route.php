<?php
namespace JPH\Core\Router;
use JPH\Core\Commun\{
    All, Commun, Logs
};
/**
 * Clase encargadad de procesar las rutas del sistema
 * @author: Gregorio Bolívar <elalconxvii@gmail.com>
 * @author: Blog: <http://gbbolivar.wordpress.com>
 * @created Date: 31/07/2017
 * @version: 0.9
 */

class Route 
{
    
    protected $routes = array();
    protected $routesTMP = array();
    protected $rulesWeb;
    use Logs;
    /**
     * Constructor de la clase que permite obtener los datos del configuracion de la ruta
     * @param string $application, Aplicacion que esta lavantando las rutas
     * @param array $config, arreglo del los campos configurados en el xml  
     * @return $this
     */

    function __construct($application, $config) 
    {
        try{
            $this->rulesWeb=(!empty($_SERVER['PATH_INFO']))?$_SERVER['PATH_INFO']:$_SERVER['REQUEST_URI'];
            //print_r($this->rulesWeb);
            foreach ($config as $route) {
               
                //[name] => /perso [controller] => home [method] => runIndex [request] => GET|POST
                $this->routes[] = array('objeto' => 
                                            array('name' => $route->name, 
                                                  'controller' => $route->controller,
                                                  'method' => $route->method,
                                                  'request' => $route->request
                                            )
                                    );
                $tmp = (array)$route->name;
                $this->routesTMP[] = $tmp[0];
                
            }
            
            //Permite verificar si la ruta solicitada existe dentro de las rutas antes de crearla
            $tmp=(bool)in_array($this->rulesWeb,$this->routesTMP);
            if($tmp){
                self::constructRules($application, $this->routes);
                self::getAction($application);
            }else{
                $obj = array('app' => $application);
                $msj = All::getMsjException('Core', 'ruta-no-existe',$obj);
                $this->logError($msj);
                throw new \TypeError($msj);
            }
        
        }catch(\Throwable $t){
            Commun::statusHttp(404);
            $this->logError($t->getMessage());
            die($t->getMessage());
        }
        return $this;
    }

    public function constructRules($application, $routes)
    {
        // Construimos automaticamente el archivo ConfigDatabaseTMP.php
        self::constructConfigRules($application, $routes);
        // Validamos que el archivo temporal creado anteriormente sea el mismo de la conexion de lo contrario procedemos a copiar el tmp
        self::validateFileIdentico($application);
      
    }
    static public function getAction($application) 
    {
        // Crar un archivo de cache donde tiene las rutas y permitir validar el mismo si existe
        $app = ucfirst($application);
        $file = All::DIR_SRC . $app .All::APP_CACHE.DIRECTORY_SEPARATOR . $app.'Router.class.php';
        if (file_exists($file)) {
            try{
                include_once $file;
                return true;
            }
            catch (\TypeError $t) {
                // Muestra el mensaje que hemos customizado en Exceptions:
                die($t->getMessage());
               
            }
        }else{ return false;}
    }    
    static public function constructConfigRules($application, $option)
    {
        
        $app = ucfirst($application);
        $ar = fopen(All::DIR_SRC . $app .DIRECTORY_SEPARATOR.All::APP_CACHE.DIRECTORY_SEPARATOR . $app . "Router.classTMP.php", "w+") or die("Problemas en la creaci&oacute;n del router del apps " . $application);
            // Inicio la escritura en el activo
        fputs($ar, ' <?php');
        fputs($ar, "\n");
        fputs($ar, ' use JPH\\Core\\Router\\RouterGenerator;');
        fputs($ar, "\n");
        fputs($ar, '/**');
        fputs($ar, "\n");
        fputs($ar, ' * @propiedad: PROPIETARIO DEL CODIGO');
        fputs($ar, "\n");
        fputs($ar, ' * @Autor: Gregorio Bolivar');
        fputs($ar, ' * @email: elalconxvii@gmail.com');
        fputs($ar, "\n");
        fputs($ar, ' * @Fecha de Creacion: ' . date('d/m/Y') . '');
        fputs($ar, "\n");
        fputs($ar, ' * @Auditado por: Gregorio J Bolívar B');
        fputs($ar, "\n");
        fputs($ar, ' * @Descripción: Generado por el generador de codigo de router de webStores');
        fputs($ar, ' * @package: datosClass');
        fputs($ar, "\n");
        fputs($ar, ' * @version: 1.0');
        fputs($ar, "\n");
        fputs($ar, ' */'); 

        fputs($ar, "\n");
        // capturador del get que esta pasando por parametro
        //fputs($ar, '@$solicitud = explode(\'/\',$_SERVER[\'PATH_INFO\']);');
        fputs($ar, "\n");
        fputs($ar, '$request = $_SERVER;');
        fputs($ar, "\n");
        fputs($ar, '$router = new RouterGenerator();');
        fputs($ar, "\n");

        foreach ($option AS $cont => $routes):
            foreach ($routes AS $route):
                $action = strtolower(self::validarMethods($route['request'])); 
                fputs($ar, '/** Inicio  del Bloque de instancia al proceso de ' . $route['name'] . '  */');
                fputs($ar, "\n");
                fputs($ar, '$datos' . $cont . ' = array(\'petition\'=>"'.$route['request'].'", \'request\'=>$request, \'name\'=>"' . $route['name'] . '", \'apps\'=>"' . $app . '", \'controller\'=>"' . $route['controller'] . '",\'method\'=>\'' . $route['method'] . '\');');
                fputs($ar, "\n");
                fputs($ar, '$process' . $cont . ' = $router->setRuta($datos' . $cont . ');');
                fputs($ar, "\n");
                fputs($ar, '/** Fin del caso de ' . $route['name'] . ' */');
                fputs($ar, "\n");
                endforeach;
            endforeach;

            fputs($ar, " \n");
            fputs($ar, "?>");
        // Cierro el archivo y la escritura
            fclose($ar);
            return true;
        }

        public function validateFileIdentico($application)
        {
              $app = ucfirst($application);
              $fileCofNol = All::DIR_SRC . $app . DIRECTORY_SEPARATOR.All::APP_CACHE.DIRECTORY_SEPARATOR . $app . "Router.class.php";
              $fileTmpNol = All::DIR_SRC . $app . DIRECTORY_SEPARATOR.All::APP_CACHE.DIRECTORY_SEPARATOR . $app . "Router.classTMP.php";
              $fileCofMd5 = md5(@file_get_contents($fileCofNol));
              $fileTmpMd5 = md5(file_get_contents($fileTmpNol));
              if($fileCofMd5 != $fileTmpMd5)
              {
                    copy($fileTmpNol, $fileCofNol);
              }
            return true;
        }

        static public function validarMethods($meth){
            $dato = array('post'=>'postty','get'=>'getty');
            $disponible = array(All::METHOD_GET, All::METHOD_POST);
            if (!in_array($meth, $disponible)) {
                die('Error en el method solicitado no definido:'.$meth);
            }
            return $dato[strtolower($meth)];
        }

    public function __destruct() {

    }

}

?>