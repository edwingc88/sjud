
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_Estado extends Application_Model_DbTable_Abstract {

    protected $_name = 'estado';
    protected $_primary = array('id');
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.
    protected $_dependentTables = array(
        'Application_Model_DbTable_Color'
    );
    protected $_referenceMap = array(
        'Color' => array(
            self::COLUMNS => 'id_color',
            self::REF_TABLE_CLASS => 'Application_Model_DbTable_Color',
            self::REF_COLUMNS => 'id',
            self::ON_UPDATE => self::CASCADE_RECURSE
        )
    );
    
    
    
}