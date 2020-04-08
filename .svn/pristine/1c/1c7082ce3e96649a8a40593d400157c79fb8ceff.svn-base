<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Application_Model_CentroCosto {
    
public static function getCentroCosto()
             {
         $tCentroCosto = new Fmo_DbTable_Rpsdatos_CentroCosto();
         
         $select = $tCentroCosto->select()
                ->setIntegrityCheck(false)
                ->from($tCentroCosto, array('a'=>'ceco_ceco','b'=>'ceco_descri'))
                ->where('length(ceco_ceco) = 5')
                ->where("ceco_status = 'A'")
                ->order('ceco_ceco');
        return $tCentroCosto->getAdapter()-> fetchPairs($select);
        // $consulta = $tCentroCosto->fetchAll($select)->toArray();
         // return $consulta;//->fetchAll($consulta);
         
    //    fetchPairs($consulta); 
         //return $tCentroCosto->getAdapter()-> fetchPairs($consulta);
         /* 
            $tDetHorario = new Application_Model_DbTable_DetalleHorario();
            $select = $tDetHorario->select()
                      ->from(array('a' => $tDetHorario->info(Zend_Db_Table::NAME)), 'a.*', $tDetHorario->info(Zend_Db_Table::SCHEMA));
            $tDetalleHorario = $tDetHorario->fetchAll($select);
            $form=new Application_Form_AsociarHorario();*/
    }
}