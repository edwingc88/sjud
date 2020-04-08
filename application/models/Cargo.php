<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Cargo{
    
    /* 
     * Método que permite devolver todos los cargo.
     */
    
    public static function getAllCargos($onlySelect = false) {
        
        $tCargos = new Application_Model_DbTable_Cargo();
        $consulta = $tCargos->select()
                ->setIntegrityCheck(false)
                ->from($tCargos,array('*'));
        
        $resultado = $tCargos->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /* 
     * Método que permite devolver todos los cargo listados por id.
     */
    
    public static function getAllCargosLista($onlySelect = false) {
        
        $datosCargo = self::getAllCargos(true)
                    ->order('id ASC');
        return $datosCargo->getAdapter()->fetchAll($datosCargo); 
    }
    
    /*
     * Método que permite devolver la lista de los cargos
     * para mostrarlos en un combobox.
     */
    public static function getAllCargo($onlySelect = false) {
                
        $tDatoCargo = new Fmo_DbTable_Rpsdatos_Cargo();
        $consulta   = $tDatoCargo->select()
                    ->setIntegrityCheck(false)
                    ->from($tDatoCargo, array('*'));
        
        $resultado = $tDatoCargo->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
      
    }
    
     
    public static function getCargosCombo() {
        
    $datosCargo = self::getAllCargos(true)
                    ->order('id ASC');
    return $datosCargo->getAdapter()->fetchPairs($datosCargo); 
      
    }
    
    /*
     * Método que permite devolver la descripcion de cargos guardados en DB
     * 
     */    
    public static function getDescriCargoDB($id) {
                               
    $datosCargo = self::getAllCargos(true)->reset(Zend_Db_Table::COLUMNS)->columns(array('descripcion'))->where('id = ?',$id);
    return $datosCargo->getAdapter()->fetchOne($datosCargo);
      
    }
    /*
     * Método que permite devolver la descripcion de cargo guardados en DB
     * 
     */
    public static function getNivelCargoDB($id) {
                               
    $datosCargo = self::getAllCargos(true)->reset(Zend_Db_Table::COLUMNS)->columns(array('nivel_cargo'))->where('id = ?',$id);
    return $datosCargo->getAdapter()->fetchOne($datosCargo);
    
      
    }
    
       
    public static function getDatoCargo($id) {
                               
    $datosCargo = self::getAllCargos(true)->where('id = ?',$id);
    return $datosCargo->getAdapter()->fetchRow($datosCargo);
    
      
    }
   
    public static function validarCargo($descripcion) {
        
    $datosCargo = self::getAllCargos(true)->columns(array('*'))->where('descripcion = ?',$descripcion);
    return $datosCargo->getAdapter()->fetchAll($datosCargo); 
      
    }
    
    
     
    
    
     
}
