<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\{
    All, Constant, Security
};

/**
 * Generador de codigo del Modelo de la App Admin para el modelo del menu
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 23/11/2017
 * @version: 1.0
 */ 

class HoMenuModel extends Main
{
    use Security;
   public function __construct()
   {
       $this->tabla = 'ho_menu';
       $this->campoid = array('id');
       $this->campos = array('app','entidad','vista','nombre','icon_fa','targe','ho_menu_id','created_usuario_id','updated_usuario_id','created_at','updated_at');
       parent::__construct();
       $this->segUsuariosPerfilModel = new SegUsuariosPerfilModel();
       $this->segPerfilMenuModel = new SegPerfilMenuModel();
       $this->segLogAccionesModel = new SegLogAccionesModel();
   }

   /**
    * Crear registros nuevos de SegUsuarios
    * @param: Array $datos
    * @return array $tablas
    */
   public function setHoMenuCreate($datos)
   {
       $user = $this->getSession('usuario');
       $contenido = json_encode($datos['menu']);
       $this->fijarValor('app',$datos['appMenu']);
       $this->fijarValor('label',$datos['label']);
       $this->fijarValor('contenido', $contenido);
       $this->fijarValor('created_usuario_id',$user->id);
       $this->fijarValor('created_at',All::now());
       $this->guardar();
       $menuId = $this->lastId();
       $this->segPerfilMenuModel->setSegPerfilRelacionMenuCreate($datos['perfil'],$menuId);

       // Registra log de auditoria de registro de acciones
       $user = $this->getSession('usuario');
       $this->segLogAccionesModel->cargaAcciones($this->tabla, $menuId, serialize($datos['menu']),'',$user->id,Constant::LOG_ALTA);

       return $this;
   }

   /**
    * Permite ver todas las aplicaciones del sistema
    * @return array $datos, solo las aplicaciones que tiene acceso del primer nivel
    */
   public function reCargarMenuApp()
   {
       $sql = "select app FROM ho_menu GROUP BY app";
       $datos=$this->executeQuery($sql);
       return $datos;
   }

    /**
     * Permite ver el item principal del menu
     * @param String $app, identificador del usuario que inicia session
     * @return array $datos, solo los item del primer menu
     */
    public function reCargarMenuPrimer($app,$entidad)
    {
        $sql = "select app, entidad, vista, nombre, icon_fa, targe FROM ho_menu WHERE app='$app' AND entidad='$entidad' AND ho_menu_id is null;";
        $datos=$this->executeQuery($sql);
        return $datos;
    }

    /**
     * Permite ver las aplicaciones que tiene acceso los usuarios
     * @param Array $perfilId, identificador del usuario que inicia session
     * @return array $datos, solo las item del segundo menu
     */
    public function reCargarMenuSegundo($app,$entidad,$vista)
    {
        $sql = " select app, entidad, vista, nombre, icon_fa, targe FROM ho_menu WHERE app='$app' AND entidad='$entidad' AND vista='$vista'";
        $datos=$this->executeQuery($sql);
        return $datos;
    }

   /**
    * Permite ver las el contenido del menu al cual esta asociado la persona
    * @param string $app, identificador de la aplicacion que tiene acceso en el menu
    * @param integer $userId, identificador del usuario que inicia session
    * @return array $datos, solo el menu cumpleto con las acciones
    */
   public function reCargarMenuCompleto($app,$userId)
   {
       $sql = "SELECT DISTINCT c.id, c.app, c.label, CONVERT(varchar(400) ,c.contenido) as contenido FROM seg_usuarios_perfil AS a INNER JOIN seg_perfil_ho_menu AS b ON a.seg_perfil_id=b.seg_perfil_id INNER JOIN ho_menu AS c ON c.id=b.ho_menu_id WHERE seg_usuarios_id=$userId AND c.app='$app'";
       $datos=$this->executeQuery($sql);
       return $datos;
   }

    /**
     * Permite verificar la existencia de un menu principal dentro de la entidad
     * @param string $app, identificador de la aplicacion que tiene acceso en el menu
     * @param string $entidad, identificador de la entidad que tiene proceso del menu
     * @return array $datos, retorna SI o NO
     */
    public function reVerificarSiExisteMenu($app,$entidad)
    {
        $sql = "SELECT id, app, entidad, vista, nombre, icon_fa, targe, ho_menu_id FROM ". $this->tabla." WHERE app='$app' AND entidad='$entidad' AND ho_menu_id IS NULL";
        $datos=$this->executeQuery($sql);
        return $datos;
    }

