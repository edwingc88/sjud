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
class Application_Form_Reunion extends Fmo_Form_Abstract {

    const E_FECHA  = 'fecha';    
    const E_ESTADO_NUEVO = 'nuevo';
    const E_REUNION = 'reunion';
    const E_ESTADO_ACTUAL = 'actual';
    
    
    const E_MODIFICAR = 'modificar';
    const E_GUARDAR = 'guardar';
    const E_CANCELAR = 'cancelar';
    
    /*
     * Método de creación del formulario.
     */
    public function init() {
        
        
        $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
         $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
        // Campo Estado por defecto depende del dia
        $campoEstado = new Zend_Form_Element_Note(self::E_ESTADO_ACTUAL);
        $campoEstado->setLabel('Tipo Reunión:');
        $this->addElement($campoEstado);
                  
        
          // Campo fecha del periodo de junta directiva  
        $fecha = new Fmo_Form_Element_Note(self::E_FECHA);
        $fecha->setLabel('Fecha Seleccionada:')
                ->setDecorators($this->_decoratorElement);
              /*->setDescription('Formato de Fecha: DD/MM/AAAA')
              ->setRequired();*/
        $this->addElement($fecha); /*
        $this->_decoratorElementDatePicker[0][1]['viewScript'] = 'dp.phtml';*/
        
          // Campo de texto para ingresar numero de reunion
        $campoNombre = new Zend_Form_Element_Text(self::E_REUNION);
        $campoNombre->setLabel('Numero Reunión:')
                ->setRequired();
               //->addMultiOptions(Application_Model_Lugar::getUbicacionesGeograficas())
        $this->addElement($campoNombre);
        
         // Combobox para seleccionar el nuevo estado
        $comboboxEstado = new Zend_Form_Element_Select(self::E_ESTADO_NUEVO);
        $comboboxEstado->setLabel('Nuevo Tipo Reunion:')
                ->setRequired()
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_Reunion::getAllTiposReunionCombo())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxEstado);
             
        // Botones del formulario.
        $modificar = new Zend_Form_Element_Submit(self::E_MODIFICAR);
        $modificar->setLabel('Modificar')
                ->setIgnore(true);
        $this->addElement($modificar);
        
        // Botones del formulario.
        $guardar = new Zend_Form_Element_Submit(self::E_GUARDAR);
        $guardar->setLabel('Guardar')
                ->setIgnore(true);
        $this->addElement($guardar);
        
        $cancelar = new Zend_Form_Element_Submit(self::E_CANCELAR);
        $cancelar->setLabel('Cancelar')
                ->setIgnore(true);
        $this->addElement($cancelar);    
        
        $this->setCustomDecorators();
    }
     /* 
     * Método que permite guardar una reunion
     */
    public function guardarNuevo($fecha) {
                
        $tMiembro = new Application_Model_DbTable_Reunion();  
        $registro = $tMiembro->createRow();
        
        $registro->id_tipo_reunion = $this->getValue(self::E_ESTADO_NUEVO);
        $registro->fecha_real = $fecha;
        $registro->fecha_creacion = Zend_Date::now()->toString('yyyy-MM-dd');     
        $registro->id = $this->getValue(self::E_REUNION);       
        $registro->save(); 
        
   }
   
    /* 
     * Método que permite editar una reunion
    */   
   public function editarReunion($id) {
        $registro = Application_Model_DbTable_Reunion::findOneById($id);
        
        if (!$registro) {
            throw new Exception('No puede modificar este registro');
        }else{
        
        // Se actualiza el registro correspondiente al cargo.
        $registro->fecha_real = $this->getValue(self::E_FECHA);
        $registro->id_tipo_reunion = $this->getValue(self::E_ESTADO_NUEVO);
        $registro->save();     
       
        
    }
   }
   
   public function proceso(array $data,$fecha)
   {
        $this->setDefaults($data);
        
        
        if (($this->isValid($data)) && $this->getValue(self::E_GUARDAR)) {
            if(!(Application_Model_Reunion::validarReunion($this->getValue(self::E_REUNION),Fmo_Util::stringToZendDate($fecha)->toString('yyyy')))){
                Fmo_Logger::debug('entro');
                $this->guardarNuevo($fecha);  
            $this->getMessageProcess()->add('Se Agrego la reunion');   
            }else{
            $this->getElement(self::E_REUNION)->addError('Numero de Reunion Existente');
            }
        }
        return !$this->hasErrors();
       
   }
   
   public function valoresPorDefecto($anio, $mes,$dia,$tipo){
       
       $this->setDefault(self::E_FECHA,$dia.'/'.$mes.'/'.$anio)
            ->setDefault(self::E_ESTADO_ACTUAL, $tipo);
       
       
   }
    public function valoresPorDetalle($tipo,$id){
       
       $reunion = Application_Model_Reunion::getReunionIndice($id);
       $fecha_f = new Zend_Date($reunion->fecha_real);
       $formato =  $fecha_f->toString('dd/MM/yyyy');
       
       $this->setDefault(self::E_FECHA,$formato)
            ->setDefault(self::E_ESTADO_ACTUAL, $reunion->tipo_nombre)
            ->setDefault(self::E_REUNION, $reunion->id);
       
       
   }
   
}
