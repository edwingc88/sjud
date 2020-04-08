SET search_path TO sch_zfbase;

DROP TABLE zf_encuesta, zf_encuesta_pregunta, zf_encuesta_opcion, zf_encuesta_respuesta;

CREATE TABLE zf_encuesta (
 id SERIAL PRIMARY KEY,
 titulo VARCHAR(512) NOT NULL,
 descripcion TEXT NOT NULL,
 desde DATE NOT NULL,
 hasta DATE NOT NULL,
 notificar INTERVAL NOT NULL DEFAULT '0:00',
 correo_electronico VARCHAR(255)[],
 CHECK (desde <= hasta),
 CHECK (CAST((hasta - desde) || ' days' AS INTERVAL) >= notificar)
);
COMMENT ON TABLE zf_encuesta IS 'Encuestas del sistema.';
COMMENT ON COLUMN zf_encuesta.id IS 'Clave primaria.';
COMMENT ON COLUMN zf_encuesta.titulo IS 'Título.';
COMMENT ON COLUMN zf_encuesta.descripcion IS 'Descrpción.';
COMMENT ON COLUMN zf_encuesta.desde IS 'Fecha de inicio.';
COMMENT ON COLUMN zf_encuesta.hasta IS 'Fecha de finalización.';
COMMENT ON COLUMN zf_encuesta.notificar IS 'Tiempo para empezar a notificar.';
COMMENT ON COLUMN zf_encuesta.correo_electronico IS 'Direcciones de correo electrónico.';
INSERT INTO zf_encuesta (titulo, descripcion, desde, hasta, notificar, correo_electronico) VALUES
 ('PHP 5 con Zend Framework 1', 'Sondeo para determinar el grado de aceptación de las herramientas actuales para el desarrollo de aplicaciones Web.', CURRENT_DATE, '2015-12-31', '134 day', ARRAY['rafaelars@ferrominera.com', 'fmo_sis_desa@ferrominera.com']),
 ('Prueba', 'RPruba.', CURRENT_DATE, CURRENT_DATE + 10, '3 day', NULL);

CREATE TABLE zf_encuesta_pregunta (
 id_encuesta INTEGER NOT NULL REFERENCES zf_encuesta (id) ON DELETE CASCADE ON UPDATE CASCADE,
 id_pregunta SMALLINT NOT NULL,
 texto TEXT NOT NULL,
 minimo SMALLINT NOT NULL,
 maximo SMALLINT NOT NULL,
 PRIMARY KEY (id_encuesta, id_pregunta),
 CHECK (id_pregunta >= 1),
 CHECK (minimo >= 1 AND minimo <= maximo)
);
COMMENT ON TABLE zf_encuesta_pregunta IS 'Preguntas de la encuesta.';
COMMENT ON COLUMN zf_encuesta_pregunta.id_encuesta IS 'Clave compuesta y foránea con la encuesta.';
COMMENT ON COLUMN zf_encuesta_pregunta.id_pregunta IS 'Clave compuesta y número de la pregunta';
COMMENT ON COLUMN zf_encuesta_pregunta.texto IS 'Texto, acepta HTML.';
COMMENT ON COLUMN zf_encuesta_pregunta.minimo IS 'Cantidad mínima de respuestas.';
COMMENT ON COLUMN zf_encuesta_pregunta.maximo IS 'Cantidad máxima de respuestas.';
INSERT INTO zf_encuesta_pregunta (id_encuesta, id_pregunta, texto, minimo, maximo) VALUES
 (1, 1, '¿Cómo usted calificaría el desarrollo de aplicaciones Web con Zend Framework 1?', 1, 1),
 (1, 2, '¿Qué considerá que se debería mejorar para facilitar el desarrollo de aplicaciones Web con Zend Framework 1?', 1, 32767),
 (1, 3, '¿Cuál cree usted que es su nivel de conocimiento al desarrollar con Zend Framework 1?', 1, 1),
 (1, 4, '¿Cada cuanto tiempo debemos actualizar la plataforma de desarrollo PHP con Framework?', 1, 1),
 (1, 5, 'PHP 5.3 finalizó su soporte en julio de 2014 y PHP 5.4 finaliza en septiembre 2015. ¿A cuál versión de PHP se deben migrar los servidores Web?', 1, 1);