    /**
     * Permite verificar la existencia el sub menu dentro de la entidad
     * @param string $app, identificador de la aplicacion que tiene acceso en el menu
     * @param string $entidad, identificador de la entidad que tiene proceso del menu
     * @param string $vista, Vista a la cual se va a conectar
     * @return array $datos, retorna SI o NO
     */
    public function reVerificarSiExisteSubMenu($app,$entidad,$vista)
    {
        $sql = "SELECT id, app, entidad, vista, nombre, icon_fa, targe, ho_menu_id FROM ". $this->tabla." WHERE app='$app' AND entidad='$entidad' AND vista='$vista'";
        $datos=$this->executeQuery($sql);
        return $datos;
    }


   public function setMenu($app,$entidad,$vista,$opt='subMenu')
   {
       $user = $this->getSession('usuario');
       $this->fijarValor('app',$app);
       $this->fijarValor('entidad',$entidad);
       $this->fijarValor('nombre',$entidad);
       $this->fijarValor('icon_fa','fa-angle-down');
       $this->fijarValor('created_usuario_id',$user->id);
       $this->fijarValor('created_at',All::now());
       $this->guardar();
       $menuId = $this->lastId();
       if($opt==subMenu){
           self::setSubMenu($menuId,$app,$entidad,$vista);
       }
   }

   public function setSubMenu($menuId,$app,$entidad,$vista)
   {
       $user = $this->getSession('usuario');
       $this->fijarValor('app',$app);
       $this->fijarValor('entidad',$entidad);
       $this->fijarValor('vista',$vista);
       $this->fijarValor('nombre',$vista);
       $this->fijarValor('icon_fa','fa-bars');
       $this->fijarValor('targe','_self');
       $this->fijarValor('ho_menu_id',$menuId);
       $this->fijarValor('created_usuario_id',$user->id);
       $this->fijarValor('created_at',All::now());
       $this->guardar();
       $menuId = $this->lastId();
   }

    /**
     * Permite actualizar los datos del item del submenu
     * @param Integer $hoMenuId, Identificador del submenu
     * @param String $apps, Aplicacion donde se actualiza el menu
     * @param String $entidad, Entidad que se tiene la vista
     * @param String $vista, el nombre real de la vista
     * @param String $nombreUrl, nombre de la vista a mostrar en el menu
     * @param String $iconoUrl, iconos a mostrar en el item submenu
     * @param String $targetUrl, indicar en que parte se habre el menu en el misma pagina o fuera
     * @return Bool $save
     */
    public function setUpdateSubMenu($hoMenuId,$apps,$entidad,$vista,$nombreUrl,$iconoUrl,$targetUrl)
    {
        $user = $this->getSession('usuario');
        $this->fijarValor('id',$hoMenuId);
        $this->fijarValor('app',$apps);
        $this->fijarValor('entidad',$entidad);
        $this->fijarValor('vista',$vista);
        $this->fijarValor('nombre',$nombreUrl);
        $this->fijarValor('icon_fa',$iconoUrl);
        $this->fijarValor('targe',$targetUrl);
        $this->fijarValor('updated_usuario_id',$user->id);
        $this->fijarValor('updated_at',All::now());
        $save = $this->guardar();
        return $save;
    }

    /**
     * Permite actualizar los datos del item del menu principal
     * @param Integer $hoMenuId, Identificador del submenu
     * @param String $apps, Aplicacion donde se actualiza el menu
     * @param String $entidad, Entidad que se tiene la vista
     * @param String $nombreUrl, nombre de la vista a mostrar en el menu
     * @param String $iconoUrl, iconos a mostrar en el item submenu
     * @return Bool $save
     */
    public function setUpdateMenuPrincipal($hoMenuId,$apps,$entidad,$nombreUrl,$iconoUrl)
    {
        $user = $this->getSession('usuario');
        $this->fijarValor('id',$hoMenuId);
        $this->fijarValor('app',$apps);
        $this->fijarValor('entidad',$entidad);
        $this->fijarValor('nombre',$nombreUrl);
        $this->fijarValor('icon_fa',$iconoUrl);
        $this->fijarValor('updated_usuario_id',$user->id);
        $this->fijarValor('updated_at',All::now());
        $save = $this->guardar();
        return $save;
    }

}
?>
