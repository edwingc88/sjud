<?php


/**
 * Modelo para la administración de los lugares en los que se realizan los
 * actos protocolares para la entrega de las condecoraciones.
 *  
 * @author manuelry <manuelry@ferrominera.gob.ve
 */
class Application_Model_Punto{
    
    /**
     * Metodo que devuelve todos los puntos
     */
    public static function getAllPuntos($onlySelect = false){
        
        $tPunto = new Application_Model_DbTable_Punto();
        $consulta = $tPunto->select()
                ->setIntegrityCheck(false)
                ->from($tPunto,array('*'));
        
        $resultado = $tPunto->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
    /**
     * Metodo que devuelve todos los puntos
     */
    public static function getAllModalidad($onlySelect = false){
        
        $tModalidad = new Application_Model_DbTable_Modalidad();
        $consulta = $tModalidad->select()
                ->setIntegrityCheck(false)
                ->from($tModalidad,array('*'));
        
        $resultado = $tModalidad->getAdapter()->fetchAll($consulta);
        return $onlySelect ? $consulta : $resultado;
    }
    
     /*
     * Método que permite devolver Puntos de cuenta e informacion.
     */
    public static function getAllPuntosCI($onlySelect = false) {
        
        $tColor = new Application_Model_DbTable_Color();
        $tModalidad = new Application_Model_DbTable_Modalidad();        
        $tEstado = new Application_Model_DbTable_Estado();
        $tGerencia = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $tPuntos = new Application_Model_DbTable_Punto();
        
        $sel = $tPuntos->select()
                       ->setIntegrityCheck(false)
                       ->from(array('a' => $tPuntos->info(Zend_db_table::NAME)),
                              array('a.*', 'ruta1' => 'b.descripcion', 'nombre' => 'b.descripcion','color_id'=> 'b.id',
                                  "to_char(a.fecha_real, 'yyyy') as anio",
                                  'estado_nombre' => 'd.descripcion','estado_id' => 'd.id',
                                  'gga_id' => 'e.id', 'gga_nombre' => 'e.descripcion','gga_siglas' =>'e.siglas',
                                  'id_modalidad' => 'c.id','nombre_modalidad' => 'c.descripcion'),$tPuntos->info(zend_db_Table::SCHEMA))
                       ->join(array('d' => $tEstado->info(zend_db_table::NAME)), 
                               'a.id_estado = d.id', null, $tEstado->info(Zend_Db_Table::SCHEMA))
                       ->join(array('c' => $tModalidad->info(zend_db_table::NAME)), 
                              'a.id_modalidad = c.id', null, $tModalidad->info(Zend_Db_Table::SCHEMA))
                       ->join(array('b' => $tColor->info(zend_db_table::NAME)), 
                              'd.id_color = b.id', null, $tColor->info(Zend_Db_Table::SCHEMA))
                       ->join(array('e' => $tGerencia->info(zend_db_table::NAME)), 
                              'a.id_gga = e.id', null, $tGerencia->info(Zend_Db_Table::SCHEMA));
                                       
        return $onlySelect ? $sel : $tPuntos->fetchAll($sel);
        
    } 
    
    
     /**
     * Metodo que devuelve puntos por fecha de registro
     */    
    public static function getPuntosPorFecha($fecha){
        
    $puntos = self::getAllPuntos(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('fecha_creacion'))->where('fecha_creacion = ?', $fecha)
            ;
    //Fmo_Logger::debug($puntos);
    return $puntos->getAdapter()->fetchAll($puntos);
    }
    
    /**
     * BUSQUEDA EN SEGUIMIENTO
     * 
     */    
    public static function  getPuntos($gerencia,$modalidad,$siglas,$id,$año,$clave,$fecha_registro,$estatus,$año2){
    
        Fmo_Logger::debug('gerenciaView'.$gerencia);
        Fmo_Logger::debug('modalidadView'.$modalidad);
        Fmo_Logger::debug('numPuntoView'.$siglas);
        Fmo_Logger::debug('numPunto1View'.$id);
        Fmo_Logger::debug('añoView'.$año);        
        Fmo_Logger::debug('palabraView'.$clave);
        Fmo_Logger::debug('fechaView'.$fecha_registro);
        Fmo_Logger::debug('estadoView'.$estatus);
        Fmo_Logger::debug('anio2View'.$año2);
        
        $cont = 0;
    $arreglo = array('');
                    if ( $siglas && $año && $id ) {
                        if ($cont == 0) {
                        $arreglo[$cont++] = " a.id = '$id'";
                        $arreglo[$cont++] = " AND extract (year from a.fecha_real) = '{$año}' AND a.siglas = '{$siglas}'";
                        } else {
                        $arreglo[$cont++] = " AND a.id = '{$id}{$id1}'";
                        $arreglo[$cont++] = " AND extract (year from a.fecha_real) = '{$año}'  AND a.siglas = '{$siglas}' ";
                        }
                    }   
                    if ($gerencia != null) {
                        if ($cont == 0) {
                            $arreglo[$cont++] = " a.id_gga = '{$gerencia}'";       
                            
                        } else {
                            $arreglo[$cont++] = " AND a.id_gga = '{$gerencia}'";                           
                        }
                    }
                    if ($modalidad != null) {
                        if ($cont == 0) {
                            $arreglo[$cont++] = " a.id_modalidad = '{$modalidad}'";                            
                        } else {
                            $arreglo[$cont++] = " AND a.id_modalidad = '{$modalidad}'";                            
                        }
                    }
                    if ($clave != null) {
                        if ($cont == 0) {
                            //Fmo_Logger::debug($clave);
                            $arreglo[$cont++] =  " a.observacion ILIKE '%{$clave}%'";  
                            
                        } else {
                            $arreglo[$cont++] = " AND a.observacion ILIKE '%{$clave}%'";
                            
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
                    //PUNTOS POR FECHA DE REGISTRO
                    if ($fecha_registro != null) {
                        $fechas = array();
                        $exp = '';
                        $fecha_f = new Zend_Date($fecha_registro);
                        $formato =  $fecha_f->toString('yyyy-MM-dd');
                        if ($cont == 0) {
                            $consulta = Application_Model_Punto::getPuntosPorFecha($formato);
                            //Fmo_Logger::debug($consulta);
                            $arreglo = '' ;
                            if(!empty ($consulta)){
                                $cont2 = 0;
                                foreach ($consulta as $index => $consulta){
                                $formato_fecha = $consulta->fecha_creacion;
                                //Fmo_Logger::debug($formato_fecha);
                                    if($exp != ''){
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " a.fecha_creacion = '{$formato_fecha}'";       
                                        }else{
                                        $fechas[$cont2++] = " OR a.fecha_creacion = '{$formato_fecha}'";       
                                        }
                                    }else{
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " a.fecha_creacion = '{$formato_fecha}'";       
                                        }else{
                                        $fechas[$cont2++] = " OR a.fecha_creacion = '{$formato_fecha}'";       
                                        }
                                    }
                                }
                                $exp2 = '';
                                for ($i = 0; $i < count($fechas); $i++) {
                                $exp2 = $exp2 . $fechas[$i];
                                }
                                //Fmo_Logger::debug($exp2);
                                $nuevo = self::getAllPuntosCI(true)->where($exp2);
                                $resultado = $nuevo->getAdapter()->fetchAll($nuevo);
                                return $resultado;

                            }else{
                            return $arreglo;    
                            }
                            
                        } else {
                            $exp = '';
                            //JUNTAMOS TODAS LAS CONSULTAS CUANDO NO BUSCAN POR FECHA DE REUNION
                            for ($i = 0; $i < count($arreglo); $i++) {
                                $exp = $exp . $arreglo[$i];
                            }
                            $arreglo[$cont++] = " AND fecha_reu = '{$año2}'";
                            $fecha_f = new Zend_Date($fecha_registro);
                            $formato =  $fecha_f->toString('yyyy-MM-dd');
                            $consulta = Application_Model_Punto::getPuntosPorFecha($formato);
                            $arreglo = '' ;
                            if(!empty ($consulta)){
                                $cont2 = 0;
                                foreach ($consulta as $index => $consulta){
                                    $formato_fecha = $consulta->fecha_creacion;
                                    if($exp != ''){
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " AND a.fecha_creacion = '{$formato_fecha}'";       
                                        }else{
                                        $fechas[$cont2++] = " AND a.fecha_creacion = '{$formato_fecha}'";       
                                        }
                                    }else{
                                        if($cont2 == 0){
                                        $fechas[$cont2++] = " AND a.fecha_creacion = '{$formato_fecha}'";       
                                        }else{
                                        $fechas[$cont2++] = " AND a.fecha_creacion = '{$formato_fecha}'";       
                                        }
                                    }
                                }
                                $exp2 = '';
                                for ($i = 0; $i < count($fechas); $i++) {
                                    
                                $exp2 = $exp2 . $fechas[$i];
                                }
                                $exp = $exp.$exp2;
                                //Fmo_Logger::debug('aQUI');
                                //Fmo_Logger::debug($exp);
                                $nuevo = self::getAllPuntosCI(true)->where($exp);
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
                            $nuevo = self::getAllPuntosCI(true)->where($exp);
                            $resultado = $nuevo->getAdapter()->fetchAll($nuevo);
                        
                        
                        return $resultado;
                    }
       
    }
    
    
    /**
     * Metodo que devuelve ultimo punto
     */    
    public static function getUltPunto($punto){
        
    $ultPunto = self::getAllPuntos(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('*'))->where('id_modalidad = ?', $punto)
            ->order('indice DESC');
    return $ultPunto->getAdapter()->fetchRow($ultPunto);
    }
    
    /**
     * Metodo que devuelve Modalidades para combobox
     */    
    public static function getModalidadesCombobox(){
           
    $modalidad = self::getAllModalidad(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id','descripcion'));
    return $modalidad->getAdapter()->fetchPairs($modalidad);
    
    }
    
     /**
     * Metodo que devuelve Modalidades
     */    
    public static function getModalidades($id){
          
    $modalidad = self::getAllModalidad(true)->reset(Zend_Db_Table::COLUMNS)
            ->columns(array('id'))->where('id = ?',$id);
    Fmo_Logger::debug($modalidad->getAdapter()->fetchOne($modalidad));
    return $modalidad->getAdapter()->fetchOne($modalidad);
    
    }
    /**
     * Metodo que valida Punto 
     */    
    public static function validarPunto($id,$modalidad,$año){
    
    $exp = "extract (year from fecha_real) ";    
    $punto = self::getAllPuntos(true)->where('id = ?',$id)->where('id_modalidad = ?',$modalidad)
            ->where($exp.'= ?',$año);
    return $punto->getAdapter()->fetchAll($punto);
    }
     /**
     * Metodo devuelve punto especifico
     */
    public static function getDatosPunto($siglas,$num,$año,$modalidad){
    $exp = "extract (year from a.fecha_real) ";
    
    $datos = self::getAllPuntosCI(true)->where('a.siglas = ?',$siglas)
            ->where('a.id = ?',$num)->where($exp.'= ?', $año)->where('a.id_modalidad = ?',$modalidad);
            
    
    return $datos->getAdapter()->fetchAll($datos);
        
        
    }
    /**
     * Metodo devuelve el punto
     */
    public static function getPunto($siglas,$num,$año,$modalidad){
    $exp = "extract (year from fecha_real) ";
    
    $datos = self::getAllPuntos(true)->where('siglas = ?',$siglas)
            ->where('id = ?',$num)->where($exp.'= ?', $año)->where('id_modalidad = ?',$modalidad);
            
    
    return $datos->getAdapter()->fetchRow($datos);
    
    
    }
    
    
     /*
     * Busqueda de punto por indice
     * 
     */
    public static function getPuntoIndice($id){

    $punto = self::getAllPuntosCI(true)->where('a.indice = ?',$id);
    return $punto->getAdapter()->fetchRow($punto);    
     
    }
    
    
}