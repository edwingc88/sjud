SET search_path TO sch_sjud;

DROP TABLE zf_notificacion, zf_archivo, zf_registro, zf_seguridad_grupo_recurso, zf_seguridad_grupo_usuario, zf_seguridad_usuario, zf_seguridad_grupo, zf_seguridad_recurso, zf_seguridad_estatus;

CREATE TABLE zf_notificacion (
 id SERIAL PRIMARY KEY,
 tipo CHAR NOT NULL,
 para NUMERIC(20) NOT NULL,
 de TEXT NOT NULL,
 mensaje TEXT NOT NULL,
 es_mensaje_html BOOLEAN NOT NULL DEFAULT FALSE,
 fecha_leido TIMESTAMP WITHOUT TIME ZONE,
 fecha_registro TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP,
 CHECK (tipo IN ('W', 'E', 'I', 'S'))
);
COMMENT ON TABLE zf_notificacion IS 'Almacena las notificaciones para los usuarios.';
COMMENT ON COLUMN zf_notificacion.id IS 'Clave primaria de la notificación.';
COMMENT ON COLUMN zf_notificacion.tipo IS 'Tipo de notificación: (W)arning, (E)rror, (I)nformation, y (S)uccessful.';
COMMENT ON COLUMN zf_notificacion.para IS 'CI N° del destinatario.';
COMMENT ON COLUMN zf_notificacion.de IS 'Nombre del usuario, módulo, sistema que envía la notificación.';
COMMENT ON COLUMN zf_notificacion.mensaje IS 'Mensaje de la notificación.';
COMMENT ON COLUMN zf_notificacion.es_mensaje_html IS 'Indica si el mensaje está en formato HTML o texto.';
COMMENT ON COLUMN zf_notificacion.fecha_leido IS 'Fecha y hora de lectura de la notificación, sí es nulo no ha sido leído.';
COMMENT ON COLUMN zf_notificacion.fecha_registro IS 'Fecha y hora del registro.';
INSERT INTO zf_notificacion (tipo, para, de, mensaje) VALUES
 ('I', 12130304, 'Sistema ZFBase', 'Bienvenido al Sistema ZFBase, mensaje realizado por Rafael Rodríguez <rafaelars@ferrominera.com>');

CREATE TABLE zf_archivo (
 id CHAR(13) PRIMARY KEY,
 nombre VARCHAR(255) NOT NULL,
 directorio VARCHAR(1024) NOT NULL,
 descripcion VARCHAR(512) NOT NULL,
 tamanio INT NOT NULL,
 contenido BYTEA NOT NULL,
 suma_comprobacion CHAR(32) NOT NULL,
 tipo_mime VARCHAR(255) NOT NULL,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP
);
COMMENT ON TABLE zf_archivo IS 'Almacena las archivos del sistema en la Base de Datos';
COMMENT ON COLUMN zf_archivo.id IS 'Clave primaria';
COMMENT ON COLUMN zf_archivo.tipo_mime IS 'Tipo MIME del archivo';
COMMENT ON COLUMN zf_archivo.contenido IS 'Contenido del archivo';
COMMENT ON COLUMN zf_archivo.nombre IS 'Nombre del archivo';
COMMENT ON COLUMN zf_archivo.directorio IS 'Directorio del archivo';
COMMENT ON COLUMN zf_archivo.descripcion IS 'Descripción del archivo';
COMMENT ON COLUMN zf_archivo.tamanio IS 'Tamaño del archivo en bytes';
COMMENT ON COLUMN zf_archivo.suma_comprobacion IS 'Suma de comprobación del archivo en MD5';
COMMENT ON COLUMN zf_archivo.fecha_hora IS 'Fecha y hora del registro';

CREATE TABLE zf_registro (
 id SERIAL PRIMARY KEY,
 id_transaccion CHAR(32),
 operacion CHAR(6),
 usuario TEXT,
 ip_cliente TEXT,
 agente_cliente TEXT,
 tabla_esquema TEXT,
 tabla_nombre TEXT,
 tabla_clave_primaria TEXT,
 tabla_clave_primaria_valor TEXT,
 tabla_campo TEXT,
 tabla_valor_viejo TEXT,
 tabla_valor_nuevo TEXT,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP
);
COMMENT ON TABLE zf_registro IS 'Contiene la información de auditoría del sistema';
COMMENT ON COLUMN zf_registro.id IS 'Clave primaria de esta tabla';
COMMENT ON COLUMN zf_registro.id_transaccion IS 'Id o código de la transacción';
COMMENT ON COLUMN zf_registro.operacion IS 'Tipo de operación realizada CREATE/INSERT, DELETE o UPDATE';
COMMENT ON COLUMN zf_registro.usuario IS 'Siglado o cuenta del usuario';
COMMENT ON COLUMN zf_registro.ip_cliente IS 'Dirección IP del cliente';
COMMENT ON COLUMN zf_registro.agente_cliente IS 'Información del agente utilizado';
COMMENT ON COLUMN zf_registro.tabla_esquema IS 'Nombre del esquema de la tabla';
COMMENT ON COLUMN zf_registro.tabla_nombre IS 'Nombre de la tabla';
COMMENT ON COLUMN zf_registro.tabla_clave_primaria IS 'Nombre de la clave primaria de la tabla modificada';
COMMENT ON COLUMN zf_registro.tabla_clave_primaria_valor IS 'Valor de la clave primaria de la tabla modificada';
COMMENT ON COLUMN zf_registro.tabla_campo IS 'Nombre del campo en la tabla modificada';
COMMENT ON COLUMN zf_registro.tabla_valor_viejo IS 'Valor anterior o viejo en el campo de la tabla modificada';
COMMENT ON COLUMN zf_registro.tabla_valor_nuevo IS 'Valor nuevo en el campo de la tabla modificada';
COMMENT ON COLUMN zf_registro.fecha_hora IS 'Fecha de la transacción';

