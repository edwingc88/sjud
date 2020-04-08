<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_DbTable_GerenciaGeneralCoordinacion extends Application_Model_DbTable_Abstract{ 

    protected $_name = 'gerencia_general_coordinacion';
    protected $_primary = array('id');   
    protected $_sequence = true; // Para permitir la secuencia en el campo 
                                 // "id", que es tipo serial.
    
    
}
   