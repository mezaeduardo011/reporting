<?php
namespace JPH\Core\Load;
use JPH\Core\Store\Cache;
use JPH\Core\Commun\All;

/**
 * Clase de configuracion encargado de gestionar el core del sistema que permite la integracion entre 
 * las acciones externa con el interior del sistema
 * @Author: Gregorio Bolívar <elalconxvii@gmail.com>
 * @Author: Blog: <http://gbbolivar.wordpress.com>
 * @Creation Date: 25/07/2017
 * @version: 0.7
 */


class Configuration extends Cache
{

    public $cache;
    public $file;
    public $class;
    public $fold;
    public $app;
    public $active;

    /**
     * Constructur encargado de gestionar
     */
    public function __construct($application, $proceso)
    {
        $this->active = 'Core';
        try{
            self::validateVerLoad();
            // Agregar variable global para que el cache recibe del controlador frontal
            $this->app = All::upperCase($application);
            define('APP', $this->app);
            parent::__construct();

            $this->file = $this->app . All::onlyClassActive(__CLASS__) . '.php';
            $this->class = $this->app . All::onlyClassActive(__CLASS__);
            $this->fold = All::DIR_SRC . $this->app . '/' . All::APP_ROUTE . '/';


        // Read configuration variables app.ini
        $variable = self::fileConfigApp();
        unset($variable['db']);
        foreach ($variable as $strFileName) {

            file_exists($strFileName) ? $objFopen = parse_ini_file($strFileName, true) : die("<strong>Uff:</strong> Se encontro el siguiente error:<ul><li> Clase: " . __CLASS__ . '.<br> En el Method: ' . __METHOD__ . '.<br/> En la Linea: ' . __LINE__ . '<br/> El achivo: <b>' . $strFileName . '</b>.<br>Nota: <b>Problema de ruta del Archivo no se encuentra.</b></li><ul>');

           /* try {
                if (empty($objFopen['default'])) {
                    // Lanza una excepción si el email no es válido
                    //throw new Exceptions()->setMessage('HOLLLLLL');
                    $exp = new Exceptions();
                    $exp->setMessages('HOLLLLLL');
                    throw $exp;
                }
            } // Iniciamos el bloque catch
            catch (Throwable $t) {
                // Muestra el mensaje que hemos customizado en Exceptions:
                echo $t->errorMessage();

            }*/

            // Check if there is a configuration file of the application module.
            $file = All::DIR_SRC . $this->app . '/' . All::APP_ROUTE . '/' . $this->file;

            if (!file_exists($file)) {
                die(sprintf('The application "%s" does not exist.', $this->app));
            }

            // Load the configuration values for the default block
            //if(empty($objFopen['default'])){ throw new Exception('Los valores ingresados no son numéricos'); return 0;}
            foreach ($objFopen['default'] AS $key => $value):
                Cache::set($key, $value);
            endforeach;

            // Load the configuration values for the load block
            foreach ($objFopen[$this->app] AS $key => $value):
                // VERIFICAR QUE LA CONFIGURACION CUMPLE EL FORMATO
                Cache::set($key, $value);
            endforeach;
            # code...


        }

        switch ($proceso):
            case 'stable':
                //require_once $file;
                //$loadRouter = new $this->class;
                //$loadRouter->Configure($app, $fold);
                break;

            case 'mant':
                //$commun = new CommunController();
               // $dir1 = $this->getCache('dir_m_twig');
               // $dir2 = $this->getCache('dir_d_twig');
               // $this->twig = $commun->communIniTemplate($dir1, $dir2);
              //  echo $this->twig->render('baseMant.twig', $commun->initSendDataTwig());
                break;
            default:
                All::modDevelopment();
                //$this->templates = new \League\Plates\Engine(Store::get('dir_d_twig'));
                //$this->templates->addFolder('theme1', Store::get('dir_s_twig'), true);
                //require_once $file; APP\Admin\AdminConfiguration
                $temp = '\APP\\' . $this->app . '\Router\\' . $this->class;
                $loadRouter = new $temp;
                $loadRouter->initApp($this->app, $this->fold);
                break;
        endswitch;
        }
        catch (\TypeError $t) {
            // Muestra el mensaje que hemos customizado en Exceptions:
            die($t->getMessage());
        }
    }

    public static function fileConfigApp()
    {

        $variable['app'] = All::DIR_CONFIG . "app.ini";
        $variable['view'] = All::DIR_CONFIG . "view.ini";
        $variable['db'] = All::DIR_CONFIG . "databases.ini";
        return $variable;
    }

    /**
     * Permite validar si el sistema tiene la version de php minima requerida
     */
    private function validateVerLoad()
    {
            if (version_compare(PHP_VERSION, All::PHP_VER_REQ) <= 0) {
                $obj = array('php_ver_act' => PHP_VERSION, 'php_ver_req' => All::PHP_VER_REQ);
                $msj = All::getMsjException($this->active, 'req-ver-php',$obj);
                throw new \TypeError($msj);
            }
    }


}

?>