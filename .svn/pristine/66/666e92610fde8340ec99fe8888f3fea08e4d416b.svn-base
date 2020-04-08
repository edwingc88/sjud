<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_Suplente{
    /***************************************
     * Metodo para Busqueda de Suplentes
     */
    
   public static function getSuplente($id){  
       
    $suplente = self::getAllSuplente(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))
            ->where('id_gga = ?',$id); ;  
    return $suplente->getAdapter()->fetchRow($suplente);
    }
    
    public static function  getAllSuplente($onlySelect = false){ 
        $Suple = new Application_Model_DbTable_Suplente();
        $consulta = $Suple->select()
                ->setIntegrityCheck(false)
                ->from ($Suple,array('*'));  
        $resultado = $Suple->getAdapter()->fetchAll($consulta);
        return  $onlySelect ? $consulta:$resultado;  
    }
    
     /*Verifica si el suplente ya esta asiganado a una gerencia o coordinacion*/
     public static function getExisteSuplente($cedula,$id){        
      $Trabajador = self::getAllSuplente(true)
              ->where('cedula = ?',$cedula)
              ->where('id_gga <> ?',$id);  
        return $Trabajador->getAdapter()->fetchRow($Trabajador); 
     }
     
     public static function getSuplenteCed($cedula){        
      $Trabajador = self::getAllSuplente(true)
              ->where('cedula = ?',$cedula);
        return $Trabajador->getAdapter()->fetchRow($Trabajador); 
     }
      /*Verifica si el suplente ya esta asiganado a una gerencia o coordinacion*/
     public static function getExisteSuplenteSinId($cedula){        
      $Trabajador = self::getAllSuplente(true)
              ->where('cedula = ?',$cedula) ;  
        return $Trabajador->getAdapter()->fetchRow($Trabajador); 
     }
}/* $tGerencias = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $consulta = $tGerencias->select()
                ->setIntegrityCheck(false)
                ->from($tGerencias,array('*'));
        
        $resultado = $tGerencias->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;*/