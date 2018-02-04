<?php

/**
 * Generador de codigo de Controller de Hornero 1.0
 * @propiedad: Hornero 1.0
 * @utor: Gregorio Bolivar <elalconxvii@gmail.com>
 * @created: 28/08/2017
 * @version: 1.0
 */

namespace APP\Admin\Controller;
use APP\Admin\Model;
use JPH\Core\Commun\Security;

class LoginController extends Controller
{
    public $model;
    public $segLogin;
    public $segUsuarioPerfil;
    use Security;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Model\LoginModel();
        $this->segLogin = new Model\SegLogAutenticacionModel();
        $this->segUsuarioPerfil = new Model\SegUsuariosPerfilModel();
    }
    /**
     * Permite mostrar el formulario de ingreso de session del usuario
     * @param $request
     * @return $html
     */
    public function runIndex($request)
   {

       if(empty($_SESSION)) {
           $this->tpl->addIni();
           $this->tpl->add('msjError', $this->cache->get('msjError'));
           $this->tpl->renders('view::home/login');
       }else{
           $this->redirect($this->cache->get('urlWebs'));
       }
   }

   /**
    * Permite cerrar session del usuario
    */
   public function runLogout()
   {
       $tmp = $this->getSession('usuario');
       $this->cargaAuditoria($tmp->id,'CERRAR SESSION');
       $this->delSessionAll();
   }

    public function runLockscreen()
    {
        $this->setSession('lockscreen','SI');
        $this->tpl->addIni();
        $tmp = $this->getSession('usuario');
        $this->cargaAuditoria($tmp->id, 'BLOQUEAR PANTALLA');
        $this->tpl->add('usuario', $tmp);
        $this->tpl->add('msjError',$this->cache->get('msjError'));
        $this->tpl->renders('view::home/lockscreen');
    }

    /**
     * @param Request $request
     */
    public function runIndexPost($request)
    {
        $tmp = $request->postParameter('login');
        if(isset($tmp))
        {
            $this->model->usuario = $request->postParameter('login');
            $this->model->password = $request->postParameter('contra');

            if ($this->model->validarUsuario() == true)
            {
                $this->cache->rm('msjError');
                $tmp = $this->model->obtenerUser();
                $perfil = $this->segUsuarioPerfil->getPerfilesAsociados($tmp->id);
                $this->setSession('usuario',$tmp);
                $this->setSession('usuarioPerfil',$perfil);
                $this->cargaAuditoria($tmp->id,'INICIAR SESSION');
                $this->setSession('path',getcwd());
                $this->setSession('autenticado','SI');
                self::runLoadRoles();
                $this->delSession('lockscreen');
                $this->redirect($this->cache->get('urlWebs'));
            }else{
                $uId = $this->model->obtenerUserLogin($request->postParameter('login'));
                $this->cargaAuditoria($uId->id, 'INTENTO FALLIDO INICIAR SESSION');
                $this->cache->set('msjError',$this->model->msjError);
                $this->redirect($this->cache->get('urlAute'));
            }
        }else{
            $this->redirect($this->cache->get('urlAute'));
            $this->cache->rm('msjError');
        }

    }

    public function runLoadRoles(){
        $this->setSession('roles', $this->model->roles);
    }

    public function runLocksPost($request)
    {
        $usuario=$this->getSession('usuario');
        $this->model->usuario = $usuario->usuario;
        $this->model->password = $request->postParameter('contra');
        if ($this->model->validarUsuario() == true)
        {
            $this->cache->rm('msjError');
            $tmp = $this->model->obtenerUser();
            $perfil = $this->segUsuarioPerfil->getPerfilesAsociados($tmp->id);
            $this->setSession('usuario',$tmp);
            $this->setSession('usuarioPerfil',$perfil);
            $this->cargaAuditoria($tmp->id,'DESBLOQUEO DE PANTALLA');
            $this->setSession('path',getcwd());
            $this->setSession('autenticado','SI');
            self::runLoadRoles();
            $this->delSession('lockscreen');
            $this->redirect($this->cache->get('urlWebs'));
        }else{
            $this->cache->set('msjError',$this->model->msjError);
            $uId = $this->model->obtenerUserLogin($request->postParameter('login'));
            $this->cargaAuditoria($uId->id, 'INTENTO FALLIDO DESBLOQUEO DE PANTALLA');
            $this->redirect($this->cache->get('urlLock'));
        }
    }
    public function cargaAuditoria($usuario_id,$accion)
    {
        $nav = $this->detect();
        $ip = $_SERVER['REMOTE_ADDR'];
        $bw = $nav['browser'].' '.$nav['version'].' '.$nav['os'];
        $sistema =  parent::FW;
        $this->segLogin->segLogCreateLogin($ip,$bw,$accion,$sistema,$usuario_id);
    }

}
?>