<?php
namespace JPH\Complements\Database;

trait Usuarios
{
    public $email;
    public $usuario;
    public $password;
    public $msjError;
    public $errorNum;
    public $roles = [];
    public $apellido;
    public $nombre;
    public $correo;
    public $telefono;
    public $bloqueada;
    public $cambiarPW;
    public $cantIntentosPermitos;
    public $cuenta_bloqueada;
    public $login_fallidos;
    public $db;

    public function start($obj)
    {
        $this->db=$obj;
        return $this;
    }

    public function validarUsuario()
    {
        $this->cantIntentosPermitos = 3;
        $this->cuenta_bloqueada = "N";
        $this->login_fallidos = "0";

        if ($this->usuario == "") {
            $this->msjError = "Ingrese el usuario";
        } else if ($this->password == "") {
            $this->msjError = "Ingrese la contraseña";
        } else {

            $passEncrypt = md5($this->password);

            $query = "select id,cuenta_bloqueada,login_fallidos from seg_usuarios where usuario = '" . $this->db->escape($this->usuario) . "'";
            $this->db->get($query);

            $rows = $this->db->numRows();

            if ($rows > 0) {
                $row = $this->db->fetch();
                $this->id = $row->id;
                $this->cuenta_bloqueada = $row->cuenta_bloqueada;
                $this->login_fallidos = $row->login_fallidos;

                if ($this->cuenta_bloqueada == "N") {
                    $query = "select id from seg_usuarios where usuario = '" . $this->db->escape($this->usuario) . "' and (clave = '" . $passEncrypt . "' or clave = '" . $this->db->escape($this->password) . "')";
                    $this->db->get($query);
                    $rows = $this->db->numRows();
                    if ($rows > 0) {
                        $query = "Update seg_usuarios set cuenta_bloqueada = 'N', login_fallidos = 0 where usuario = '" . $this->db->escape($this->usuario) . "'";
                        $this->db->execute($query);
                        $this->cargarRoles();
                        return true;
                    } else if ($this->login_fallidos >= $this->cantIntentosPermitos) {

                        $query = "Update seg_usuarios set cuenta_bloqueada = 'S' where usuario = '" . $this->db->escape($this->usuario) . "'";
                        $this->db->execute($query);
                        $this->msjError = "Usuario bloqueado, intentos fallidos excedidos, revise su correo con su nueva clave";
                    } else {

                        $query = "Update seg_usuarios set login_fallidos = login_fallidos + 1 where usuario = '" . $this->db->escape($this->usuario) . "'";
                        $this->db->execute($query);
                        $this->msjError = "Contraseña incorrecta, intentos fallidos: " . ($this->login_fallidos + 1);
                        //$this->enviarCorreo();
                    }
                } else {
                    $this->msjError = "Usuario bloqueado";
                }
            } else {
                $this->msjError = "Usuario incorrecto.";
            }
        }

        return false;
    }

    private function cargarRoles()
    {
        $query = "select * from view_seguridad WHERE id = " . $this->db->escape($this->id);
        $this->db->get($query);
        $rows = $this->db->numRows();

        if ($rows > 0) {
            while ($row = $this->db->fetch()) {
                $this->roles[] = $row->roles;
            }
        }
    }


    /**
     * Verificar si existe roles asociados a ese perfil 
     * @param string $rol
     * @return array $roles
     */
    public function tieneRol($rol)
    {
        return in_array($rol, $this->roles);
    }


    public function grabar()
    {
        $this->correo = ($this->correo == 'NULL' ? $this->correo : "'" . $this->db->escape($this->correo) . "'" );
        $this->telefono = ($this->telefono == 'NULL' ? $this->telefono : "'" . $this->db->escape($this->telefono) . "'" );

        if ($this->id != 0) {
            $query = "UPDATE seg_usuarios SET ";
            $query .= "usuario = '" . $this->db->escape($this->usuario) . "',";
            $query .= "apellidos = '" . $this->db->escape($this->apellido) . "',";
            $query .= "nombres = '" . $this->db->escape($this->nombre) . "',";
            $query .= "correo = " . $this->correo . ",";
            $query .= "telefono = " . $this->telefono . ",";
            $query .= "cuenta_bloqueada = '" . $this->db->escape($this->bloqueada) . "',";
            $query .= "cambiar_clave = '" . $this->db->escape($this->cambiarPW) . "' ";

            if($this->password != ''){
                $query .= ", clave = '" . $this->password . "' ";
            }

            $query .= "WHERE id = '" . $this->db->escape($this->id) . "'";
            $this->execute($query);
        } else {
            $query = "INSERT INTO seg_usuarios (id,usuario,clave,apellidos,nombres,correo,telefono,cuenta_bloqueada,cambiar_clave,created_at,created_at) ";
            $query .= "VALUES ((SELECT max(id)+1 FROM seg_usuarios),'" . $this->db->escape($this->usuario) . "','" . trim($this->db->escape($this->password)) . "','" . $this->db->escape($this->apellido) . "','" . $this->db->escape($this->nombre) . "'," . $this->correo . ",";
            $query .= $this->telefono . ",'" . $this->db->escape($this->bloqueada) . "','" . $this->db->escape($this->cambiarPW) . "', GETDATE(),1);";
            $query .= "SELECT SCOPE_IDENTITY();";
            $this->execute($query);
            $this->id = $db->lastId();
        }
        $this->errorNum = $db->errorno;
        return $this->id;
    }

    public function borrar()
    {


        if ($this->id != 0) {
            $query = "DELETE FROM seg_usuarios WHERE id = '" . $this->db->escape($this->id) . "'";
            $this->db->execute($query);
        }
    }

    public function obtenerJSON()
    {
        if ($this->id != 0) {
            $query = "SELECT * FROM seg_usuarios WHERE id = '" . $this->db->escape($this->id) . "'";
            $this->db->get($query);
            $row = $this->db->fetch();

            foreach ($row as $col => $val) {
                if (gettype($val) == "object" && get_class($val) == "DateTime") {
                    $row->$col = $val->format("d/m/Y");
                }
            }
            $json = json_encode($row);
            echo $json;
        }
    }

    public function obtenerUser()
    {
        if ($this->id != 0) {
            $query = "SELECT * FROM seg_usuarios WHERE id = '" . $this->db->escape($this->id) . "'";
            $this->db->get($query);
            $row = $this->db->fetch();

            foreach ($row as $col => $val) {
                if (gettype($val) == "object" && get_class($val) == "DateTime") {
                    $row->$col = $val->format("d/m/Y");
                }
            }
            return $row;
        }
    }

    public function obtenerUserLogin($login)
    {
        if ($this->id != 0) {
            $query = "SELECT * FROM seg_usuarios WHERE usuario = '".$login."'";
            $this->db->get($query);
            $row = $this->db->fetch();

            foreach ($row as $col => $val) {
                if (gettype($val) == "object" && get_class($val) == "DateTime") {
                    $row->$col = $val->format("d/m/Y");
                }
            }
            return $row;
        }
    }

    public function leerTodos($datos=NULL)
    {
        $query = "select * from SegUsuarios order by Cusuario";
        $this->db->get($query);
        $cantRows = $this->db->numRows();
        $datos = [];

        if ($cantRows > 0) {
            while ($row = $this->db->fetch()) {
                $datos[] = $row;
            }
        }
        return $datos;
    }

    public function cambiarClave()
    {
        $query = "UPDATE seg_usuarios SET clave = '" . $this->password . "' WHERE id = " . $this->id;
        $this->db->execute($query);
    }



}