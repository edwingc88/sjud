<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Avance{
    
    /**
     * Metodo que devuelve todos los avances
     */
    public static function getAllAvance($onlySelect = false){
        
        $tAvance = new Application_Model_DbTable_Avance();
        $consulta = $tAvance->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tAvance->info(Zend_db_table::NAME)),
                         array('a.*'),$tAvance->info(zend_db_Table::SCHEMA));
        
        $resultado = $tAvance->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /**
     * Metodo que devuelve todos los avances de una resolucion
     */    
    public static function getAllAvanceResolucion($id){
        
    $avances = self::getAllAvance(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*',"to_char(a.fecha_avance,'dd/MM/yyyy') as fecha_avance",      ))->where('indice_resolucion = ?', $id)
            ->order('a.fecha_avance DESC');
    return $avances->getAdapter()->fetchAll($avances);
    }
}