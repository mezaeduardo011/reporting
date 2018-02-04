  -- #### Seguridad de Datos de roles #### ---

  -- Clase encargada de mantener todos los perfies del sistema ejemplo Root
  create table seg_perfil (
    id                 BIGINT IDENTITY (1, 1) NOT NULL,
    detalle            VARCHAR(50)         NOT NULL,
    CONSTRAINT pk_seg_perfil PRIMARY KEY(id)
  );

  -- Encagado de contener los perfiles asociados al usuario Ejemplo Gregorio -> Root
  create table seg_usuario_perfil (
    seg_perfil_id      BIGINT   NOT NULL,
    seg_usuarios_id    BIGINT   NOT NULL
      CONSTRAINT pk_usuario_perfil PRIMARY KEY(seg_perfil_id,seg_usuarios_id)
  );

  -- ENCARGADO DE REGISTRAR PERFILES ASOCIADOS A ROLES EJEMPLO  ROOT [1,2,3,4,5,6,7,8]
  create table seg_perfil_roles (
    seg_perfil_id      BIGINT   NOT NULL,
    seg_roles_id    BIGINT   NOT NULL
      CONSTRAINT pk_seg_perfil_roles PRIMARY KEY(seg_perfil_id,seg_roles_id)
  );

  -- Cantidad de Roels asociados al sistema ejemplo GENERADOR - ADMINISTRADOR - [CREAR, ACCEDER, ELIMINAR]
  create table seg_roles (
    id                 BIGINT IDENTITY (1, 1) NOT NULL,
    detalle            VARCHAR(200)         NOT NULL,
    CONSTRAINT pk_seg_roles PRIMARY KEY(id)
  );

  -- Vista encargada de procesar los dato de seguridad
  CREATE view view_seguridad AS
    SELECT a.id AS perfil_id, a.detalle AS perfil, c.id AS roles_id, c.detalle AS roles, e.*  from seg_perfil AS a
      INNER JOIN seg_perfil_roles AS b ON b.seg_perfil_id=a.id
      INNER JOIN seg_roles AS c ON c.id=b.seg_roles_id
      INNER JOIN seg_usuarios_perfil AS d ON d.seg_perfil_id=a.id
      INNER JOIN seg_usuarios AS e ON d.seg_usuarios_id=e.id

-- #### END SEGURIDAD #### ----

