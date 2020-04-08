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
class Application_Form_Punto extends Fmo_Form_Abstract {

    const E_GERENCIA    = 'gerencia'   ; 
    const E_ASUNTO    = 'asunto'    ;     
    const E_ULT_PUNTO = 'ultimo_punto';
    const E_TIPO_PUNTO = 'tipo';
    const E_SIGLAS  = 'siglas'    ;  
    const E_DATOS_GERENCIA = 'datos';
    const E_NUM_PUNTO1 = 'punto1'    ;
    const E_AÑO            = 'anio';      
    const E_AÑO2            = 'anio2';  
    const E_ESTADO = 'estado';
    const E_FECHA    = 'fecha_punto'    ; 
    const E_MODALIDAD    = 'modalidad'    ;
        
    const E_VOLVER = 'volver';
    const E_GUARDAR  = 'guardar' ;
    const E_MODIFICAR  = 'modificar' ;    
    const E_BUSCAR  = 'buscar' ;
    const E_CANCELAR = 'cancelar';
    const E_LIMPIAR = 'limpiar';
    private $indicePunto;
    /*
     * Método de creación del formulario.
     */
    public function init() {
        
        
       // Combobox para seleccionar la gerencia.
        $comboboxGerencia = new Zend_Form_Element_Select(self::E_GERENCIA);
        $comboboxGerencia->setLabel('Gerencias Gral./Coord:')
                ->setRequired()                
                ->setAttrib('onchange', 'form.submit();')
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_GerenciaGeneralCoordinacion::getGerenciaCombobox())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxGerencia); 
    
        // Combobox para seleccionar Estado.
        $comboboxEstatus = new Zend_Form_Element_Select(self::E_ESTADO);
        $comboboxEstatus->setLabel('Estado:')
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_Estado::getEstadoTipo('PUNTO DE CUENTA E INFORMACION'))
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxEstatus);
        
        // Combobox para seleccionar el tipo de documento del estado.
        $comboboxModalidad = new Zend_Form_Element_Select(self::E_MODALIDAD);
        $comboboxModalidad->setLabel('Modalidad:')
                ->setRequired()                
                ->setAttrib('onchange', 'form.submit();')
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_Punto::getModalidadesCombobox())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxModalidad);
        
        // Campo ultimo Punto
        $campoUltPunto = new Zend_Form_Element_Note(self::E_ULT_PUNTO);
        $campoUltPunto->setLabel('Último Punto:')
                      ->setDecorators($this->_decoratorElement);
        $this->addElement($campoUltPunto);
        
        // Campo tipo punto
        $campoTipo = new Zend_Form_Element_Note(self::E_TIPO_PUNTO);
        $campoTipo->setLabel('')
                  ->setDecorators($this->_decoratorElement);
        $this->addElement($campoTipo);
        
        
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
        
        $fecha = new Fmo_Form_Element_DatePicker(self::E_FECHA);
        $fecha->setLabel('Fecha:')
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
                //->addValidator($valDbw2);
        $this->addElement($fecha);
        $this->_decoratorElementDatePicker[0][1]['viewScript'] = 'dp.phtml';
        
               
         // Campo 1 de numero de resolucion
        $campoPunto = new Zend_Form_Element_Note(self::E_SIGLAS);
        $campoPunto->setAttrib('style', 'text-align: left; width: 20%;')                   
                   ->addFilter('StringToUpper')
                   ->setRequired();
        $this->addElement($campoPunto);
        
           // Campo 2 de numero de resolucion
        $campoPunto1 = new Zend_Form_Element_Text(self::E_NUM_PUNTO1);
        $campoPunto1->setRequired()
                    ->setLabel('Número Punto:')   
                        ->setAttrib('style', 'text-align: left; width: 12%;') 
                        ->setAttrib('maxlength', '3')
                        ->addValidator('stringLength', false, array(3, 3))
                       // ->addValidator('Int', true)
                        ->setRequired();
        $this->addElement($campoPunto1);
        
           // Campo anio actual de resolucion .
        $campoAnio = new Zend_Form_Element_Text(self::E_AÑO);
        $campoAnio->setLabel('Año:')
                  ->setAttrib('style', 'text-align: left; width: 15%;')                
                  ->addValidator('Int', true)
                ->setAttrib('maxlength', '4')
                  ->addValidator('stringLength', false, array(4, 4))
                  //->setValue(Zend_Date::now()->toString('yyyy'))        
                  ->setRequired();
        $this->addElement($campoAnio);
        
           // Campo anio actual de resolucion .
        $campoAnio2 = new Zend_Form_Element_Text(self::E_AÑO2);
        $campoAnio2->setLabel('Año:')
                  ->setAttrib('style', 'text-align: left; width: 15%;')                
                  ->addValidator('Int', true)
                  ->addValidator('stringLength', false, array(4, 4))
                  ->setValue(Zend_Date::now()->toString('yyyy'));
        $this->addElement($campoAnio2);
                        
        // Botones del formulario.
        $guardar = new Zend_Form_Element_Submit(self::E_GUARDAR);
        $guardar->setLabel('Guardar')
                ->setIgnore(true);
        $this->addElement($guardar);
        
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
        $buscar = new Zend_Form_Element_Submit(self::E_BUSCAR);
        $buscar->setLabel('Buscar')                
                ->setAttrib('onchange', 'form.submit();')
                ->setIgnore(true);
        $this->addElement($buscar);
        
        // Botones del formulario.
        $limpiar = new Zend_Form_Element_Submit(self::E_LIMPIAR);
        $limpiar->setLabel('Limpiar')                
                ->setAttrib('onchange', 'form.submit();')
                ->setIgnore(true);
        $this->addElement($limpiar);
        
         // Botones del formulario.        
        $volver = new Zend_Form_Element_Submit(self::E_VOLVER);
        $volver->setLabel('Volver')
                ->setIgnore(true);
        $this->addElement($volver);
        
        $this->setCustomDecorators();
                
    }
     /* 
     * Método que permite guardar nuevo punto.
     */
    public function guardarNuevo() {
                
        $tPunto = new Application_Model_DbTable_Punto();        
        $registro = $tPunto->createRow();
      
        $registro->id = $this->getValue(self::E_NUM_PUNTO1);
        $registro->siglas = $this->getValue(self::E_SIGLAS);
        $registro->id_gga = $this->getValue(self::E_GERENCIA);
        $registro->id_modalidad = $this->getValue(self::E_MODALIDAD); 
        //$registro->id_estado = '2';
        $registro->fecha_creacion = Zend_Date::now()->toString('yyyy-MM-dd'); 
        $registro->observacion = $this->getValue(self::E_ASUNTO);
        $registro->fecha_real = $this->getValue(self::E_FECHA);
        $registro->tipo_documento = 'PUNTO DE CUENTA E INFORMACION';              
        $registro->save(); 
   }
   
   /* 
     * Método que permite editar punto.
     */   
   public function editarPunto() {
     
        $registro = Application_Model_DbTable_Punto::findOneById($this->getIndicePunto());
        
        if (!$registro) {
            throw new Exception('No puede modificar este registro');
        }else{
        
        $registro->id = $this->getValue(self::E_NUM_PUNTO1);            
        $registro->siglas = $this->getValue(self::E_SIGLAS);
        $registro->id_gga = $this->getValue(self::E_GERENCIA);
        $registro->id_modalidad = $this->getValue(self::E_MODALIDAD);         
        $registro->id_gga = $this->getValue(self::E_GERENCIA); 
        $registro->observacion = $this->getValue(self::E_ASUNTO);          
        $registro->save(); 
        }
        
    }
    
    public function setAjax(array $defaults)
    {
        
        $ord = new ZendX_JQuery_Form_Element_AutoComplete(self::E_DATOS_GERENCIA);
        $ord->setAttrib('style', 'text-align: left; width: 20%;')                
                   ->addFilter('StringToUpper')
                   ->setRequired()
                ->setAttrib('maxlength', '16')
                //->addValidator('StringLength', false, array('min' => 1, 'max' => 10, 'encoding' => $this->getView()->getEncoding()))
                ->setJQueryParam('source', $this->getView()->url(array('module' => 'default', 'controller' => 'ajax', 'action' => 'gerencia'), null, false))
                ->setJQueryParam('minLength', 1)
                ->setJQueryParam('autoFocus', true)
                ->setJQueryParam('change', new Zend_Json_Expr('function(event, ui) { document.getElementById(\'' . self::E_SIGLAS . '\').value = ui.item.value; this.value = ui.item.Label; }'))
                ->setDecorators($this->_decoratorElementJQuery);
        $this->addElement($ord);
        $this->getElement(self::E_SIGLAS)->setRequired(false);
    
        return $this; 
    }
    
    public function proceso(array $data)
   {
        
        $valid = false;
        $this->setDefaults($data);         
        
        if (($this->getValue(self::E_GUARDAR))&& $this->isValid($data)) {
            if ( $this->getValue(self::E_NUM_PUNTO1) && $this->getValue(self::E_NUM_PUNTO1) && $this->getValue(self::E_AÑO)){
                if(! Application_Model_Punto::validarPunto($this->getValue(self::E_NUM_PUNTO1),$this->getValue(self::E_MODALIDAD),$this->getValue(self::E_AÑO))){
                $this->guardarNuevo();
                $punto = $this->getValue(self::E_TIPO_PUNTO);
                $this->getMessageProcess()->add('Se agregó el nuevo '.$punto);   
                $valid = true;
                }else{
            $this->getElement(self::E_AÑO)->addError('Ya existe el punto para el año '.$this->getValue(self::E_AÑO));     
            //                
            }
            }else{
            $this->getElement(self::E_AÑO)->addError('Ingrese todos los campos');    
            }
                
        }
        if (($this->getValue(self::E_MODIFICAR)) && ($this->isValid($data))) {            
            $punto = $this->getValue(self::E_TIPO_PUNTO);
            $this->getMessageProcess()->add('Se modifico el '.$punto);   
            $this->editarPunto();
            $valid = true;
        }
        
         return $valid;
       
   }
   
   public function valoresPorDefecto($ult,$tipo){
       
       $this->setDefault(self::E_ULT_PUNTO, $ult) 
             ->setDefault(self::E_TIPO_PUNTO, $tipo);
   }
   
   public function siglaPorDefecto($siglas){
       
       $this->setDefault(self::E_SIGLAS, $siglas) ;
   }
    
   
   public function valoresDefecto($indice){
       $registro = Application_Model_Punto::getPuntoIndice($indice);
       if($registro){
           
       $this->setDefault(self::E_GERENCIA, $registro->id_gga) 
            ->setDefault(self::E_MODALIDAD, $registro->id_modalidad)
            ->setDefault(self::E_NUM_PUNTO1, $registro->id)
            ->setDefault(self::E_AÑO,$registro->anio )
            ->setDefault(self::E_ASUNTO, $registro->observacion)
            ->setDefault(self::E_FECHA, Fmo_Util::stringToZendDate($registro->fecha_real)->toString('dd-MM-yyyy'));    
      
                
       
       }
    }
   
     /* 
     * Método que permite modificar estatus de resolucion.
     */   
   public function modificarEstatusPunto($estado,$asunto,$indice,$fecha_procesado) {
   
       $registro = Application_Model_DbTable_Punto::findOneById($indice);
        if (!$registro) {
              //Fmo_Logger::debug($registro);
            throw new Exception('No puede modificar este registro');
        }else{
            if ($estado == 'PROCESADA'){    
            // Se el estado del resgistro correspondiente a la resolucion.
            $registro->descripcion_procesado = $asunto;        
            $registro->id_estado = $this->getValue(self::E_ESTADO);        
            $registro->fecha_procesado = $fecha_procesado;
            $registro->save(); 
            }else{
            // Se el estado del resgistro correspondiente a la resolucion.
            $registro->id_estado = $this->getValue(self::E_ESTADO); ;      
            $registro->save(); 
            }
        }
        
    }
    
    public function indicePunto($indice){
        $this->indicePunto = $indice ;            
    }
    
    private function getIndicePunto(){
        return $this->indicePunto ;
    }
   
    public function limpiarRequeridos(){
        $this->getElement(self::E_ASUNTO)->setRequired(false);        
        $this->getElement(self::E_SIGLAS)->setRequired(false);
        $this->getElement(self::E_GERENCIA)->setRequired(false);
        $this->getElement(self::E_FECHA)->setRequired(false);
    }
    
    public function limpiarRequeridosConsulta(){
        $this->getElement(self::E_ASUNTO)->setRequired(false);               
        $this->getElement(self::E_MODALIDAD)->setRequired(false);
        $this->getElement(self::E_GERENCIA)->setRequired(false) ;        
        $this->getElement(self::E_SIGLAS)->setRequired(false) ;
        $this->getElement(self::E_NUM_PUNTO1)->setRequired(false) ;                    
        $this->getElement(self::E_AÑO)->setRequired(false);
        $this->getElement(self::E_AÑO2)->setRequired(false);
        $this->getElement(self::E_FECHA)->setRequired(false);
        
        
    }
    
    
}