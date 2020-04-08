<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_Responsable {
    
public static function getTrabajador()
             {
         $tTrabajador = new Fmo_DbTable_Rpsdatos_DatoBasico();
         
         $consulta = $tTrabajador->select()
                ->setIntegrityCheck(false)
                ->from($tTrabajador, array('datb_nrotrab','datb_nombre'))
                ->where('datb_activi =! 9')
                ->order('datb_nrotrab');
        
        /*$resultado = $tCentroCosto->getAdapter()-> fetchAll ($consulta);
        fetchPairs($consulta);*/
         return $tTrabajador->getAdapter()->fetchPairs($consulta);
    }
}