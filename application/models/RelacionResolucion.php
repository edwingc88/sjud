<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_RelacionResolucion{
    
    /**
     * Metodo que devuelve todas las relaciones
     */
    public static function getAllRelaciones($onlySelect = false){
        
        $tRelaciones = new Application_Model_DbTable_RelacionResolucion();
        $consulta = $tRelaciones->select()
                ->setIntegrityCheck(false)
                ->from($tRelaciones,array('*'));
        
        $resultado = $tRelaciones->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /**
     * Metodo que devuelve las relaciones de una resolucion
     */    
    public static function getRelacionesResolucion($id){
        
    $relaciones = self::getAllRelaciones(true)->where('indice_resolucion = ?', $id)
            ->order('indice_resolucionb ASC');
    return $relaciones->getAdapter()->fetchAll($relaciones);
    }
    
    /**
     * Metodo que valida que no esten relacionadas 2 veces una resolucion 
     */    
    public static function validarRelacion($indice,$indiceb){  
    $relaciones = self::getAllRelaciones(true)->where('indice_resolucion = ?', $indice)->where('indice_resolucionb = ?', $indiceb);
    return $relaciones->getAdapter()->fetchAll($relaciones);
    }
    
}