-- Es importante que la recuperaci�n de clave sea por correos y fecha de nacimiento
  create table seg_usuarios (
    id                 INT IDENTITY (1, 1) NOT NULL,
    apellidos          VARCHAR(50)         NOT NULL,
    nombres            VARCHAR(50)         NOT NULL,
    fech_nacimiento    DATETIME2(7)        NULL,
    usuario            VARCHAR(20)         NOT NULL,
    clave              CHAR(50)            NOT NULL,
    correo             VARCHAR(50)         NOT NULL,
    telefono           VARCHAR(50)         NULL NULL,
    fvence_clave        DATETIME2(7)        NULL,
    ivence_clave        CHAR(1)             NULL,
    cambiar_clave       CHAR(1)             NULL,
    login_fallidos      SMALLINT            NULL,
    idioma             CHAR(5)             NULL, --idioma
    created_usuario_id INT                 NOT NULL,
    updated_usuario_id INT                 NULL,
    created_at         DATETIME2(7)        NOT NULL,
    removed_at         DATETIME2(7)        NULL,
    updated_at         DATETIME2(7)        NULL,
    cuenta_bloqueada            CHAR(1)             NOT NULL,
    nsesion            INT                 NULL, --no loguear muchas veces
    dactive            TEXT                NULL, --active directory
    CONSTRAINT pk_seg_usuarios_1 PRIMARY KEY(id)
  );
  
  ALTER TABLE seg_usuarios
    ADD UNIQUE (usuario,correo,telefono);
    
  --- END


  

  CREATE TABLE ho_conexiones (
    id int Identity(1,1) NOT NULL,
    label varchar(20) NOT NULL,
    driver varchar(30) NOT NULL,
    host varchar(20) NOT NULL,
    db varchar(30) NOT NULL,
    usuario varchar(15) NOT NULL,
    clave varchar(50) NOT NULL,
    CONSTRAINT pk_ho_conexiones PRIMARY KEY(id)
  );
  
    ALTER TABLE ho_conexiones
    ADD UNIQUE (label,driver,host)
    
    -- Entidad encargada de mostrar el menu
    CREATE TABLE ho_menu (
    id int Identity(1,1) NOT NULL,
    app varchar(60) NOT NULL,
    entidad varchar(60) NOT NULL,
    vista varchar(60)  NULL,
    nombre varchar(60) NOT NULL,
    icon_fa varchar(60) NOT NULL,
    targe varchar(20)  NULL,
    ho_menu_id  NULL,
    created_usuario_id INT NOT NULL,
    updated_usuario_id INT  NULL,
    created_at DATETIME2(7) NOT NULL,
    updated_at  DATETIME2(7)        NULL,
    CONSTRAINT pk_ho_menu PRIMARY KEY(id)
  );
  -- app: Admin, entidad: personal, nombre:demo, vista: ddd, ico_fa: fa-plus, target:__new
  
   ALTER TABLE ho_menu
    ADD UNIQUE (app,entidad,vista,nombre)
  
    -- Gestion de mascaras
    CREATE TABLE ho_mascaras (
    id int Identity(1,1) NOT NULL,
    ho_tipo_dato_type varchar(20) NOT NULL,
    label varchar(20) NOT NULL,
    mascara varchar(30) NOT NULL,
    mensaje varchar(200) NOT NULL,
    clase_input varchar(30) NOT NULL,
    created_usuario_id INT NOT NULL,
    updated_usuario_id INT  NULL,
    created_at  DATETIME2(7)        NOT NULL,
    updated_at  DATETIME2(7)        NULL,
    CONSTRAINT pk_ho_mascaras PRIMARY KEY(id)
  );
  -- typr:varchar, label:integer, mensaje: Campo Integer, mascara: /[0-9]/, clase_input: integer
  
    ALTER TABLE ho_mascaras
    ADD UNIQUE (ho_tipo_dato_type,label,mascara,clase_input)


      -- Gestion de mascaras
    CREATE TABLE ho_tipo_dato (
    type  varchar(20) NOT NULL,
    label varchar(20) NOT NULL,
    length INT NOT NULL,
    orden INT NOT NULL,
    created_usuario_id INT NOT NULL,
    created_at  DATETIME2(7)        NOT NULL,
    CONSTRAINT pk_ho_tipo_dato PRIMARY KEY(type)
  );
  -- Label:Integer, type:int, : Campo Integer, mascara: /[0-9]/, clase_input: integer

    ALTER TABLE ho_tipo_dato
    ADD UNIQUE (label)

  
    -- Gestion de combinaciones de teclas del sistema
    CREATE TABLE ho_Keyboard (
    id int Identity(1,1) NOT NULL,
    menu_item_id INT NULL,
    combinacion varchar(30) NOT NULL,
    ruta_token varchar(20) NOT NULL,
    created_usuario_id INT NOT NULL,
    updated_usuario_id INT  NULL,
    created_at  DATETIME2(7)        NOT NULL,
    updated_at  DATETIME2(7)        NULL,
    CONSTRAINT pk_ho_Keyboard PRIMARY KEY(id)
  );
  
  -- menu_item_id: 12, combinacion:Ctrl_b, ruta_token: /logout
  
    ALTER TABLE ho_keyboard
    ADD UNIQUE (combinacion,ruta_token)



  -- Entidades registro de entidd
  CREATE TABLE ho_entidades (
    id BIGINT Identity(1,1) NOT NULL,
    conexiones_id int NOT NULL,
    entidad varchar(64) NOT NULL,
    field varchar(100) NOT NULL,
    type varchar(20) NOT NULL,
    nulo varchar(10) NOT NULL,
    dimension int,
    fijo varchar(60) NULL,
    restrincion varchar(10),
    CONSTRAINT pk_ho_entidades PRIMARY KEY(id)
  );


  ALTER TABLE ho_entidades
    ADD UNIQUE (conexiones_id,tabla,field)

  --- START AUDITORIA ----------
  CREATE TABLE seg_log_autenticacion (
    id BIGINT Identity(1,1) NOT NULL,
    host varchar(30) NOT NULL,
    navegador varchar(164) NOT NULL,
    accion varchar(100) NOT NULL,
    sistema varchar(30) NOT NULL,
    usuario varchar(30) NOT NULL,
    created_at DATETIME2(7) NOT NULL,
    CONSTRAINT pk_ho_seg_log_autenticacion PRIMARY KEY(id)
  );


  CREATE TABLE seg_log_eventos (
    id BIGINT Identity(1,1) NOT NULL,
    host varchar(30) NOT NULL,
    base_datos varchar(100) NOT NULL,
    entidad varchar(60) NOT NULL,
    entidad_id int ,
    new_value text,
    old_value text,
    usuario_id int,
    proceso varchar(60) NOT NULL,
    created_at DATETIME2(7) NOT NULL,
    CONSTRAINT pk_ho_seg_log_eventos PRIMARY KEY(id)
  );

  --- END AUDITORIA ----------


  CREATE TABLE ho_vistas (
    id BIGINT Identity(1,1),
    apps varchar(50) NOT NULL,
    conexiones_id int NOT NULL,
    entidad varchar(64) NOT NULL,
    nombre varchar(64) NOT NULL,
    field varchar(64) NOT NULL,
    type varchar(20) NOT NULL,
    dimension int,
    fijo varchar(60) NULL,
    restrincion varchar(10),
    label varchar(50) NOT NULL,
    mascara varchar(50) NOT NULL,
    nulo varchar(3) NOT NULL,
    place_holder varchar(14),
    relacionado varchar(10),
    tabla_vista varchar(50) NULL,
    vista_campo varchar(50),
    orden int,
    hidden_form bit ,
    hidden_list bit ,
    procesado bit,
    CONSTRAINT pk_ho_vistas PRIMARY KEY(id)
  );

  ALTER TABLE ho_vistas
   ADD UNIQUE  (conexiones_id, entidades_tabla,nombre,field,label,mascara)


  -- Vista encargada de extraer las tablas
  SELECT a.*, (SELECT COUNT(b.TABLE_NAME) from test_crud.INFORMATION_SCHEMA.COLUMNS AS b WHERE b.TABLE_NAME = a.TABLE_NAME) AS columas from test_crud.INFORMATION_SCHEMA.TABLES AS a WHERE a.TABLE_NAME not like 'ho_%' AND a.TABLE_TYPE='BASE TABLE' AND a.TABLE_NAME not like 'seg%'

  -- Extraer las vistas generadas a partir de una entidad generadas por el sistema
  CREATE VIEW view_list_vist_gene AS
 SELECT c.apps, c.conexiones_id, c.entidad, c.nombre, (select b.COLUMN_NAME from INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS a
    INNER JOIN INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE AS b
    ON a.CONSTRAINT_NAME=b.CONSTRAINT_NAME
    WHERE a.TABLE_NAME=c.entidad AND CONSTRAINT_TYPE='PRIMARY KEY') AS pk, coalesce(procesado,0) AS procesado from ho_vistas AS c
    GROUP BY c.apps,c.conexiones_id, c.entidad, c.nombre, c.procesado

  -- Vista encargadas de extraer las entidades seleccionada por el cliente en el momento
  CREATE VIEW view_list_enti_regi AS
   SELECT b.apps, b.conexiones_id, a.entidad, (SELECT COUNT(conexiones_id) FROM view_list_vist_gene AS c WHERE c.entidad=a.entidad ) AS catidad, b.nombre, b.procesado FROM ho_entidades AS a
      LEFT JOIN view_list_vist_gene AS b ON a.entidad=b.entidad
    --WHERE a.entidad='test_abm'
    GROUP BY b.apps,b.conexiones_id, a.entidad, b.nombre, b.procesado


