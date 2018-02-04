<?php
namespace APP\Admin\Model;
use JPH\Complements\Database\Main;
/**
 * Generador de codigo del Modelo de la App Admin del perfil menu
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 27/09/2017
 * @version: 1.0
 */ 
class SegPerfilMenuModel extends Main
{
   public function __construct()
   {
       $this->tabla = 'seg_perfil_ho_menu';
       $this->campoid = array('seg_perfil_id','ho_menu_id');
       $this->campos = array();
       parent::__construct();
       $this->segLogAccionesModel = new SegLogAccionesModel();
   }

    /**
     * Permitir hacer registro de las relaciones del menu con el seg_perfil en la entidad seg_perfil_ho_menu
     * @param array $roles asociados al perfil
     * @param integer $menuId menu relacionado
     * @return bool true
     */
    public function setSegPerfilRelacionMenuCreate($roles,$menuId)
    {
        foreach ($roles AS $key=>$value){
            $sql = "INSERT INTO ".$this->tabla." (seg_perfil_id,ho_menu_id) VALUES($key,$menuId)";
            $this->execute($sql);
        }
        return true;
    }


    /**
     * Permitir hacer registro de las relaciones de seg_usuarios con el seg_perfil en la entidad seg_usuarios_perfil
     * @param $roles roles asociados al perfil
     * @param $usuarioId usuarioId que esta relacionado
     * @return array $tablas
     
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
     
    public function valSegPerfilRelacionUser($comps,$roles)
    {
        $seg = explode('|',$roles);
        $temp = strtoupper($comps.' - '.implode("','".$comps.' - ',$seg));
        $sql = "SELECT CASE WHEN COUNT(roles) > 0 THEN 'SI' ELSE 'NO' END AS permiso  FROM view_seguridad WHERE roles IN('".$temp."') ";
        $datos=$this->executeQuery($sql);
        $this->free();
        return $datos[0];
    }*/
}
?>
