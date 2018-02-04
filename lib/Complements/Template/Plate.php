<?php 
namespace JPH\Complements\Template;
use JPH\Core\Commun\All;
use JPH\Core\Store\Cache;
use League\Plates\Engine;


/**
 * Clase encargada de procesar la parte de la vista con el sistema
 * @Author: Gregorio Bolívar <elalconxvii@gmail.com>
 * @Author: Blog: <http://gbbolivar.wordpress.com>
 * @Creation Date: 22/08/2017
 * @version: 0.3
 */
class Plate extends Engine
{
        public $cache;
        public $item;
        public $html;
        public function __construct()
        {
                $this->cache = new Cache();
                $this->html;
                $tm = All::DIR_THEME.$this->cache->get('dir_theme');
                parent::__construct($tm);
                    
                //echo APP;//Constant::APP_VIEWS;
                //$this->cache->get('dir_s_twig')
                 self::extendsFunction();
                //$templates = new \League\Plates\Engine($this->cache->get('dir_d_twig'));
                $this->addFolder('view', All::DIR_SRC.APP.All::APP_VIEWS, true);
        }

        /**
         * Permite renderizar la vista e imprimir el resultado en html en vista
         * @param array $object, valores de datos que van a la vista
         * @param boolean $cifrar, opcion para permitir cifrar html
         * @return resource $html 
         */
        public function renders($vista, $cifrar=false)
        {
        	$object=(array)self::addEnd();
                $this->html=($cifrar)?All::compressResponse($this->render($vista, $object)):$this->render($vista, $object);
                echo $this->html;
                self::addIni();
        }

        /**
         * Permite iniciar inicializar un objeto a su
         */
        public function addIni()
        {
                $this->item = null;
        }
        /**
         * Permite agregar datos 
         * @param string $key 
         * @param string $data 
         * @return resource $this
         */
        public function add($key,$data)
        {
                $this->item[$key] = $data;
        }
        /**
         * Permite devolver los datos que fueron seteados por el usuario y estan en lote
         * @return array $return
         */
        public function addEnd()
        {
                self::addExtends();
                $return=(count($this->item)<0)?$object = array():$this->item;
                return $return;
        }

        /**
         * Description
         * @return object $this
         */
        public function addExtends(){
              $this->item['Commun'] = new All();
        }

        public function extendsFunction(){
            $this->registerFunction('cache', function ($string) {
                return Cache::get($string);
            });

            /*$this->registerFunction('Store', function ($string) {
                return new JPH\Store\Store();
            });*/
        }



}