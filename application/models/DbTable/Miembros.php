
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_Miembros extends Application_Model_DbTable_Abstract {

    protected $_name = 'miembros';
    protected $_primary = array('cedula','fecha_periodo','id_cargo');
    protected $_dependentTables = array(
        'Application_Model_DbTable_Cargo'
    );
    protected $_referenceMap = array(
        'Cargo' => array(
            self::COLUMNS => 'id_cargo',
            self::REF_TABLE_CLASS => 'Application_Model_DbTable_Cargo',
            self::REF_COLUMNS => 'id',
            self::ON_UPDATE => self::CASCADE_RECURSE
        )
    );
    
    
    
}