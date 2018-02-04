<?php
namespace JPH\Core\Console;
use JPH\Core\Commun\All;

class Cache
{
    public $pathapp;
    public $msj;
    public $active;
    // Constante de la clase
    const SUBITEM = __CLASS__;
    public function __construct(){
        $this->pathapp = All::DIR_SRC;
        $this->active = All::onlyClassActive(App::SUBITEM);
    }
    /**
     * Permite borrar el cache a las aplicaciones que se encuentran creadas en e sistema
     */
    public function cleanCacheApps()
    {
        $Commun = new  All();
        $tmp = $this->pathapp;
        $list = array_diff(scandir($tmp), array('..', '.'));
        $msj=Interprete::getMsjConsole('Cache','cache-clean');
        $item = array();
        if(count($list)==1){
            $ruta = $tmp.implode($list).DIRECTORY_SEPARATOR.'Cache'.DIRECTORY_SEPARATOR.'System';
            $Commun->eliminarDir($ruta);
            $item=base64_encode(All::mergeTaps($msj,array('name'=>end($list))));
        }else{
            foreach ($list as $value) {
                $ruta = $tmp.$value.DIRECTORY_SEPARATOR.'Cache'.DIRECTORY_SEPARATOR.'System';
                $Commun->eliminarDir($ruta);
                $tmp=base64_encode(All::mergeTaps($msj,array('name'=>$value)));
                $item[] =$tmp;
            }
        }
        return $item;
    }
}