CREATE TABLE zf_seguridad_usuario (
 id NUMERIC(20) PRIMARY KEY,
 clave CHAR(32) NOT NULL,
 siglado VARCHAR(32) NOT NULL,
 caducidad DATE,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP
);
COMMENT ON TABLE zf_seguridad_usuario IS 'Contiene los usuarios del sistema';
COMMENT ON COLUMN zf_seguridad_usuario.id IS 'Clave primaria y CI del usuario';
COMMENT ON COLUMN zf_seguridad_usuario.clave IS 'Contraseña del usuario';
COMMENT ON COLUMN zf_seguridad_usuario.siglado IS 'Contraseña del usuario';
COMMENT ON COLUMN zf_seguridad_usuario.caducidad IS 'Indica la fecha de caducidad de la contraseña';
COMMENT ON COLUMN zf_seguridad_usuario.fecha_hora IS 'Fecha y hora del registro';

INSERT INTO zf_seguridad_usuario (id, clave, caducidad, siglado) VALUES
 (12130304, md5('8741'), '2011-1-1', 'rafaelars');

CREATE TABLE zf_seguridad_grupo (
 id INTEGER PRIMARY KEY,
 nombre VARCHAR(255) NOT NULL UNIQUE,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP
);
COMMENT ON TABLE zf_seguridad_grupo IS 'Contiene los grupos del sistema';
COMMENT ON COLUMN zf_seguridad_grupo.id IS 'Clave primaria del grupo, también funciona como rango del grupo';
COMMENT ON COLUMN zf_seguridad_grupo.nombre IS 'Nombre del grupo';
COMMENT ON COLUMN zf_seguridad_grupo.fecha_hora IS 'Fecha y hora del registro';

INSERT INTO zf_seguridad_grupo (id, nombre) VALUES (1, 'Administrador'), (2, 'Usuario'), (3, 'Invitado');

CREATE TABLE zf_seguridad_estatus (
 id CHAR PRIMARY KEY,
 nombre VARCHAR(50) NOT NULL
);
COMMENT ON TABLE zf_seguridad_estatus IS 'Contiene los estados de los recursos';
COMMENT ON COLUMN zf_seguridad_estatus.id IS 'Clave primaria';
COMMENT ON COLUMN zf_seguridad_estatus.nombre IS 'Nombre del estatus';

INSERT INTO zf_seguridad_estatus (id, nombre) VALUES
 ('A', 'Activo'),
 ('B', 'Denegado'),
 ('C', 'En Mantenimiento'),
 ('D', 'En Construcción');

CREATE TABLE zf_seguridad_recurso (
 id VARCHAR(1024) PRIMARY KEY,
 id_estatus CHAR NOT NULL REFERENCES zf_seguridad_estatus (id) ON DELETE RESTRICT ON UPDATE CASCADE,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP
);
COMMENT ON TABLE zf_seguridad_recurso IS 'Contiene los recursos del sistema';
COMMENT ON COLUMN zf_seguridad_recurso.id IS 'Clave primaria del recurso, es una cadena que concatena: modulo/controlador/acción';
COMMENT ON COLUMN zf_seguridad_recurso.id_estatus IS 'Estatus del recurso: Activo, Denegado, Mantenimiento o Contrucción';
COMMENT ON COLUMN zf_seguridad_recurso.fecha_hora IS 'Fecha y hora del registro';

CREATE TABLE zf_seguridad_grupo_usuario (
 id_usuario NUMERIC(20) NOT NULL REFERENCES zf_seguridad_usuario (id) ON DELETE RESTRICT ON UPDATE CASCADE,
 id_grupo INT NOT NULL REFERENCES zf_seguridad_grupo (id) ON DELETE RESTRICT ON UPDATE CASCADE,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP,
 PRIMARY KEY (id_usuario, id_grupo)
);
COMMENT ON TABLE zf_seguridad_grupo_usuario IS 'Contiene los grupos y usuarios del sistema';
COMMENT ON COLUMN zf_seguridad_grupo_usuario.id_usuario IS 'Clave compuesta y foránea con el usuario';
COMMENT ON COLUMN zf_seguridad_grupo_usuario.id_grupo IS 'Clave compuesta y foránea con el grupo';
COMMENT ON COLUMN zf_seguridad_grupo_usuario.fecha_hora IS 'Fecha y hora del registro';

INSERT INTO zf_seguridad_grupo_usuario (id_usuario, id_grupo) VALUES
 (12130304, 1);

CREATE TABLE zf_seguridad_grupo_recurso (
 id_recurso VARCHAR(1024) NOT NULL REFERENCES zf_seguridad_recurso (id) ON DELETE RESTRICT ON UPDATE CASCADE,
 id_grupo INT NOT NULL REFERENCES zf_seguridad_grupo (id) ON DELETE RESTRICT ON UPDATE CASCADE,
 fecha_hora TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT LOCALTIMESTAMP,
 PRIMARY KEY (id_recurso, id_grupo)
);
COMMENT ON TABLE zf_seguridad_grupo_recurso IS 'Contiene los grupos y recursos del sistema';
COMMENT ON COLUMN zf_seguridad_grupo_recurso.id_recurso IS 'Clave compuesta y foránea con el recurso';
COMMENT ON COLUMN zf_seguridad_grupo_recurso.id_grupo IS 'Clave compuesta y foránea con el grupo';
COMMENT ON COLUMN zf_seguridad_grupo_recurso.fecha_hora IS 'Fecha y hora del registro';
