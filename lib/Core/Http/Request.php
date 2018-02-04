<?php
namespace JPH\Core\Http;

/**
 * Permite contener un cunjunto de funcionalidades del protocolo http
 * @Author: Ing. Gregorio Bolívar <elalconxvii@gmail.com>
 * @Author: Blog: <http://gbbolivar.wordpress.com>
 * @created Date: 30/11/2017
 * @updated Date: 30/11/2017
 * @version: 0.1
 */

class Request
{
    public $dataPost;
    public $dataGet;
    public function __construct()
    {
        $this->dataPost;
        $this->dataGet;
        return $this;
    }
    /**
     * Permite capturar peticiones del protocolo http del proceso GET
     * @param String $index, indece para buscar dentro del objeto $_GET
     * @return \http\get $dataGet
     */
    public function getParameter($index='')
    {
        $this->dataGet = (empty($index))?(object)$_GET:$_GET[$index];
        return $this->dataGet;
    }

    /**
     * Permite capturar peticiones del protocolo http del proceso POST
     * @param String $index, indece para buscar dentro del objeto $_POST
     * @return \http\post $dataGet
     */
    public function postParameter($index='')
    {
        $this->dataPost = (empty($index))?(object)$_POST:$_POST[$index];
        return $this->dataPost;

    }

}