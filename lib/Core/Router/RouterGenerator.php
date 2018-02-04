<?php
namespace JPH\Core\Router;
use JPH\Core\Commun\All;
use JPH\Core\Commun\Logs;
use JPH\Core\Http\Request;

/**
 * Permite encargarse de procesar las rutas generadas que se cumpla su proceso de peticion de request
 * @Property: hornero
 * @Author: Gregorio Bolívar <elalconxvii@gmail.com> <http://gbbolivar.wordpress.com/>
 * @package: RouterGenerator.php
 * @version: 4.2
 */

class RouterGenerator
{
    public $req, $url, $mod, $app, $met, $obj, $class, $file, $requestUrl, $petition;
    use Logs;

    /**
     * Method encargado de encargarse de procesar las rutas del servicio permitiendo asi mejorar las rutas
     * @param array $datos, array('petition'=>'GET', 'request'=>$_SERVER, 'name'=>'/login','apps'=>'admin', 'controller'=>'loginController','method'=>'runIndex')
     */
    public function setRuta(array $datos)
    {
        // Request del valor Session
        $this->req = (object)$datos['request'];
        // Nombre del router a procesar
        $this->url = $datos['name'];
        // Clase del Controlador donde procesara los datos
        $this->mod = $datos['controller'];
        // Aplicacion donde buscara el controlador
        $this->app = $datos['apps'];
        // Method de la clase que va a instanciar
        $this->met = $datos['method'];
        $this->petition = $datos['petition'];

        $this->obj = NULL;
        $this->class = NULL;
        $this->file = NULL;
        $this->requestUrl = isset($this->req->PATH_INFO) ? $this->req->PATH_INFO : '/';

        try{
            switch ($this->requestUrl)
            {
                case $this->url :
                    $this->class = All::upperCase($this->mod) . 'Controller';
                    $this->activ = All::upperCase($this->app) . DIRECTORY_SEPARATOR. 'Controller'.DIRECTORY_SEPARATOR . All::upperCase($this->mod) . 'Controller.php';
                    $this->file = All::DIR_SRC. $this->activ ;

                    $mthod = $this->met;
                    if (!file_exists($this->file)) {
                        $obj = array('controller' => $this->activ, 'method' => $mthod);
                        $msj = All::getMsjException('Core', 'error-cargar-ruta',$obj);
                        $this->logError($msj);
                        throw new \TypeError($msj);
                    }

                    //include_once $file;
                    $this->temp = '\APP\\'.$this->app.'\Controller\\'.$this->class;
                    //$obj = new $this->temp;
                    //var_dump(class_exists($this->temp)); die();
                    if (class_exists($this->temp)) {
                        $obj = new $this->temp;
                    }else{
                        $tmp = array('controller'=>$this->activ, 'class'=>$this->class);
                        $msj = All::getMsjException('Core', 'class-no-existe',$tmp);
                        $this->logError($msj);
                        throw new \TypeError($msj);
                    }
                    
                    // Verificamos si el method es GET
                    if($this->petition==ALL::METHOD_GET AND $this->req->REQUEST_METHOD==ALL::METHOD_GET){
                        if(method_exists($obj,$mthod)){
                            $req = New Request();
                            $obj->$mthod($req);
                        }else{
                            All::statusHttp(404);
                            $tmp = array('controller'=>$this->activ, 'method'=>$mthod);
                            $msj = All::getMsjException('Core', 'method-no-existe',$tmp);
                            $this->logError($msj);
                            throw new \TypeError($msj);
                        }
                        // Validar XSRF-TOKEN
                    //print_r(getallheaders());
                    // Verificamossi el method es POST
                    }elseif($this->petition==ALL::METHOD_POST AND $this->req->REQUEST_METHOD==ALL::METHOD_POST){
                        if(method_exists($obj,$mthod)) {
                            $req = New Request();
                            $obj->$mthod($req);
                        }else{
                            All::statusHttp(404);
                            $tmp = array('controller'=>$this->activ, 'method'=>$mthod);
                            $msj = All::getMsjException('Core', 'method-no-existe',$tmp);
                            $this->logError($msj);
                            throw new \TypeError($msj);
                        }

                    }else{
                        $tmp = array('methodActivo'=>$this->req->REQUEST_METHOD, 'methodRequerid'=>$this->petition);
                        All::statusHttp(405);
                        $msj = All::getMsjException('Resquest', '405',$tmp);
                        $this->logError($msj);
                        throw new \TypeError($msj);
                    }

                    break;
            }
        }catch(\TypeError $t){
            die($t->getMessage());
        }

    }


}

?>