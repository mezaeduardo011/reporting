<?php
/**
 * Clase Controller encargado de integrar muchas funcionalidades util para el controlador
 * @Author: Gregorio Bolívar <elalconxvii@gmail.com>
 * @Author: Blog: <http://gbbolivar.wordpress.com>
 * @Creation Date: 30/08/2017
 * @version: 0.1
 */
namespace APP\Admin\Controller;
use JPH\Complements\Template\Plate;
use JPH\Core\Commun\All;
use JPH\Core\Store\Cache;

class Controller extends All
{
    public $tpl;
    public $cache;
    public function __construct()
    {
        $this->tpl = new Plate();
        $this->cache = new Cache();
        return $this;
    }

    /**
     * Permite verificar las mascaras del lado del servidor para eso es necesario que tengas un json en la vista con los datos del los parametros
     * @param String $vista, Nombre de la vista que se esta ejecutando
     * @param Request $request, Request con los parametros enviados
     * @return Bool $resultado
     */
    public function runValidarMascarasVista($vista,$request)
    {
        $resultado = true;
        $tmp = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'vistas'.DIRECTORY_SEPARATOR.'prueba'.DIRECTORY_SEPARATOR.$vista.DIRECTORY_SEPARATOR.'mascaras.json');
        $data = json_decode($tmp);
        $temp = (array)$request;
        foreach ($data->mascaras AS $key=>$value){
            $campo = $value->campo;
            $patron = trim(base64_decode($value->mascaraPHP));
            $contenido = $temp[$campo];
            $matches = null;
            $validate=preg_match("/$patron/" , $contenido, $matches);
            if($validate!=1){
                $dataJson['error']='1';
                $dataJson['msj'] = 'En el campo '.$value->campo.' '.$value->mensaje;
                $this->json($dataJson);
            }
            return $resultado;
        }

    }
}