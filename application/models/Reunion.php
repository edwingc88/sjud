<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Reunion{
    
    
    /**
     * 
     * Metodo que devuelve todas las  reuniones de la junta directiva
     * 
     */
    public static function getAllReuniones($onlySelect = false){
        
        $tTipo = new Application_Model_DbTable_TipoReunion();  
        $tReunion = new Application_Model_DbTable_Reunion();
        
        $sel = $tReunion->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a' => $tReunion->info(Zend_db_table::NAME)),
                              array('a.*', "to_char(a.fecha_real,'dd/MM/yyyy') as fecha_real_reu",'id_tipo' => 'b.id', 'tipo_nombre' => 'b.descripcion'),$tReunion->info(zend_db_Table::SCHEMA))
                       ->join(array('b' => $tTipo->info(zend_db_table::NAME)), 
                                      'a.id_tipo_reunion = b.id', null, $tTipo->info(Zend_Db_Table::SCHEMA));
                                        
        return $onlySelect ? $sel : $tReunion->fetchAll($sel);
        
        
    }
    
    /**
     * 
     * Metodo que devuelve todos los tipos de reuniones
     * 
     */
    public static function getAllTiposReunion($onlySelect = false){
        
        $tTipos = new Application_Model_DbTable_TipoReunion();
        $consulta = $tTipos->select()
                ->setIntegrityCheck(false)
                ->from($tTipos,array('*'))->order('id');
        
        $resultado = $tTipos->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
     
    /**
     * 
     * Metodo que devuelve un tipo de reunion
     * 
     */
    public static function getTipoReunion($id){
        
    $sel = self::getAllTiposReunion(true)->where('id = ? ', $id);
    return $sel->getAdapter()->fetchRow($sel);
    }
    
    
    /**
     * 
     * Metodo que devuelve todos los tipos de reuniones para el combobox
     * 
     */
    public static function getAllTiposReunionCombo($onlySelect = false){
        
    $reunion = self::getAllTiposReunion(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id','descripcion'));
    return $reunion->getAdapter()->fetchPairs($reunion);
    
    }
    
    /* 
    * Método que permite validar el nombre del tipo de reunion
    */
    public static function validarTipoReunion($nombre){
          
    
    $sel = self::getAllTiposReunion(true)->where('descripcion = ? ', $nombre);
    return $sel->getAdapter()->fetchAll($sel);
    
       
    }
    
    /**
     * 
     * Metodo que devuelve la reunion
     * 
     */    
    public static function validarReunion($id,$año){
    $exp = "extract (year from a.fecha_real) ";    
    $reunion = self::getAllReuniones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id'))->where('a.id = ?', $id)->where($exp.'= ?',$año);
    return $reunion->getAdapter()->fetchOne($reunion);
    }
    
     /**
     * 
     * Metodo que devuelve la reunion por su id
     * 
     */    
    public static function getReunion($id){
        
    $reunion = self::getAllReuniones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('a.id = ?', $id);
    return $reunion->getAdapter()->fetchRow($reunion);
    }
    
    /**
     * 
     * Metodo que devuelve la reunion por su id y año
     * 
     */    
    public static function getReunionAño($id,$año){
    $exp = "extract (year from a.fecha_real) ";
    $reunion = self::getAllReuniones(true)->where('a.id = ?', $id)->where($exp.'= ?', $año);
    return $reunion->getAdapter()->fetchRow($reunion);
    }
     /**
     * 
     * Metodo que devuelve la reunion por su indice
     * 
     */    
    public static function getReunionIndice($indice){
        
    $reunion = self::getAllReuniones(true)->where('indice = ?', $indice);
    return $reunion->getAdapter()->fetchRow($reunion);
    }
    
    /**
     * 
     * Metodo que devuelve reuniones
     * 
     */    
    public static function getAllReunionAño($año,$query = null){
    $exp = "extract (year from a.fecha_real) ";
    $reunion = self::getAllReuniones(true)->where($exp.'= ?',$año);
    if($query){
        Fmo_Logger::debug ('entro');
        return $reunion;    
    }
    else
    return $reunion->getAdapter()->fetchAll($reunion);
    }
    
    /**
     * 
     * Metodo que devuelve datos de reunion por id
     * 
     */    
    /*public static function getDatosReunion($id){
        
    $reunion = self::getAllReuniones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('id = ?',$id);
    //Fmo_Logger::debug($reunion->getAdapter()->fetchAll($reunion));
    return $reunion->getAdapter()->fetchRow($reunion);
    }*/
    
    /**
     * 
     * Metodo que devuelve id reunion por fecha
     * 
     */    
    public static function getReunionPorFecha($fecha){
    //Fmo_Logger::debug($fecha);
    $reunion = self::getAllReuniones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('fecha_real = ?',$fecha);
    //Fmo_Logger::debug($reunion->getAdapter()->fetchAll($reunion));
    return $reunion->getAdapter()->fetchAll($reunion);
    }
    
     /**
     * 
     * Metodo que devuelve tipo reunion
     * 
     */    
    public static function getTipoReunionPorFecha($fecha){
        
    $reunion = self::getAllReuniones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('fecha_real = ?',$fecha);
    return $reunion->getAdapter()->fetchRow($reunion);
    }
    
      /**
     * 
     * Metodo que devuelve reunion por id
     * 
     */    
    /*public static function getDatoReunion($id){
        
    $reunion = self::getAllReuniones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('id = ?',$id);
    //Fmo_Logger::debug($reunion->getAdapter()->fetchAll($reunion));
    
    return $reunion->getAdapter()->fetchRow($reunion);
    }*/
    
    
    
    
    
    
}