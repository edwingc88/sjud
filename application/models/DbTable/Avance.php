
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_Avance extends Application_Model_DbTable_Abstract {

    protected $_name = 'avance';
    protected $_primary = array('id','indice_resolucion');
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.
    protected $_referenceMap = array(
        'Resolucion' => array(
            self::COLUMNS => 'indice_resolucion',
            self::REF_TABLE_CLASS => 'Application_Model_DbTable_Resolucion',
            self::REF_COLUMNS => 'id',
            self::ON_UPDATE => self::CASCADE_RECURSE
        )
    );
}