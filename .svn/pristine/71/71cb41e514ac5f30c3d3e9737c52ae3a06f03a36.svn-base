<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_AdjuntoPunto{
    
    /**
     * Metodo que devuelve todos los adjuntos
     */
    public static function getAllAdjunto($onlySelect = false){
        
        $tAdjuntos = new Application_Model_DbTable_AdjuntoPunto();
        $consulta = $tAdjuntos->select()
                ->setIntegrityCheck(false)
                ->from($tAdjuntos,array('*'));
        
        $resultado = $tAdjuntos->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /**
     * Metodo que devuelve todos adjuntos de un punto
     */    
    public static function getAllAdjuntosPunto($id){
    Fmo_Logger::debug('cnosulta'.$id);
    $adjuntos = self::getAllAdjunto(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('indice_punto = ?', $id);
    return $adjuntos->getAdapter()->fetchAll($adjuntos);
    }
    
    /**
     * Metodo que devuelve adjunto de un punto
     */    
    public static function getAdjuntoPunto($idAdjunto){
        
    $adjuntos = self::getAllAdjunto(true)->where('id = ?', $idAdjunto);
    return $adjuntos->getAdapter()->fetchRow($adjuntos);
    }
    
    
    
    /**
     * Metodo que valida si ya hay un adjunto con el mismo nombre
     */    
    public static function validarAdjunto($id,$nombre){
        
    $adjuntos = self::getAllAdjunto(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('indice_punto','nombre'))->where('indice_punto = ?', $id)
            ->where('nombre = ?', $nombre);
    return $adjuntos->getAdapter()->fetchRow($adjuntos);
    }
    
}