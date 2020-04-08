 <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of miembro
 *
 * @author manuelry
 */
class Application_Form_Resolucion extends Fmo_Form_Abstract {

    const E_GERENCIA    = 'gerencia'   ; 
    const E_PALABRA_CLAVE = 'clave';
    const E_ASUNTO    = 'observacion'    ;     
    const E_ULT_RESOLUCION  = 'ultima_resolcuion';
    const E_NUM_RESOLUCION  = 'resolucion'    ;  
    const E_NUM_RESOLUCION1 = 'resolucion1'    ;
    const E_AÑO            = 'anio';
    const E_AÑO2            = 'anio2';
    const E_NUM_REUNION     = 'id_reunion'    ;     
    const E_FECHA           = 'fecha_resolucion'    ;
    const E_NOTIFICACION    = 'notificacion'    ; 
    const E_ESTADO          = 'estado';
    
   
    const E_IMPRIMIR = 'imprimir';
    const E_VOLVER = 'volver';
    const E_ELIMINAR = 'eliminar';
    const E_AGREGAR = 'agregar';
    const E_LIMPIAR = 'limpiar';    
    const E_BUSCAR  = 'buscar' ;
    const E_GUARDAR  = 'guardar' ;
    const E_MODIFICAR  = 'modificar' ;
    const E_CANCELAR = 'cancelar';
    const E_PDF = 'generar_pdf';    
    const E_EXCEL = 'generar_excel';
    private $indiceResolucion;
    private $nombreArchivo;
    /*
     * Método de creación del formulario.
     */
    public function init() {
        
         $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
        // Combobox para seleccionar la gerencia.
        $comboboxGerencia = new Zend_Form_Element_Select(self::E_GERENCIA);
        $comboboxGerencia->setLabel('Gerencias Gral./Coord:')
                ->setRequired()
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_GerenciaGeneralCoordinacion::getGerenciaCombobox())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxGerencia);        
        
        // Combobox para seleccionar Estado.
        $comboboxEstatus = new Zend_Form_Element_Select(self::E_ESTADO);
        $comboboxEstatus->setLabel('Estado:')
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_Estado::getEstadoTipo('RESOLUCION'))
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxEstatus);
        
           // Campo asunto de resolucion.
        $campoAsunto = new Zend_Form_Element_Textarea(self::E_ASUNTO);
        $campoAsunto->setLabel('Asunto:')                             
                    ->addFilter('StringToUpper')
                    ->addFilter('StringTrim')
                    ->setAttrib('cols', '40')
                    ->setAttrib('rows', '5')
                    //->setAttrib('style', 'text-align: left; width: 97%, heigth:50% ;')                                
                    //->addValidator('alnum',true)
                    ->addValidator('StringLength', false, array('min' => 1, 'max' => 450))
                    ->setRequired()
                    ->setDecorators($this->_decoratorElement);;
        $this->addElement($campoAsunto);
        $fecha = 
        $ultima = Application_Model_Resolucion::getUltResolucion(Zend_Date::now()->toString('yyyy'));

        if(!empty($ultima)){
            $id_resol = $ultima->id1;  
            $anio = $ultima->anio;
            $corte = $ultima->id2;
            }else{
            $id_resol = '';  
            $anio = '';
            $corte = '';    
            }
            
        // Campo ultima resolucion
        $campoUltResolucion = new Zend_Form_Element_Note(self::E_ULT_RESOLUCION);
        $campoUltResolucion->setLabel('Ultima Resolución:')
                           /*->setValue($id_resol.'/'.$corte.'/'.$anio)*/
                           ->setValue($id_resol.$corte.$anio)
                           ->setDecorators($this->_decoratorElement);
        $this->addElement($campoUltResolucion);
        //$id_resol

        /*$pathSplitted = explode(DIRECTORY_SEPARATOR, $ruta);
          $fileName = $pathSplitted[count($pathSplitted) - 1];
          $tipo = substr($nombre, strlen($nombre)-4,  strlen($nombre));
          Fmo_Logger::debug($tipo);
          $file = (PATH_UPLOAD_FILES . DIRECTORY_SEPARATOR . $nombre);
          $file = (PATH_UPLOAD_FILES . DIRECTORY_SEPARATOR . $fileName);
         
        Fmo_Logger::debug($file);*/
        
           // Campo 1 de numero de resolucion
        $campoClave = new Zend_Form_Element_Text(self::E_PALABRA_CLAVE);
        $campoClave->setLabel('Palabra Clave asunto:')   
                ->setAttrib('size', '40')
                ->setAttrib('maxlength', '250')
                ->addFilter('StringTrim')
                        ->addValidator('StringLength', false, array('min' => 1, 'max' => 15));
                        
        $this->addElement($campoClave);
        
           // Campo 1 de numero de resolucion
        $campoResolucion = new Zend_Form_Element_Text(self::E_NUM_RESOLUCION);
        $campoResolucion->setLabel('Numero Resolución:')     
                        ->setAttrib('maxlength', '3')
                        ->setAttrib('style', 'text-align: left; width: 12%;')
                        ->addValidator('stringLength', false, array(3, 3))
                        //->addValidator('Int', true) Anaicelys Brito
                        ->setRequired();
        $this->addElement($campoResolucion);
        
           // Campo 2 de numero de resolucion
        $campoResolucion1 = new Zend_Form_Element_Text(self::E_NUM_RESOLUCION1);
        $campoResolucion1->setRequired()
                         ->setAttrib('maxlength', '3')
                         ->setAttrib('style', 'text-align: left; width: 12%;')                
                         ->addValidator('stringLength', false, array(3, 3))
                          //->addValidator('Int', true) Anaicelys Brito
                        ->setRequired();
        $this->addElement($campoResolucion1);
        
           // Campo anio actual de resolucion .
        $campoAnio = new Zend_Form_Element_Text(self::E_AÑO);
        $campoAnio->setLabel('Año:')
                ->setAttrib('maxlength', '4')
                  ->setAttrib('style', 'text-align: left; width: 12%;')                
                  ->addValidator('Int', true)
                  ->addValidator('stringLength', false, array(4, 4))
                  //->setValue(Zend_Date::now()->toString('yyyy'))        
                  ->setRequired();
        $this->addElement($campoAnio);
        
            // Campo anio actual de resolucion .
        $campoAnio2 = new Zend_Form_Element_Text(self::E_AÑO2);
        $campoAnio2->setLabel('Año:')
                ->setAttrib('maxlength', '4')
                  ->setAttrib('style', 'text-align: left; width: 12%;')
                  ->addValidator('Int', true)                
                  ->addValidator('stringLength', false, array(4, 4))
                  ->setRequired();
        $this->addElement($campoAnio2);
        
        // Campo numero de reunion
         $tReunion = new Application_Model_DbTable_Reunion();
        // Campo numero de reunion.
        $campoReunion = new Zend_Form_Element_Text(self::E_NUM_REUNION);
        $campoReunion->setLabel('Numero Reunión:')
                     ->setAttrib('size', '20')
                     ->setAttrib('maxlength', '10')
                     ->addFilter('StringTrim')
                     ->addValidator('StringLength', false, array('min' => 1, 'max' => 9))
                     ->setDecorators($this->_decoratorElement)
                     ->setRequired();
        $this->addElement($campoReunion);
        
        $notificaciones = array('1' => '1','2' => '2','3' => '3','4' => '4','5' => '5',
            '6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12',
            '13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '19',
            '20' => '20','21' => '21','22' => '22','23' => '23','24' => '24','25' => '25','26' => '26',
            '27' => '27','28' => '28','29' => '29','30' => '30');
        // Combobox para seleccionar dias para notificaciones.
        $comboboxNotificacion = new Zend_Form_Element_Select(self::E_NOTIFICACION);
        $comboboxNotificacion->setLabel('Notificación:')->setDescription('Días posteriores a fecha de reunión')
                ->setRequired()
                ->addMultiOption('', 'Dias')
                ->addMultiOptions($notificaciones)
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxNotificacion);
        
          // Campo fecha del periodo de junta directiva  
        $fecha = new Fmo_Form_Element_DatePicker(self::E_FECHA);
        $fecha->setLabel('Fecha Efect. Reunión:')
              ->setDescription('Formato de Fecha: DD-MM-AAAA')
              ->setRequired();
        $valDbw2 = new Fmo_Validate_DateBetween(array('format' => $fecha->getValidator('Date')->getFormat()));
        $hoy = new Zend_Date();
        $valDbw2->setMin($valDbw2->getMinDate()->subyear(50));
        $valDbw2->setMax($hoy);

        $scrip2 = 'Calendar.setup( { '
                . "inputField : '{$fecha->getName()}', "
                . "trigger: 'img-{$fecha->getName()}', "
                . "ifFormat: '%d/%m/%Y', "
                . "dateFormat: '%d/%m/%Y', "
                . 'onSelect: function() { this.hide(); }, '
                //. "min: {$valDbw2->getMinDate()->toString('yyyyMMdd')}, "
                . "max: {$valDbw2->getMaxDate()->toString('yyyyMMdd')} "
                . '} );';
        $fecha->setCalendarScript($scrip2)->addValidator($valDbw2);
        $this->addElement($fecha); 
        $this->_decoratorElementDatePicker[0][1]['viewScript'] = 'dp.phtml';    
        
        // Botones del formulario.
        $buscar = new Zend_Form_Element_Submit(self::E_BUSCAR);
        $buscar->setLabel('Buscar')
                ->setIgnore(true);
        $this->addElement($buscar);
        
        // Botones del formulario.
        $guardar = new Zend_Form_Element_Submit(self::E_GUARDAR);
        $guardar->setLabel('Guardar')
                ->setIgnore(true);
        $this->addElement($guardar);

        // Botones del formulario.
        $limpiar = new Zend_Form_Element_Submit(self::E_LIMPIAR);
        $limpiar->setLabel('Limpiar')
                ->setIgnore(true);
        $this->addElement($limpiar);
        
         // Botones del formulario.
        $agregar = new Zend_Form_Element_Submit(self::E_AGREGAR);
        $agregar->setLabel('Agregar')
                ->setIgnore(true);
        $this->addElement($agregar);
        
        // Botones del formulario.
        $cancelar = new Zend_Form_Element_Submit(self::E_CANCELAR);
        $cancelar->setLabel('Cancelar')
                ->setIgnore(true);
        $this->addElement($cancelar);
        
         // Botones del formulario.
        $modificar = new Zend_Form_Element_Submit(self::E_MODIFICAR);
        $modificar->setLabel('Modificar')
                ->setIgnore(true);
        $this->addElement($modificar);
        
         // Botones del formulario.
        $eliminar = new Zend_Form_Element_Submit(self::E_ELIMINAR);
        $eliminar->setLabel('Eliminar')
                ->setIgnore(true);
        $this->addElement($eliminar);
        
          // Botones del formulario.
        $imprimir = new Zend_Form_Element_Submit(self::E_IMPRIMIR);
        $imprimir->setLabel('Imprimir')
                ->setIgnore(true);
        $this->addElement($imprimir);
        
        // Botones del formulario.
        $generarPdf = new Zend_Form_Element_Submit(self::E_PDF);
        $generarPdf->setLabel('Generar PDF')
                ->setIgnore(true);
        $this->addElement($generarPdf);        
        
        // Botones del formulario.
        $generarXls = new Zend_Form_Element_Submit(self::E_EXCEL);
        $generarXls->setLabel('Generar EXCEL')
                ->setIgnore(true);
        $this->addElement($generarXls);
          
         // Botones del formulario.        
        $volver = new Zend_Form_Element_Submit(self::E_VOLVER);
        $volver->setLabel('Volver')
                ->setIgnore(true);
        $this->addElement($volver);
        
        $this->setCustomDecorators();
                
    }
     /* 
     * Método que permite guardar nueva resolucion.
     */
    public function guardarNuevo() {
                
        $tResolucion = new Application_Model_DbTable_Resolucion();        
        $registro = $tResolucion->createRow();
        $reunion = Application_Model_Reunion::getReunionAño($this->getValue(self::E_NUM_REUNION),$this->getValue(self::E_AÑO));        
        if($reunion){   
        // Se guarda el registro correspondiente a la resolucion.
        $registro->id = $this->getValue(self::E_NUM_RESOLUCION).$this->getValue(self::E_NUM_RESOLUCION1).$this->getValue(self::E_AÑO);
        $registro->id_gga = $this->getValue(self::E_GERENCIA);
        //$reunion = Application_Model_Reunion::getReunion($this->getValue(self::E_NUM_REUNION));
        $registro->indice_reunion = $reunion->indice;
        $registro->observacion = $this->getValue(self::E_ASUNTO);        
        $registro->fecha_real = $this->getValue(self::E_FECHA);
        //$registro->id_estado = '3';
        $registro->tipo_documento = 'RESOLUCION';
        $registro->fecha_creacion = Zend_Date::now()->toString('yyyy-MM-dd');        
        $registro->notificacion = $this->getValue(self::E_NOTIFICACION);
        $registro->save(); 
        }else{
        $this->getElement(self::E_NUM_REUNION)->addError('No existe reunion para el año '.$this->getValue(self::E_AÑO)) ;   
        }
    }
    
    /* 
     * Método que permite guardar relaciones de una resolucion.
     */
    public function guardarRelacion($resolA,$resolB) {
                
        $tRelacion = new Application_Model_DbTable_RelacionResolucion();        
        $registro = $tRelacion->createRow();
           
        // Se guarda el registro correspondiente a la resolucion.
        $registro->indice_resolucion = $resolA;
        $registro->indice_resolucionb = $resolB;
        $registro->save(); 
   }
   
   /* 
     * Método que permite guardar relaciones de una resolucion.
     */
    public function guardarAvance($indice_resolucion,$fecha,$asunto) {
                
        $tRelacion = new Application_Model_DbTable_Avance();        
        $registro = $tRelacion->createRow();
           
        // Se guarda el registro correspondiente a la resolucion.
        $registro->indice_resolucion = $indice_resolucion;
        $registro->fecha_avance = $fecha;
        $registro->descripcion = $asunto;
        $registro->save(); 
   }
   
    /* 
     * Método que permite editar resolucion.
     */   
   public function editarResolucion($indiceReunion) {
       
       $registro = Application_Model_DbTable_Resolucion::findOneById($indiceReunion);
        if (!$registro) {
            throw new Exception('No puede modificar este registro');
        }else{
        
        // Se actualiza el registro correspondiente a la resolucion.
        $registro->id = $this->getValue(self::E_NUM_RESOLUCION).$this->getValue(self::E_NUM_RESOLUCION1).$this->getValue(self::E_AÑO);
        $registro->id_gga = $this->getValue(self::E_GERENCIA);
        $registro->indice_reunion = $indiceReunion;
        $registro->observacion = $this->getValue(self::E_ASUNTO);        
        $registro->fecha_real = $this->getValue(self::E_FECHA);        
        $registro->notificacion = $this->getValue(self::E_NOTIFICACION);
        $registro->save(); 
        }
        
    }
    
     /* 
     * Método que permite modificar estatus de resolucion.
     */   
   public function modificarEstatusResolucion($estado,$indice) {
     Fmo_Logger::debug('hola'.$estado.$this->getValue(self::E_ASUNTO));
       $registro = Application_Model_DbTable_Resolucion::findOneById($indice);
        if (!$registro) {
              //Fmo_Logger::debug($registro);
            throw new Exception('No puede modificar este registro');
        }else{
            $nombre = Application_Model_Estado::getDatosEstado($estado);
            if ($nombre->descripcion == 'PROCESADA'){    
            // Se modifica el estado del resgistro correspondiente a la resolucion.
            $registro->descripcion_procesado = $this->getValue(self::E_ASUNTO);        
            $registro->id_estado = $estado;        
            $registro->fecha_procesado = $this->getValue(self::E_FECHA);
            $registro->save(); 
            }else{
            // Se modifica el estado del resgistro correspondiente a la resolucion.
            $registro->id_estado = $estado;      
            $registro->save(); 
            }
        }
        
    }
    
     public function proceso(array $data)
   {
        
        $this->setDefaults($data);
        if (($this->getValue(self::E_GUARDAR)) && ($this->isValid($data))) {
            //Fmo_Logger::debug((Application_Model_Resolucion::validarResolucion($this->getValue(self::E_NUM_RESOLUCION).$this->getValue(self::E_NUM_RESOLUCION1))));
             if(!(Application_Model_Resolucion::validarResolucion($this->getValue(self::E_NUM_RESOLUCION).$this->getValue(self::E_NUM_RESOLUCION1).$this->getValue(self::E_AÑO)))){
                if((Application_Model_Reunion::validarReunion($this->getValue(self::E_NUM_REUNION),Fmo_Util::stringToZendDate($this->getValue(self::E_FECHA))->toString('yyyy')))){
                $this->guardarNuevo(); 
                }
            }else{
            $this->getElement(self::E_AÑO)->addError('Resolucion existente para el año en curso');                    
            }
            if((Application_Model_Reunion::validarReunion($this->getValue(self::E_NUM_REUNION),Fmo_Util::stringToZendDate($this->getValue(self::E_FECHA))->toString('yyyy')))){
                if(!(Application_Model_Resolucion::validarResolucion($this->getValue(self::E_NUM_RESOLUCION).$this->getValue(self::E_NUM_RESOLUCION1).$this->getValue(self::E_AÑO)))){
                $this->guardarNuevo(); 
                }
            }else{
            $this->getElement(self::E_NUM_REUNION)->addError('No existe la reunion');                    
            }
        }
        if (($this->getValue(self::E_MODIFICAR)) && ($this->isValid($data))) {
            if((Application_Model_Reunion::validarReunion($this->getValue(self::E_NUM_REUNION),Fmo_Util::stringToZendDate($this->getValue(self::E_FECHA))->toString('yyyy')))){
                //$indiceReunion = Application_Model_Reunion::getReunionAño($this->getValue(self::E_NUM_REUNION),  Fmo_Util::stringToZendDate($this->getValue(self::E_FECHA))->toString('yyyy'));
                $this->editarResolucion($this->getIndiceResolucion());
                
                
            }else{
            $this->getElement(self::E_NUM_REUNION)->addError('No existe la reunion');                  
                
            }
        }
        
        
        
        return !$this->hasErrors();
    }
   
   public function valoresPorDefecto($id,$id1,$anio)
    {
       $consultaResolucion = Application_Model_Resolucion::getResolucion($id.$id1.$anio);
       //$fecha = $consultaResolucion->fecha_real ;
       //$reunion = Application_Model_Reunion::getReunion($consultaResolucion->id_reunion);
       //Fmo_Logger::debug($reunion);
       //Fmo_Logger::debug($reunion->id);
       
       $this->setDefault(self::E_NUM_RESOLUCION, $id)
             ->setDefault(self::E_NUM_RESOLUCION1, $id1)
             ->setDefault(self::E_GERENCIA, $consultaResolucion->id_gga)
             ->setDefault(self::E_ASUNTO, $consultaResolucion->observacion)
             ->setDefault(self::E_FECHA,Fmo_Util::stringToZendDate($consultaResolucion->fecha_real)->toString('dd/MM/yyyy'))
             ->setDefault(self::E_NOTIFICACION, $consultaResolucion->notificacion)
             ->setDefault(self::E_NUM_REUNION, $consultaResolucion->id_reu)
             ->setDefault(self::E_AÑO, $anio);
             
    }
    
    public function limpiarRequeridos(){
         
        $this->getElement(self::E_ASUNTO)->setRequired(false);        
        $this->getElement(self::E_FECHA)->setRequired(false);
        $this->getElement(self::E_NUM_RESOLUCION)->setRequired(false);  
        $this->getElement(self::E_NUM_RESOLUCION1)->setRequired(false);
        $this->getElement(self::E_AÑO)->setRequired(false); 
        $this->getElement(self::E_AÑO2)->setRequired(false);           
        $this->getElement(self::E_NUM_REUNION)->setRequired(false);
        $this->getElement(self::E_NOTIFICACION)->setRequired(false);        
        $this->getElement(self::E_GERENCIA)->setRequired(false);        
        $this->getElement(self::E_ESTADO)->setRequired(false); 
    }
    
    public function removerElementosRelaciones(){
        
        $this->removeElement(self::E_FECHA);
        $this->removeElement(self::E_ASUNTO);
        $this->removeElement(self::E_NUM_REUNION);
        $this->removeElement(self::E_NOTIFICACION);        
        $this->removeElement(self::E_ESTADO); 
    }
    
    /* 
     * Método que permite eliminar a relaciones
     */
    public function eliminarRelacion($indice) {
        
        // Se elimina el registro correspondiente de la tabla "relacion_resolucion".
        $registroRelacionResolucion = Application_Model_DbTable_RelacionResolucion::findOneById($indice);
        $registroRelacionResolucion->delete();
        
    }
    
     /* 
     * Método para guardar indice de resolucion
     */
    public function IndiceResolucion($indice) {
    $this->indiceResolucion= $indice ;   
        
    }
    
     /* 
     * Método para obtener el indice de resolucion
     */
    private function getIndiceResolucion() {
        return $this->indiceResolucion;
    }
    
   
    
    
    
}