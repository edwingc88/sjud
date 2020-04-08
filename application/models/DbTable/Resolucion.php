
<?php

/**
 * Clase DbTable para administrar los lugares en los que se realizan los actos
 * protocolares.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_DbTable_Resolucion extends Application_Model_DbTable_Abstract {

    protected $_name = 'resolucion';
    protected $_primary = array('indice');
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.
   
    
    
    
    
}