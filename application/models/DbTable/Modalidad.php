
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_Modalidad extends Application_Model_DbTable_Abstract {

    protected $_name = 'modalidad';
    protected $_primary = array('id');
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.

}