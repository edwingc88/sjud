<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Resolucion{
    
    /**
     * Metodo que devuelve todas las resoluciones
     */
    public static function getAllResoluciones($onlySelect = false){
        
        $tResolucion = new Application_Model_DbTable_Resolucion();
        $consulta = $tResolucion->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tResolucion->info(Zend_db_table::NAME)),
                        array('a.*', "SUBSTR(a.id, 1,char_length(a.id)-5) as id1",
                                  "SUBSTR(a.id, char_length(a.id)-4,1) as id2",                                
                                  "SUBSTR(a.id, char_length(a.id)-3,4) as anio"),$tResolucion->info(zend_db_Table::SCHEMA));
                      
        
        $resultado = $tResolucion->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /*
     * Método que permite devolver Resoluciones .
     */
    public static function getAllResolucion($onlySelect = false) {
        
        $tColor = new Application_Model_DbTable_Color();        
        $tEstado = new Application_Model_DbTable_Estado();
        $tReunion = new Application_Model_DbTable_Reunion();        
        $tGerencia = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $tResoluciones = new Application_Model_DbTable_Resolucion();
        
        $sel = $tResoluciones->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a' => $tResoluciones->info(Zend_db_table::NAME)),
                              array('a.*', "SUBSTR(a.id, 1,char_length(a.id)-5) as id1",
                                  "SUBSTR(a.id, char_length(a.id)-4,1) as id2",                                
                                  "SUBSTR(a.id, char_length(a.id)-3,4) as anio",
                                  "length(a.observacion) as tamano",'ruta1' => 'b.descripcion', 'nombre' => 'b.descripcion','color_id'=> 'b.id',
                                  'fecha_reu' => 'c.fecha_real','indice_reu' => 'c.indice','id_reu' => 'c.id',"to_char(c.fecha_real,'dd/MM/yyyy') as fecha_real_reu",
                                  'estado_nombre' => 'd.descripcion','estado_id' => 'd.id',
                                  'gga_id' => 'e.id', 'gga_nombre' => 'e.descripcion','gga_siglas' =>'e.siglas'),$tResoluciones->info(zend_db_Table::SCHEMA))
                       ->join(array('d' => $tEstado->info(zend_db_table::NAME)), 
                                      'a.id_estado = d.id', null, $tEstado->info(Zend_Db_Table::SCHEMA))
                       ->join(array('b' => $tColor->info(zend_db_table::NAME)), 
                              'd.id_color = b.id', null, $tColor->info(Zend_Db_Table::SCHEMA))
                       ->join(array('c' => $tReunion->info(zend_db_table::NAME)), 
                              'a.indice_reunion = c.indice', null, $tReunion->info(Zend_Db_Table::SCHEMA))
                       ->join(array('e' => $tGerencia->info(zend_db_table::NAME)), 
                              'a.id_gga = e.id', null, $tGerencia->info(Zend_Db_Table::SCHEMA));
                                       
        return $onlySelect ? $sel : $tResoluciones->fetchAll($sel);
        
    }
    
    /*
     * Método que permite devolver Resoluciones Con fecha y color.
     */
    public static function getAllResolucionSinAvance($onlySelect = false,$query = null) {
    
        $tColor = new Application_Model_DbTable_Color();        
        $tEstado = new Application_Model_DbTable_Estado();
        $tReunion = new Application_Model_DbTable_Reunion();         
        $tAvance = new Application_Model_DbTable_Avance();
        $tGerencia = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $tResoluciones = new Application_Model_DbTable_Resolucion();
        
        $exp = "extract (month from f.fecha_avance) "; 
        $sel = $tResoluciones->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a' => $tResoluciones->info(Zend_db_table::NAME)),
                              array('a.*', "SUBSTR(a.id, 1,char_length(a.id)-5) as id1",
                                  "SUBSTR(a.id, char_length(a.id)-4,1) as id2",                                
                                  "SUBSTR(a.id, char_length(a.id)-3,4) as anio",
                                  "to_char(f.fecha_avance,'dd/MM/yyyy') as fecha_avance", 
                                  "length(a.observacion) as tamano",
                                  "to_char(a.fecha_creacion,'dd/MM/yyyy') as fecha_creacion_",                                  
                                  "to_char(a.fecha_real,'dd/MM/yyyy') as fecha_real_",
                                  'ruta1' => 'b.descripcion', 'nombre' => 'b.descripcion','color_id'=> 'b.id',
                                  'fecha_reu' => 'c.fecha_real','indice_reu' => 'c.indice','id_reu' => 'c.id',
                                  'estado_nombre' => 'd.descripcion','estado_id' => 'd.id',
                                  'gga_id' => 'e.id', 'gga_nombre' => 'e.descripcion','gga_siglas' =>'e.siglas'),$tResoluciones->info(zend_db_Table::SCHEMA))
                       ->join(array('d' => $tEstado->info(zend_db_table::NAME)), 
                                      'a.id_estado = d.id', null, $tEstado->info(Zend_Db_Table::SCHEMA))
                       ->join(array('b' => $tColor->info(zend_db_table::NAME)), 
                              'd.id_color = b.id', null, $tColor->info(Zend_Db_Table::SCHEMA))
                       ->join(array('c' => $tReunion->info(zend_db_table::NAME)), 
                              'a.indice_reunion = c.indice', null, $tReunion->info(Zend_Db_Table::SCHEMA))
                       ->join(array('e' => $tGerencia->info(zend_db_table::NAME)), 
                              'a.id_gga = e.id', null, $tGerencia->info(Zend_Db_Table::SCHEMA))
                       ->joinLeft(array('f' => $tAvance->info(zend_db_table::NAME)), 
                              'a.indice = f.indice_resolucion', null, $tAvance->info(Zend_Db_Table::SCHEMA))
                       ->where($exp.'!= ?',Zend_Date::now()->toString('MM'))
                       //->where('f.indice_resolucion IS NULL')
                       //->where('')
                       ->order(array('id','fecha_real'));
               Fmo_Logger::debug(Zend_Date::now()->toString('MM'));
        if ($query)
        return $sel;
        else                           
        return $onlySelect ? $sel : $tResoluciones->getAdapter()->fetchAll($sel);
        
    }
    
    /*
     * PRUEBA
     */
    public static function getPrueba($onlySelect = false) {
        
        $tColor = new Application_Model_DbTable_Color();        
        $tEstado = new Application_Model_DbTable_Estado();
        $tReunion = new Application_Model_DbTable_Reunion();         
        $tAvance = new Application_Model_DbTable_Avance();
        $tGerencia = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $tResoluciones = new Application_Model_DbTable_Resolucion();
        
        $sel = $tResoluciones->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a' => $tResoluciones->info(Zend_db_table::NAME)),
                              array('a.indice','a.observacion','a.fecha_creacion','a.fecha_real', 'gga_nombre' => 'e.descripcion'),$tResoluciones->info(zend_db_Table::SCHEMA))
                       ->join(array('d' => $tEstado->info(zend_db_table::NAME)), 
                                      'a.id_estado = d.id', null, $tEstado->info(Zend_Db_Table::SCHEMA))
                       ->join(array('b' => $tColor->info(zend_db_table::NAME)), 
                              'd.id_color = b.id', null, $tColor->info(Zend_Db_Table::SCHEMA))
                       ->join(array('c' => $tReunion->info(zend_db_table::NAME)), 
                              'a.indice_reunion = c.id', null, $tReunion->info(Zend_Db_Table::SCHEMA))
                       ->join(array('e' => $tGerencia->info(zend_db_table::NAME)), 
                              'a.id_gga = e.id', null, $tGerencia->info(Zend_Db_Table::SCHEMA))
                       ->joinLeft(array('f' => $tAvance->info(zend_db_table::NAME)), 
                              'a.indice = f.id_resolucion', null, $tAvance->info(Zend_Db_Table::SCHEMA))
                       ->where('f.id_resolucion IS NULL')
                       ->order(array('id','fecha_real'));
                        
                                       
        return $onlySelect ? $sel : $tResoluciones->fetchAll($sel);
        
    }
    
    /**
     * Método que devuelve ultima resolucion
     */    
    public static function getUltResolucion($anio){
    $exp = "extract (year from a.fecha_real) ";     
    $resolucion = self::getAllResoluciones(true)->where($exp.'= ?',$anio)
            ->order('indice DESC');
    return $resolucion->getAdapter()->fetchRow($resolucion);
    }
    
      /**
     * Metodo que valida resolucion 
     */    
    public static function validarResolucion($id){
        
    $resolucion = self::getAllResoluciones(true)->where('id = ?',$id);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }
        
     /**
     * Metodo devuelve resoluciones por id resolucion
     */
    public static function getDatosResolucion($id){
        
    $exp = "extract (year from a.fecha_real) ";
    $resolucion = self::getAllResolucion(true)->where('a.id = ?',$id);
    $resultado = $resolucion->getAdapter()->fetchAll($resolucion);
    
    return $resultado;
    }
    
   /**
     * Metodo devuelve la resolucion por id y año de resolucion
     */
    public static function getResolucion($id){
    //Fmo_Logger::debug($id.' '.$año);
    $exp = "extract (year from a.fecha_real) ";
    $resolucion = self::getAllResolucion(true)->where('a.id = ?',$id);
    return $resolucion->getAdapter()->fetchRow($resolucion);
    
    
    }
    
     /**
     * Metodo devuelve la resolucion por id y año de resolucion
     */
    public static function getResolucionesAño($año){
    $exp = "extract (year from fecha_real) ";
    $resolucion = self::getAllResoluciones(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where($exp.'= ?',$año);
    return $resolucion->getAdapter()->fetchAll($resolucion);
        
        
    }
    
   
    /**
     * BUSQUEDA EN SEGUIMIENTO
     * 
     */    
    public static function  getResoluciones($id,$id1,$año,$reunion,$gerencia,$clave,$fecha_reunion,$estatus,$año2){
    $cont = 0;
    $arreglo = array('');
    
        
                    if ( $id && $año && ($id1 >= 0)) {
                        Fmo_Logger::debug('entro');
                        if ($cont == 0) {
                        $arreglo[$cont++] = " a.id = '{$id}{$id1}{$año}'";
                        //$arreglo[$cont++] = " AND extract (year from a.fecha_real) = '{$año}'";
                        } else {
                        $arreglo[$cont++] = " AND a.id = '{$id}{$id1}{$año}'";
                        //$arreglo[$cont++] = " AND extract (year from a.fecha_real) = '{$año}'";
                        }
                    }   
                    if ($reunion != null) {
                        $consulta = Application_Model_Reunion::getReunion($reunion);
                        if ($cont == 0) {
                            $arreglo[$cont++] = " a.indice_reunion = '{$consulta->indice}'";                            
                        } else {
                            $arreglo[$cont++] = " AND a.indice_reunion = '{$consulta->indice}'";                            
                        }
                    }
                    if ($gerencia != null) {
                        if ($cont == 0) {
                            $arreglo[$cont++] = " a.id_gga = '{$gerencia}'";       
                            
                        } else {
                            $arreglo[$cont++] = " AND a.id_gga = '{$gerencia}'";                           
                        }
                    }
                    if ($clave != null) {
                       $filter = new Zend_Filter_StringToUpper();
                        $clave = $filter->filter($clave);
                        if ($cont == 0) {
                            //Fmo_Logger::debug($clave);
                            $arreglo[$cont++] =  " a.observacion LIKE '%{$clave}%'";  
                            
                        } else {
                            $arreglo[$cont++] = " AND a.observacion LIKE '%{$clave}%'";
                            
                        }
                    }
                    if ($estatus != null) {
                        if ($cont == 0) {
                            $arreglo[$cont++] = " a.id_estado = '{$estatus}'";  
                            
                        } else {
                            $arreglo[$cont++] = " AND a.id_estado = '{$estatus}'";
                         
                        }
                    }
                    if ($año2 != null) {
                        if ($cont == 0) {
                            $arreglo[$cont++] = " extract (year from a.fecha_real) = '{$año2}'";  
                           
                        } else {
                            $arreglo[$cont++] = " AND extract (year from a.fecha_real) = '{$año2}'";
                           
                        }
                    }
                    if ($fecha_reunion != null) {
                        $fechas = array();
                        /////$exp = '';
                        $fecha_f = new Zend_Date($fecha_reunion);
                        $formato =  $fecha_f->toString('yyyy-MM-dd');
                        //Fmo_Logger::debug('hhh'.$formato);
                        if ($cont == 0) {
                            //Fmo_Logger::debug('REUNIONES');
                            $consulta = Application_Model_Reunion::getReunionPorFecha($formato);
                            //Fmo_Logger::debug($consulta);
                            $arreglo = '' ;
                            if(!empty ($consulta)){
                                $cont2 = 0;
                                foreach ($consulta as $index => $consulta){
                                    $consultaReunion = Application_Model_Reunion::getReunion($consulta->id);
                        
                                    //if($exp != ''){
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " a.indice_reunion = '{$consultaReunion->indice}'";       
                                        }else{
                                        $fechas[$cont2++] = " OR a.indice_reunion = '{$consultaReunion->indice}'";       
                                        }
                                    //}else{
                                        //if($cont2 == 0){
                                        //$fechas[$cont2++] = " a.indice_reunion = '{$consultaReunion->indice}'";       
                                        //}else{
                                        //$fechas[$cont2++] = " OR a.indice_reunion = '{$consultaReunion->indice}'";       
                                        //}
                                    //}
                                }
                                $exp2 = '';
                                for ($i = 0; $i < count($fechas); $i++) {
                                $exp2 = $exp2 . $fechas[$i];
                                }
                                Fmo_Logger::debug($exp2);
                                $nuevo = self::getAllResolucion(true)->where($exp2);
                                $resultado = $nuevo->getAdapter()->fetchAll($nuevo);
                                return $resultado;

                            }else{
                            return $arreglo;    
                            }
                            
                        } else {
                            $exp = '';
                            //JUNTAMOS TODAS LAS CONSULTAS 
                            for ($i = 0; $i < count($arreglo); $i++) {
                                $exp = $exp . $arreglo[$i];
                            }
                            //$arreglo[$cont++] = " AND fecha_reu = '{$año2}'";
                            //Fmo_Logger::debug('REUNIONES');
                            $consulta = Application_Model_Reunion::getReunionPorFecha($formato);
                            //Fmo_Logger::debug($consulta);
                            $arreglo = '' ;
                            if(!empty ($consulta)){
                                $cont2 = 0;
                                foreach ($consulta as $index => $consulta){
                                    $consultaReunion = Application_Model_Reunion::getReunion($consulta->id);
                        
                                    if($exp != ''){
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " AND a.indice_reunion = '{$consultaReunion->indice}'";       
                                        }else{
                                        $fechas[$cont2++] = " OR a.indice_reunion = '{$consultaReunion->indice}'";       
                                        }
                                    }else{
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " AND a.indice_reunion = '{$consultaReunion->indice}'";       
                                        }else{
                                        $fechas[$cont2++] = " OR a.indice_reunion = '{$consultaReunion->indice}'";       
                                        }
                                    }
                                }
                                $exp2 = '';
                                for ($i = 0; $i < count($fechas); $i++) {
                                    
                                $exp2 = $exp2 . $fechas[$i];
                                }
                                $exp3 = $exp.$exp2;
                                //Fmo_Logger::debug($exp2);
                                $nuevo = self::getAllResolucion(true)->where($exp3);
                                $resultado = $nuevo->getAdapter()->fetchAll($nuevo);
                                return $resultado;

                            }else{
                            return $arreglo;    
                            }                       
                         }
                    }else{
                     $exp = '';                            
                        //Fmo_Logger::debug('entro vacio');
                            //JUNTAMOS TODAS LAS CONSULTAS CUANDO NO BUSCAN POR FECHA DE REUNION
                            for ($i = 0; $i < count($arreglo); $i++) {
                                $exp = $exp . $arreglo[$i];
                            }
                            
                        //Fmo_Logger::debug('entro vacio'.$exp);
                            
                            $nuevo = self::getAllResolucion(true)->where($exp);
                            $resultado = $nuevo->getAdapter()->fetchAll($nuevo);
                        
                        
                        return $resultado;
                    }                    
          
    }
    
     /**
     * BUSQUEDA EN RELACIONES
     * 
     */
    public static function  getResolucionRelaciones($id,$id1,$año,$gerencia,$año2){
    
    $exp = "extract (year from a.fecha_real) ";
    if ( $id && $año && ($id1 >= 0)) {
    $resolucion = true;    
    }else{
    $resolucion = false;     
    }    
    //1 Busqueda por año
    if(($año2 != null) && ($gerencia == null) && ( !$resolucion )  ){
    $resolucion = self::getAllResoluciones(true)->where($exp.'= ?',$año2);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }   
    
     //2 Busqueda por gerencia   
    if($gerencia != null && ($año2 == null) && ( !$resolucion)){
    $resolucion = self::getAllResoluciones(true)->where('a.id_gga = ?',$gerencia);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    } 
    
    //3 Busqueda por resolucion
    if ( ($resolucion) && ($año2 == null) && ($gerencia == null)) {
    $resolucion = self::getAllResoluciones(true)->where('a.id = ?',$id.$id1.$año);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }
    
    //4 Busqueda por año y gerencia
    if(($año2 != null) && ($gerencia != null) && ( !$resolucion ) ){
    $resolucion = self::getAllResoluciones(true)->where($exp.'= ?',$año2)->where('a.id_gga = ?',$gerencia);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }
    
    //5 Busqueda por año y resolucion
    if(($año2 != null) && ( $resolucion) && ($gerencia == null)){
    $resolucion = self::getAllResoluciones(true)->where($exp.'= ?',$año2)
            ->where('a.id = ?',$id.$id1.$año);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }
    
     //6 Busqueda por gerencia y resolucion
    if(($año2 == null) && ( $resolucion) && ($gerencia != null)){
    $resolucion = self::getAllResoluciones(true)->where('a.id_gga = ?',$gerencia)
            ->where('a.id = ?',$id.$id1.$año);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }
      
    //7 Busqueda por los 3 parametros   
    if(($año2 != null) && ($gerencia != null) && ( $resolucion) ){
    $resolucion = self::getAllResoluciones(true)->where($exp.'= ?',$año2)->where('a.id_gga = ?',$gerencia)
            ->where('a.id = ?',$id.$id1.$año);
    return $resolucion->getAdapter()->fetchAll($resolucion);
    }
    
    }
    
    
     /*
     * Busqueda resolucion por indice
     * 
     */
    public static function getResolucionIndice($indice,$query = null){
    $resolucion = self::getAllResolucion(true)->where('a.indice = ?',$indice);      
        if ($query)
        return $resolucion;
        else                           
        return $resolucion->getAdapter()->fetchRow($resolucion); 
    }
    
    
    
    
    
    
}