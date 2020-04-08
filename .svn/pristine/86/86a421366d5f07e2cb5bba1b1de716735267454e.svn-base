<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Miembros{
    
    
    /**
     * 
     * Metodo que devuelve todos los miembros de la junta directiva
     * 
     */
    public static function getAllMiembrosJunta($onlySelect = false){
        
        $tMiembros = new Application_Model_DbTable_Miembros();      
        $tCargo = new Application_Model_DbTable_Cargo();
        
        $consulta = $tMiembros->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tMiembros->info(Zend_db_table::NAME)),
                              array('a.*', 'cargo_id' => 'b.id', 'descripcion' => 'b.descripcion','cargo_nivel'=> 'b.nivel_cargo',)
                        ,$tMiembros->info(zend_db_Table::SCHEMA))
                ->join(array('b' => $tCargo->info(zend_db_table::NAME)), 
                             'a.id_cargo = b.id', null, $tCargo->info(Zend_Db_Table::SCHEMA));
                     
        $resultado = $tMiembros->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /**
     * 
     * Metodo que devuelve todos los miembros de la junta directiva ordenados por fecha
     * 
     */    
    public static function getFechaJunta(){
        
    $miembro = self::getAllMiembrosJunta(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('fecha_periodo'))->where('m_vigencia_jd =?',1)
            ->order('fecha_periodo DESC');
    return $miembro->getAdapter()->fetchOne($miembro);
    }
    
    /**
     * 
     * Metodo que devuelve todos los miembros historicos de la Junta Directiva
     * 
     */
    public static function getAllMiembrosAnteriores(){
        /*select a.*,c.*
        from sch_sjud.miembros as a, (SELECT id_cargo, max(fecha_periodo) as fecha_periodo
        FROM sch_sjud.miembros
        where fecha_periodo < '2016-05-22'
        group by id_cargo
        order by id_cargo
        ) as b, sch_sjud.cargo as c
        where a.id_cargo = b.id_cargo and a.fecha_periodo = b.fecha_periodo and a.id_cargo = c.id --and m_vigencia_jd = 1 
        */
        
        
                //Fmo_Logger::debug($actual->fecha_periodo);
        
        
        $miembro = self::getAllMiembrosJunta(true)->where('m_vigencia_jd = ?', 1);
            //->order('id_cargo ASC');
        $actual = $miembro->getAdapter()->fetchRow($miembro);
        $miembro = self::getFechaJunta();
        Fmo_Logger::debug($miembro);
        
        $tMiembros = new Application_Model_DbTable_Miembros();
        $tCargo = new Application_Model_DbTable_Cargo();
     
        $consulta = $tMiembros->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tMiembros->info(Zend_db_table::NAME)),
                              array('a.*', 'cargo_id' => 'b.id',
                                  'descripcion' => 'b.descripcion',
                                  'cargo_nivel'=> 'b.nivel_cargo',
                                 //"to_char(a.fecha_periodo,'dd/MM/yyyy') as fecha_periodo",
                                 //"to_char(a.fecha_periodo,'dd/MM/yyyy') as fecha_periodo",
                                 "to_char(a.fecha_periodo,'dd/MM/yyyy') as fecha_periodo",)
                        ,$tMiembros->info(zend_db_Table::SCHEMA))
                ->join(array('b' => $tCargo->info(zend_db_table::NAME)), 
                             'a.id_cargo = b.id', null, $tCargo->info(Zend_Db_Table::SCHEMA))
                
                ->where('a.m_vigencia_jd = ?', 0)
                ->where('a.fecha_periodo = ?','2016-07-11')
                ->order(array('a.fecha_periodo DESC','a.id_cargo ASC','a.fecha_periodo DESC'));
                
        //Zend_Debug::dd($consulta->__tostring());    
        return $tMiembros->getAdapter()->fetchAll($consulta);            
        $resultado = $tMiembros->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado; 
    }
    
    /**
     * 
     * Metodo que devuelve todos los miembros Anteriores de la Junta Directiva
     * 
     */  
    
    public static function getMiembrosAnterioresConActual(){
    //Fmo_Logger::debug(Application_Model_Miembros::modificacionJunta());
        $tMiembros = new Application_Model_DbTable_Miembros();
        $tCargo = new Application_Model_DbTable_Cargo();
        
        /*$actual = $tMiembros->select()
                          ->from(array('a' => $tMiembros->info(Zend_Db_Table::NAME)), '*', $tMiembros->info(Zend_Db_Table::SCHEMA))
                          ->where('fecha_periodo = ?','2016-07-13');
        $miembros_actual = count($tMiembros->getAdapter()->fetchCol($actual));
        
        $activa = $tMiembros->select()
                          ->from(array('a' => $tMiembros->info(Zend_Db_Table::NAME)), '*', $tMiembros->info(Zend_Db_Table::SCHEMA))
                          ->where('m_vigencia_jd = ?',1);  
        $miembros_activo = count($tMiembros->getAdapter()->fetchCol($actual));*/
        
        
            $sel1 = $tMiembros->select()->from(array('r' =>$tMiembros->info(Zend_Db_Table::NAME)), new Zend_Db_Expr('NULL'), 
                                $tMiembros->info(Zend_Db_Table::SCHEMA))
                                ->where('m_vigencia_jd = ?', 0, Zend_Db::INT_TYPE)
                                ->where('r.id_cargo = a.id_cargo')
                                ->where('r.fecha_periodo = a.fecha_periodo');
            $sel2 = $tMiembros->select()->from(array('a' => $tMiembros->info(Zend_Db_Table::NAME)), '*', 
                                $tMiembros->info(Zend_Db_Table::SCHEMA))
                                ->where('m_vigencia_jd = ?', 0, Zend_Db::INT_TYPE);
            
            $sel3 = $tMiembros->select()->from(array('a' => $tMiembros->info(Zend_Db_Table::NAME)), '*', 
                                $tMiembros->info(Zend_Db_Table::SCHEMA))
                                ->where('m_vigencia_jd = ?', 1,Zend_Db::INT_TYPE)
                                ->where('NOT EXISTS (?)', $sel1);
            
            
            $sel4 = $tMiembros->select()
                              ->union(array($sel2, $sel3));
            $sel5 = $tMiembros->select()
                              ->setIntegrityCheck(false)
                              ->from(array('miembro' => new Zend_Db_Expr("({$sel4})")),
                                array('miembro.cedula', 
                                    'miembro.nombre', 
                                    'miembro.ficha', 
                                    //'miembro.fecha_periodo',
                                    'miembro.id_cargo', 
                                    'c.descripcion', 
                                    'miembro.m_vigencia_jd',
                                    //'miembro.fecha_periodo',
                                    'miembro.fecha_periodo'))
                              ->join(array('c' => 
                                $tCargo->info(Zend_Db_Table::NAME)), 'miembro.id_cargo = c.id', null, $tCargo->info(Zend_Db_Table::SCHEMA));
              
                              Fmo_Logger::debug(Application_Model_Miembros::modificacionJunta());                
           if((Application_Model_Miembros::modificacionJunta()) != null ){
           $sel5->order(array('fecha_periodo DESC', 'id_cargo'));    
           }else{
               if(Application_Model_Miembros::getFechaJunta() != null){
               $sel5->where('fecha_periodo != ?',  Application_Model_Miembros::getFechaJunta())
                ->order(array('fecha_periodo DESC', 'id_cargo'));
                }else{
                 $sel5->order(array('fecha_periodo DESC', 'id_cargo'));   
                }
           
           }
                             
        /*$consulta = "select miembro.cedula,miembro.nombre,miembro.ficha,miembro.fecha_periodo, miembro.id_cargo,
        c.descripcion, miembro.m_vigencia_jd, miembro.fecha_inicio_miembro, miembro.fecha_fin_miembro
        from   (select *
      from sch_sjud.miembros a
      where  m_vigencia_jd = 0
      union
      select *
      from sch_sjud.miembros a
      where m_vigencia_jd = 1
      and not exists (select null
               from sch_sjud.miembros r
               where m_vigencia_jd = 0
                 and r.id_cargo = a.id_cargo
                 and r.fecha_periodo = a.fecha_periodo
                  ) )miembro,
    sch_sjud.cargo c
        where miembro.id_cargo = c.id
        order by fecha_periodo  DESC, id_cargo";
        
        /*$consulta = $tMiembros->select()->from(array('a' => $tMiembros->info(Zend_db_table::NAME)),array(''),$tMiembros->info(zend_db_Table::SCHEMA));
        */
           //Zend_Debug::dd($sel5->__toString());
           if($sel5 !=  null){
        $resultado = $tMiembros->getAdapter()->fetchAll($sel5);
         return $resultado;
           }else{
               return "";
           }
              
    } 
    
    /**
     * 
     * Metodo que devuelve todos los miembros Anteriores de la Junta Directiva
     * 
     */  
    
    public static function modificacionJunta(){

     $tMiembros = new Application_Model_DbTable_Miembros();        
     $consulta = "select *
      from sch_sjud.miembros a
      where m_vigencia_jd = 1
      and exists(select null
                  from sch_sjud.miembros r
                 where m_vigencia_jd = 0
                   and r.id_cargo = a.id_cargo
                   and r.fecha_periodo = a.fecha_periodo
                   --and fecha_periodo = '2016-07-13' 
                   )";
     $resultado = $tMiembros->getAdapter()->fetchAll($consulta);
     return $resultado;
      
    }
    public static function getMiembrosActuales(){
    
    $fecha = Application_Model_Miembros::getFechaJunta();    
    $miembro = self::getAllMiembrosJunta(true)->where('fecha_periodo < ?', $fecha)->where('m_vigencia_jd = ?', 1)
            ->limit(20)
            ->order('id_cargo ASC');
    Fmo_Logger::debug($miembro);
    return $miembro->getAdapter()->fetchAll($miembro);
    }
    
    /**
     * 
     * Metodo que devuelve todos los miembros actuales de la Junta Directiva
     * 
     */    
    public static function getJuntaActual(){
       
    $miembro = self::getAllMiembrosJunta(true)->where('m_vigencia_jd = ?', 1)
            ->order('id_cargo ASC');
    return $miembro->getAdapter()->fetchAll($miembro);
    }
    
     /**
     * 
     * Metodo que devuelve un mimebro de la junta directiva
     * 
     */    
    public static function getMiembro($id,$fecha){
        
    $miembro = self::getAllMiembrosJunta(true)->where('ficha = ?', $id)->where('fecha_periodo = ?', $fecha);
    return $miembro->getAdapter()->fetchRow($miembro);
    }   
    
    
    /**
     * 
     * Metodo que valida si no hay 2 presidentes en un periodo
     * 
     */
    
    public static function validarPresidente($fecha,$cargo){
    $presidente = self::getAllMiembrosJunta(true)->where('fecha_periodo = ?',$fecha)
            ->where('id_cargo = ?', $cargo);
    return $presidente->getAdapter()->fetchAll($presidente);
         
        
    }
    /*
     * Método para validar que un miembro no tenga 2 cargos en la junta directiva.
     */
    public static function validarMiembro($cedula,$fecha){
    $miembro = self::getAllMiembrosJunta(true)->where('fecha_periodo = ?',$fecha)
            ->where('cedula = ?', $cedula);
    return $miembro->getAdapter()->fetchAll($miembro);
         
        
    }
    
    
    
    
    
    
    
}