-- Vistas encargada de mostrar los campos cuando se selecciona drilla en la definicion
  CREATE VIEW view_selec_grilla AS
 SELECT c.apps, c.conexiones_id, c.entidad, c.nombre, a.COLUMN_NAME AS pk, a.ORDINAL_POSITION AS orden,  coalesce(procesado,0) AS procesado
 FROM ho_vistas AS c
 INNER JOIN INFORMATION_SCHEMA.COLUMNS AS a ON a.TABLE_NAME=c.entidad
 WHERE COLUMN_NAME NOT IN('update_at','created_at','created_usuario_id','updated_usuario_id')
 GROUP BY c.apps,c.conexiones_id, c.entidad, c.nombre, a.COLUMN_NAME, a.ORDINAL_POSITION, c.procesado

 -- Vista encargada de Procesar las mascaras para PHP y JS
  CREATE VIEW view_list_mascaras AS
  SELECT a.nombre AS vista, b.ho_tipo_dato_type AS type, b.mascara AS mascaraJS, REPLACE(b.mascara,'\\','\') AS  mascaraPHP, b.mensaje, b.clase_input, a.label, CASE WHEN hidden_form=1 THEN 'SI' ELSE 'NO' END hidden FROM ho_vistas AS a
  INNER JOIN ho_mascaras  AS b ON b.clase_input=a.mascara
