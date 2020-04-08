<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_GerenciaGeneralCoordinacion{
    
    
   
    /**
     * 
     * Metodo que devuelve todas las gerencias DB
     * 
     */
    
    public static function getAllGerencia($onlySelect = false){
        
        $tGerencias = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $consulta = $tGerencias->select()
                ->setIntegrityCheck(false)
                ->from($tGerencias,array('*'));
        
        $resultado = $tGerencias->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /**
     * 
     * Metodo que devuelve todos los miembros de la junta directiva ordenados por fecha
     * 
     */    
    public static function getGerenciaCombobox(){
        
    $Gerencia = self::getAllGerencia(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id','descripcion'));   
            //->reset(Zend_Db_Table::COLUMNS)
    return $Gerencia->getAdapter()->fetchPairs($Gerencia);
    }
    
    /**
     * 
     * Metodo que datos de una gerencia
     *   
     */    
    public static function getDatosGerencia($id){
        
    $Gerencia = self::getAllGerencia(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('id = ?',$id);   
    return $Gerencia->getAdapter()->fetchRow($Gerencia);
    }
    
    /**
     * 
     * Metodo que datos de una gerencia
     * 
     */    
    public static function gerenciaSelect($id){
        
    $tGerencias = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $consulta = $tGerencias->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tGerencias->info(Zend_db_table::NAME)),array('value' => 'a.siglas', 'label' => 'a.siglas'.'a.descripcion'),$tGerencias->info(zend_db_Table::SCHEMA));               
        
        return $selec;
    }
    
    public static function getDescriGerencia($id){
    $Descripcion = self::getAllGerencia(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns('descripcion')->where('id = ?',$id);    
    return $Descripcion->getAdapter()->fetchOne($Descripcion);
    }
  
/*Listar Gerencias*/
     public static function getDatosgcia($onlySelect = false){
        $tGcia = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $consulta = $tGcia->select()
                ->setIntegrityCheck(false)
                ->from($tGcia,array('*'));        
        $resultado = $tGcia->getAdapter()->fetchAll($consulta);
        return  $onlySelect ? $consulta:$resultado;
    }
    /*Gerencias*/
      public static function getGerencias(){
        //$exp = "extract (year from fecha_real) ";
        $Gerencias = self::getDatosgcia(true)
                     ->order('id');
            //->reset(Zend_Db_Table::COLUMNS)->columns(array('*'));
           // ->where('id = ?',$id)->where($exp.'= ?', $año);
        return $Gerencias->getAdapter()->fetchAll($Gerencias); 
        
    } 
   /*Verifica si ya esta creado un centro de costo*/
     public static function getExisteGerencia($centroc){
        
    $Gerencia = self::getAllGerencia(true)->where('gga_costo = ?',$centroc);   
    return $Gerencia->getAdapter()->fetchRow($Gerencia);
    
    }
    /*Verifica si el responsable ya esta asiganado a una gerencia o coordinacion*/
     public static function getExisteCedula($cedula,$id){        
      $Trabajador = self::getAllGerencia(true)->where('cedula = ?',$cedula)
                                              ->where ('id <> ?',$id);  
        return $Trabajador->getAdapter()->fetchRow($Trabajador); 
      //->reset(Zend_Db_Table::COLUMNS)
             //    ->columns(array('a'=>'count(cedula)'))
    /* self::getAllPuntos(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('fecha_creacion'))->where('fecha_creacion = ?', $fecha)*/
    }
    /*Obtine el ultimo ID ingresado en la tabla gerencia*/
    public static function getUltReg (){ 
       $consulta = self::getDatosgcia(true)->reset(Zend_Db_Table::COLUMNS)
                       ->columns(array('a'=>'MAX(id)'));
                //->from($tGcia,array('*'));        
        return $consulta->getAdapter()->fetchRow($consulta);
    }
    
    public static function getExisteCedulaSinId($cedula){        
      $Trabajador = self::getAllGerencia(true)->where('cedula = ?',$cedula) ;  
        return $Trabajador->getAdapter()->fetchRow($Trabajador); 
      //->reset(Zend_Db_Table::COLUMNS)
             //    ->columns(array('a'=>'count(cedula)'))
    /* self::getAllPuntos(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('fecha_creacion'))->where('fecha_creacion = ?', $fecha)*/
    }
    
    
}
