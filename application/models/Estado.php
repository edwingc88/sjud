<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Estado{
    
    /* 
    * Método que permite devolver todos los colores.
    */
    public static function getAllColores($onlySelect = false) {
        
        $tColor = new Application_Model_DbTable_Color();
        $consulta = $tColor->select()
                ->setIntegrityCheck(false)
                ->from($tColor,array('*'));
        
        $resultado = $tColor->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    
    /* 
    * Método que permite devolver colores para combobox
    */    
    public static function getAllColor() {
        
    $datosColor = self::getAllColores(true)->columns(array('id','descripcion'));
    
    return $datosColor->getAdapter()->fetchPairs($datosColor); 
     
    }
    
    /*
     * Método que permite devolver todos los estados.
     */
    public static function getAllEstados($onlySelect = false) {
        
        
        $tDatoEstados = new Application_Model_DbTable_Estado();
        $consulta   = $tDatoEstados->select()                
                    ->setIntegrityCheck(false)
                    ->from($tDatoEstados, array('*'))
                    ->order('id');
                    
        //Fmo_Logger::debug($consulta->__toString());
        $resultado = $tDatoEstados->getAdapter()->fetchAll($consulta);
         return $onlySelect ? $consulta : $resultado;
     
    }
    
     /*
     * Método que permite devolver todos los estados con sus colores.
     */
    public static function getAllEstadoConColores($onlySelect = false) {
        
        $tColor = new Application_Model_DbTable_Color();
        $tDatoEstados = new Application_Model_DbTable_Estado();
        
        $sel = $tDatoEstados->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a' => $tDatoEstados->info(Zend_db_table::NAME)),
                              array('a.*', 'ruta1' => 'b.descripcion', 'nombre' => 'b.descripcion','color_id'=> 'b.id'),
                              $tDatoEstados->info(zend_db_Table::SCHEMA))
                       ->join(array('b' => $tColor->info(zend_db_table::NAME)), 
                              'a.id_color = b.id', null, $tColor->info(Zend_Db_Table::SCHEMA))
                       ;
        return $onlySelect ? $sel : $tDatoEstados->fetchAll($sel);
        
    }
    
     /*
     * Método que permite devolver todos los estados con sus colores.
     */
    public static function getAllEstadoColores() {
        
       $datosEstados = self::getAllEstadoConColores(true)->order(array('a.tipo_documento DESC','a.id ASC'));
       //Fmo_Logger::debug($datosEstados->getAdapter()->fetchRow($datosEstados)); 
       return $datosEstados->getAdapter()->fetchAll($datosEstados); 
        
        
    }
    
     /*
     * Método que permite devolver el estado por id.
     */
    public static function getAllEstadoColoresId($id) {
        
       $datosEstados = self::getAllEstadoConColores(true)->where('a.id = ? ', $id);
    
       //Fmo_Logger::debug($datosEstados->getAdapter()->fetchRow($datosEstados)); 
       return $datosEstados->getAdapter()->fetchRow($datosEstados); 
        
    }
    
    
    /*
     * Método que permite devolver todos los estados.
     */
    public static function getAllEstado($onlySelect = false) {
        
        
        $tDatoEstados = new Application_Model_DbTable_Estado();
        $consulta   = $tDatoEstados->select()                
                    ->setIntegrityCheck(false)
                    ->from($tDatoEstados, array('*'));
                    
        //Fmo_Logger::debug($consulta->__toString());
        $resultado = $tDatoEstados->getAdapter()->fetchAll($consulta);
         return $onlySelect ? $consulta : $resultado;
     
    }
    
    /* 
    * Método que permite devolver datos de un estado.
    */
    public static function getDatosEstado($id) {
        
       $datosEstados = self::getAllEstados(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id_color','tipo_documento','descripcion'))->where('id = ? ', $id);
        //Fmo_Logger::debug($datosEstados->getAdapter()->fetchRow($datosEstados)); 
       return $datosEstados->getAdapter()->fetchRow($datosEstados); 
       
    }
    
    
    
    /* 
    * Método que permite devolver estados de un tipo
    */
    public static function getEstadoTipo($tipo) {
        
       $estadosTipo = self::getAllEstados(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id','descripcion'))->where('tipo_documento = ? ', $tipo);
        //Fmo_Logger::debug($estadosTipo->getAdapter()->fetchPairs($estadosTipo));
        return $estadosTipo->getAdapter()->fetchPairs($estadosTipo); 
       }
    
        
    /* 
    * Método que permite validar si existe el estado.
    */
    public static function validarEstado($nombre,$tipo){
          
    
    $sel = self::getAllEstado(true)->where('descripcion = ? ', $nombre)->where('tipo_documento = ?', $tipo);
    if (!empty($sel)) {
    return $sel->getAdapter()->fetchAll($sel);
        }
    return $sel->getAdapter()->fetchAll($sel);
    
       
    }
             
   
    
    
    
     
}
