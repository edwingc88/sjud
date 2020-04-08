
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_AdjuntoPunto extends Application_Model_DbTable_Abstract {

    protected $_name = 'adjunto_punto';
    protected $_primary = array('id','indice_punto');
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.
    
    protected $_referenceMap = array(
        'Punto' => array(
            self::COLUMNS => 'indice_punto',
            self::REF_TABLE_CLASS => 'Application_Model_DbTable_Punto',
            self::REF_COLUMNS => 'indice',
            self::ON_UPDATE => self::CASCADE_RECURSE
        )
    );
}