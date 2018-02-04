<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\{Main,Usuarios};
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 28/08/2017
 * @version: 2.0
 */ 
class LoginModel extends Main
{
    use Usuarios;

   public function __construct() 
   {
       $obj=parent::__construct();
       $this->start($obj);
   }

} 
?>