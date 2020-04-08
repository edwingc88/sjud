
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_Punto extends Application_Model_DbTable_Abstract {

    protected $_name = 'punto';
    protected $_primary = array('indice');
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.
  
    
    
    
    
}