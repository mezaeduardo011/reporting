<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
use JPH\Core\Commun\All;
/**
 * Generador de codigo del Modelo de la App Admin
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 27/09/2017
 * @version: 1.0
 */ 
class SegPerfilRolesModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'seg_perfil_roles';
       $this->campoid = array('seg_perfil_id','seg_roles_id');
       $this->campos = array();
       parent::__construct();
   }

   public function getSegPerfilRolesShow($perfilId)
   {
       $sql="Select id, detalle, (SELECT CASE WHEN COUNT(b.seg_roles_id)>=1 THEN 'SI' ELSE 'NO' END from seg_perfil_roles AS b WHERE b.seg_roles_id = a.id AND b.seg_perfil_id=$perfilId ) AS existe from seg_roles AS a";
       $tablas=$this->executeQuery($sql);
       return $tablas;
   }

    /**
     * Permitir hacer registro de las relaciones de seg_usuarios con el seg_perfil en la entidad seg_usuarios_perfil
     * @param $roles roles asociados al perfil
     * @param $usuarioId usuarioId que esta relacionado
     * @return array $tablas
     */
    public function getSegPerfilRolesCreate($valor)
    {
        self::remSegPerfilRolesDelete($valor->seg_perfil_id);
        $items=explode(',',$valor->seg_roles_id);
        foreach ($items AS $key=>$value){
            $sql = "INSERT INTO ".$this->tabla." (seg_perfil_id,seg_roles_id) VALUES($valor->seg_perfil_id,$value)";
            $this->execute($sql);
        }
        $this->free();
        return true;
    }

    /**
     * Eliminar registros de SegUsuarios
     * @param: string $id
     * @return array $tablas
     */
    public function remSegPerfilRolesDelete($valor)
    {
        $sql = "DELETE FROM ".$this->tabla." WHERE seg_perfil_id=".$valor;
        $this->execute($sql);
        $this->free();
        return true;
    }


    /**
     * Permitir hacer registro de las los perfiles de acceso con los roles gestionados de la vista
     * @param $roles roles asociados al perfil
     * @param $usuarioId usuarioId que esta relacionado
     * @return array $tablas
     */
    public function getSegPerfilRolesAsociarVistaCreate($seg_perfil_id,$seg_roles_id)
    {
        $dato=self::getSegPerfilRolesExiste($seg_perfil_id,$seg_roles_id);
        if($dato->existe=='NO') {
            $sql = "INSERT INTO " . $this->tabla . " (seg_perfil_id,seg_roles_id) VALUES($seg_perfil_id,$seg_roles_id)";
            $this->execute($sql);
            $this->free();
        }
        return true;
    }


    /**
     * Permite verificar registros de SegPerfilRoles
     * @param: string $id
     * @return array $tablas
     */
    public function getSegPerfilRolesExiste($seg_perfil_id,$seg_roles_id)
    {
        $sql = "SELECT CASE WHEN COUNT(seg_perfil_id)>0 THEN 'SI' ELSE 'NO' END AS existe FROM ".$this->tabla." WHERE seg_perfil_id=$seg_perfil_id AND seg_roles_id=$seg_roles_id";
        $return = $this->executeQuery($sql);
        return $return[0];
    }
}
?>