CREATE TABLE zf_encuesta_opcion (
 id_encuesta INTEGER NOT NULL,
 id_pregunta SMALLINT NOT NULL,
 id_opcion SMALLINT NOT NULL,
 texto TEXT NOT NULL,
 PRIMARY KEY (id_encuesta, id_pregunta, id_opcion),
 FOREIGN KEY (id_encuesta, id_pregunta) REFERENCES zf_encuesta_pregunta (id_encuesta, id_pregunta) ON DELETE CASCADE ON UPDATE CASCADE,
 CHECK (id_opcion >= 1)
);
COMMENT ON TABLE zf_encuesta_opcion IS 'Opciones de las preguntas.';
COMMENT ON COLUMN zf_encuesta_opcion.id_encuesta IS 'Clave compuesta y foránea con la pregunta.';
COMMENT ON COLUMN zf_encuesta_opcion.id_pregunta IS 'Clave compuesta y foránea con la pregunta.';
COMMENT ON COLUMN zf_encuesta_opcion.id_opcion IS 'Clave compuesta y número de la opción.';
COMMENT ON COLUMN zf_encuesta_opcion.texto IS 'Text, acepta HTML.';
INSERT INTO zf_encuesta_opcion (id_encuesta, id_pregunta, id_opcion, texto) VALUES
 (1, 1, 1, 'Excelente'),
 (1, 1, 2, 'Bueno'),
 (1, 1, 3, 'Regular'),
 (1, 1, 4, 'Malo'),
 (1, 1, 5, 'Terrible'),
 (1, 2, 1, 'Documentación'),
 (1, 2, 2, 'Pruebas Unitarias'),
 (1, 2, 3, 'Migrar a Zend Framework 2'),
 (1, 2, 4, 'IDE de desarrollo'),
 (1, 2, 5, 'Manejador de reportes'),
 (1, 2, 6, 'Hojas de estilo'),
 (1, 2, 7, 'Cambiar de lenguaje de programación'),
 (1, 2, 8, 'Cambiar de Framework de PHP'),
 (1, 3, 1, 'Experto'),
 (1, 3, 2, 'Avanzado'),
 (1, 3, 3, 'Principiante'),
 (1, 4, 1, 'Anualmente'),
 (1, 4, 2, 'Cada 5 años'),
 (1, 4, 3, 'Cada 10 años'),
 (1, 4, 4, 'Cuando lo indique el personal del Dpto. Infraestructura'),
 (1, 4, 5, 'Cuando lo indique el jefe'),
 (1, 5, 1, 'Mantener la actual mientras se pueda'),
 (1, 5, 2, 'Migrar a PHP 5.5'),
 (1, 5, 3, 'Migrar a PHP 5.6');

CREATE TABLE zf_encuesta_respuesta (
 id_encuesta INTEGER NOT NULL,
 id_pregunta SMALLINT NOT NULL,
 id_opcion SMALLINT NOT NULL,
 id_persona NUMERIC(20) NOT NULL,
 PRIMARY KEY (id_encuesta, id_pregunta, id_opcion, id_persona),
 FOREIGN KEY (id_encuesta, id_pregunta, id_opcion) REFERENCES zf_encuesta_opcion (id_encuesta, id_pregunta, id_opcion) ON DELETE CASCADE ON UPDATE CASCADE
);
COMMENT ON TABLE zf_encuesta_respuesta IS 'Respuestas de la encuesta';
COMMENT ON COLUMN zf_encuesta_respuesta.id_encuesta IS 'Clave compuesta y foránea con las opciones.';
COMMENT ON COLUMN zf_encuesta_respuesta.id_pregunta IS 'Clave compuesta y foránea con las opciones.';
COMMENT ON COLUMN zf_encuesta_respuesta.id_opcion IS 'Clave compuesta y foránea con las opciones.';
COMMENT ON COLUMN zf_encuesta_respuesta.id_persona IS 'CI de la persona que respondió.';