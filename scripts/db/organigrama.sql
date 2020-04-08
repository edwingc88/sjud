SET search_path TO 'sch_zfbase';

DROP TABLE zf_organigrama;

CREATE TABLE zf_organigrama (
 id VARCHAR(20) PRIMARY KEY,
 id_padre VARCHAR(20) REFERENCES zf_organigrama ON UPDATE CASCADE ON DELETE RESTRICT,
 nombre VARCHAR(255) NOT NULL,
 orden SMALLINT NOT NULL DEFAULT 0,
 activo BOOLEAN NOT NULL DEFAULT TRUE
);

INSERT INTO zf_organigrama (id, id_padre, nombre)
 SELECT '1', NULL, 'FERROMINERA'
 UNION
 SELECT ceco_ceco, '1', ceco_descri
 FROM sch_rpsdatos.sn_tcecos
 WHERE length(ceco_ceco) = 2 AND ceco_cias = 1
 UNION
 SELECT ceco_ceco, SUBSTRING(ceco_ceco, 1, 2), ceco_descri
 FROM sch_rpsdatos.sn_tcecos
 WHERE length(ceco_ceco) = 5 AND ceco_cias = 1
 UNION
 SELECT ceco_ceco, SUBSTRING(ceco_ceco, 1, 5), ceco_descri
 FROM sch_rpsdatos.sn_tcecos
 WHERE length(ceco_ceco) = 6 AND ceco_cias = 1;