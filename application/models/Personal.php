<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
class Application_Model_Personal extends Fmo_Model_Personal
{
    
    public static function trabajadorSelect($ficha)
    {
        $tDatBas = new Fmo_DbTable_Rpsdatos_DatoBasico();
        $tTipNom = new Fmo_DbTable_Rpsdatos_Nomina();
        $tCargo  = new Fmo_DbTable_Rpsdatos_Cargo(); 
        $tCeco   = new Fmo_DbTable_Rpsdatos_CentroCosto();
        
        
        
        $exp = " a.datb_nrotrab || ' - ' || upper(a.datb_apellid) || ' ' || initcap(a.datb_nombre) || b.tpno_descri ";
        
        $selec = $tDatBas->select()->distinct()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tDatBas->info(Zend_Db_Table::NAME)), array('a.*','b.tpno_descri AS tipo_nomina','c.carg_descri AS cargo','d.ceco_descri AS ceco' ), $tDatBas->info(Zend_Db_Table::SCHEMA))
                ->join(array('b' => $tTipNom->info(Zend_Db_Table::NAME)), 'b.tpno_tpno = a.datb_tpno', null, $tTipNom->info(Zend_Db_Table::SCHEMA))
                ->join(array('c' => $tCargo->info(Zend_Db_Table::NAME)), 'c.carg_carg = a.datb_carg', null, $tCargo->info(Zend_Db_Table::SCHEMA))
                ->join(array('d' => $tCeco->info(Zend_Db_Table::NAME)), 'd.ceco_ceco = a.datb_ceco', null, $tCeco->info(Zend_Db_Table::SCHEMA))
                ->where('a.datb_activi <> ?', 9)
                ->where('a.datb_nrotrab = ?',$ficha);
             
         echo $selec->__toString();
       
        return $tDatBas->fetchRow($selec);
    }
    
       /**/
    public static function getCedulaORFicha($num)
    {
        $tTable = new Fmo_DbTable_Rpsdatos_DatoBasico();
        $select = $tTable->select()->distinct()
                    ->setIntegrityCheck(false)
                    ->from(array('a' => $tTable->info(Zend_Db_Table::NAME)), array('ficha' => 'a.datb_nrotrab', 'cedula' => 'a.datb_cedula'), $tTable->info(Zend_Db_Table::SCHEMA))
                    ->where('a.datb_activi <> ?', 9)
                    ->limit(5)
                ->Where('"a"."datb_nrotrab"::character varying = ?', $num)
                ->orWhere('"a"."datb_cedula"::character varying = ?', $num);
          
        return $tTable->fetchRow($select);
    }
}