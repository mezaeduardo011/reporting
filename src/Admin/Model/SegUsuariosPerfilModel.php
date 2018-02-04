<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 27/09/2017
 * @version: 1.0
 */ 
class SegUsuariosPerfilModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'seg_usuarios_perfil';
       $this->campoid = array('seg_perfil_id','seg_usuarios_id');
       $this->campos = array();
       parent::__construct();
   }

    /**
     * Permitir hacer registro de las relaciones de seg_usuarios con el seg_perfil en la entidad seg_usuarios_perfil
     * @param $roles roles asociados al perfil
     * @param $usuarioId usuarioId que esta relacionado
     * @return array $tablas
     */
    public function getSegPerfilRelacionUserCreate($roles,$usuarioId)
    {
        $items=explode(',',$roles);
        foreach ($items AS $key=>$value){
            $sql = "INSERT INTO ".$this->tabla." (seg_perfil_id,seg_usuarios_id) VALUES($value,$usuarioId)";
            $this->execute($sql);
        }
        return true;
    }


    /**
     * Permitir hacer registro de las relaciones de seg_usuarios con el seg_perfil en la entidad seg_usuarios_perfil
     * @param $roles roles asociados al perfil
     * @param $usuarioId usuarioId que esta relacionado
     * @return array $tablas
     */
    public function setSegPerfilRelacionUserUpdate($roles,$usuarioId)
    {
        self::remSegPerfilRelacionUserDelete($usuarioId);
        $items=explode(',',$roles);
        foreach ($items AS $key=>$value){
            $sql = "INSERT INTO ".$this->tabla." (seg_perfil_id,seg_usuarios_id) VALUES($value,$usuarioId)";
            $this->execute($sql);
        }
        return true;
    }

    /**
     * Eliminar registros de SegUsuarios
     * @param: string $id
     * @return array $tablas
     */
    public function remSegPerfilRelacionUserDelete($valor)
    {
        $sql = "DELETE FROM ".$this->tabla." WHERE seg_usuarios_id=".$valor;
        $this->execute($sql);
        return true;
    }

    /**
     * Consultar permisos de acceso del usuario
     * @param: string $roles
     * @return array $tablas
     */
    public function valSegPerfilRelacionUser($comps,$roles)
    {
        $seg = explode('|',$roles);
        $temp = strtoupper($comps.' - '.implode("','".$comps.' - ',$seg));
        $sql = "SELECT CASE WHEN COUNT(roles) > 0 THEN 'SI' ELSE 'NO' END AS permiso  FROM view_seguridad WHERE roles IN('".$temp."') ";
        $datos=$this->executeQuery($sql);
        $this->free();
        return $datos[0];
    }

    /**
     * Permite consultar los perfiles asociados a un usuario
     * @param Int $id, identificador del usuario
     * @return Array $datos
     */
    public function getPerfilesAsociados($id)
    {
        $sql = "SELECT seg_perfil_id FROM seg_usuarios_perfil WHERE seg_usuarios_id = $id";
        $datos=$this->executeQuery($sql);
        $this->free();
        return $datos;
    }


    /**
     * Permite ver las aplicaciones que tiene acceso los usuarios
     * @param Array $perfilId, identificador del usuario que inicia session
     * @return array $datos, solo las aplicaciones que tiene acceso del primer nivel
     */
    public function reCargarMenuApp($perfilId)
    {
        $tmp = array();
        foreach ($perfilId as $item => $value) {
            $tmp[$item] = $value->seg_perfil_id;
        }
        $sql = "select * from view_seguridad WHERE perfil_id in(".implode(',',$tmp).")";
        $datos=$this->executeQuery($sql);
        return $datos;
    }
}
?>
