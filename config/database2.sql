  -- Seguridad de Datos de roles

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
    seg_roles          BIGINT   NOT NULL,
    CONSTRAINT pk_perfil_rol PRIMARY KEY(id)
  );


  -- Cantidad de Roels asociados al sistema ejemplo GENERADOR - ADMINISTRADOR - [CREAR, ACCEDER, ELIMINAR]
  create table seg_roles (
    id                 BIGINT IDENTITY (1, 1) NOT NULL,
    detalle            VARCHAR(200)         NOT NULL,
    CONSTRAINT pk_seg_roles PRIMARY KEY(id)
  );



  SELECT [NUSUARIO]
    ,[DAPELLIDO]
    ,[DNOMBRE]
    ,'0000-00-00'
    ,[CUSUARIO]
    ,[DPASSWORD]
    ,[DCORREOELECTRONICO]
    ,[DTELEFONO]
    ,[FVENCEPASSWORD]
    ,[IVENCEPASSWORD]
    ,[ICAMBIARPASSWORD]
    ,[KLOGINFALLIDOS]
    ,[CCULTURA]
    ,[NUSUALTA]
    ,[NUSUMODIF]
    ,[FALTA]
    ,[FBAJA]
    ,[FMODIF]
    ,[ICUENTABLOQUEADA]
    ,[NSESION]
    ,[DACTIVE]
  FROM [test_crud2].[dbo].[segusuariosBK]
  GO

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
    ADD UNIQUE (label)

  -- Entidades registro de entidd
  CREATE TABLE ho_entidades (
    id BIGINT Identity(1,1) NOT NULL,
    conexiones_id int NOT NULL,
    entidad varchar(64) NOT NULL,
    field varchar(100) NOT NULL,
    type varchar(20) NOT NULL,
    required varchar(10) NOT NULL,
    dimension int,
    restrincion varchar(10),
    CONSTRAINT pk_ho_entidades PRIMARY KEY(id)
  );
  ALTER TABLE ho_entidades
    ADD UNIQUE (conexiones_id,tabla,field)


  CREATE TABLE ho_vistas (
    id BIGINT Identity(1,1),
    conexiones_id int NOT NULL,
    entidad varchar(64) NOT NULL,
    nombre varchar(64) NOT NULL,
    field varchar(64) NOT NULL,
    type varchar(20) NOT NULL,
    dimension int,
    restrincion varchar(10),
    label varchar(50) NOT NULL,
    mascara varchar(50) NOT NULL,
    required varchar(3) NOT NULL,
    place_holder varchar(14),
    relacionado bit,
    vista_campo varchar(30),
    orden int,
    hidden_form bit ,
    hidden_list bit ,
    procesado bit,
    CONSTRAINT pk_ho_vistas PRIMARY KEY(id)
  );

  ALTER TABLE ho_vistas
   ADD UNIQUE (conexiones_id, entidades_tabla,nombre,field,label,mascara)


  -- Vista encargada de extraer las tablas
  SELECT a.*, (SELECT COUNT(b.TABLE_NAME) from test_crud.INFORMATION_SCHEMA.COLUMNS AS b WHERE b.TABLE_NAME = a.TABLE_NAME) AS columas from test_crud.INFORMATION_SCHEMA.TABLES AS a WHERE a.TABLE_NAME not like 'ho_%' AND a.TABLE_TYPE='BASE TABLE' AND a.TABLE_NAME not like 'seg%'

  -- Extraer las vistas generadas a partir de una entidad generadas por el sistema
  CREATE VIEW view_list_vist_gene AS
    SELECT conexiones_id, entidad, nombre, coalesce(procesado,0) AS procesado from ho_vistas
    GROUP BY conexiones_id, entidad, nombre, procesado

  -- Vista encargadas de extraer las entidades seleccionada por el cliente en el momento
  CREATE VIEW view_list_enti_regi AS
    SELECT b.conexiones_id, a.entidad, (SELECT COUNT(conexiones_id) FROM view_list_vist_gene AS c WHERE c.entidad=a.entidad ) AS catidad, b.nombre, b.procesado FROM ho_entidades AS a
      LEFT JOIN view_list_vist_gene AS b ON a.entidad=b.entidad
    --WHERE a.entidad='test_abm'
    GROUP BY b.conexiones_id, a.entidad, b.nombre, b.procesado


  https://obliads.myshopify.com/admin/oauth/authorize?client_id=e4c342fe71581dc2ee590f87dd5dd28c&scope=write_orders,read_customers&redirect_uri=http://app-mundoweb.c9users.io/storeShopify&state={nonce}&grant_options=per-user




