<?php
namespace APP\Reportes\Controller;
// use JPH\Core\Commun\Security;
// use APP\Admin\Model AS Model;
/**
 * Generador de codigo de Controller de Hornero 4
 * @propiedad: Hornero 4
 * @autor: Ing. Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 11/12/2017
 * @version: 1.0
 */
class JrxmlController extends Controller
{

    private $doc;

    public function __construct()
    {
        parent::__construct();
        $this->doc = new \DOMDocument;
        $this->doc->saveXML();
    }
    public function addTag($request)
    {
        $xml =  str_replace('xmlns=""', '',  $request->postParameter('xml'));
        $this->doc->loadXML($xml);
        $this->saveJrxml();
    }

    public function saveJrxml()
    {
        $this->doc->saveXML();
        $this->doc->save('D:/Documents/test.jrxml');
    }

    public function  readBase(){
        return file_get_contents("/reportes.php/reporte/baseXml.xml");
    }
}
?>
