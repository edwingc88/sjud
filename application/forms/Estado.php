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
class Application_Form_Estado extends Fmo_Form_Abstract {

    const E_NOMBRE   = 'descripcion'  ;
    const E_COLOR    = 'color'   ; 
    const E_TIPO     = 'tipo'    ; 
    
    const E_EDITAR  = 'editar' ;
    const E_GUARDAR  = 'guardar' ;
    const E_MODIFICAR  = 'modificar' ;
    const E_CANCELAR = 'cancelar';

    /*
     * Método de creación del formulario.
     */
    public function init() {
        
           $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
        
        $tEstatus = new Application_Model_DbTable_Estado();
         
           // Campo para ingresar el nombre del estado.
        $campoNombre = new Zend_Form_Element_Text(self::E_NOMBRE);
        $campoNombre->setLabel('Nombre Estado:')
                    ->setRequired()   
                    //->addValidator('alpha',' ',true)
                    ->addFilter('StringTrim')
                    ->addFilter('StringToUpper')  
                    
                    ->addValidator('StringLength', false, array('min' => 1, 'max' => 20))
                    //->addValidator('Db_NoRecordExists', false, array('table' => $tEstatus->info(Zend_Db_Table::NAME),
                    //'schema' => $tEstatus->info(Zend_Db_Table::SCHEMA),
                    //'field' => 'descripcion'))   
                    ->setDecorators($this->_decoratorElement);
        $this->addElement($campoNombre);
        
        // Combobox para seleccionar el color del estado.
        $comboboxColor = new Zend_Form_Element_Select(self::E_COLOR);
        $comboboxColor->setLabel('Color:')
                ->setRequired()
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_Estado::getAllColor())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxColor);
        
         // Combobox para seleccionar el tipo de documento del estado.
        $comboboxTipo = new Zend_Form_Element_Select(self::E_TIPO);
        $comboboxTipo->setLabel('Tipo:')
                ->setRequired()
                ->addMultiOption('', 'Seleccione')
                ->addMultiOption('RESOLUCION', 'RESOLUCION')
                ->addMultiOption('PUNTO DE CUENTA E INFORMACION', 'PUNTO DE CUENTA E INFORMACION')
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxTipo);
        
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
        
        $this->setCustomDecorators();        
    }
    /* 
    * Método que permite guardar un nuevo estado.
    */
    public function guardarNuevo() {
                
        $tEstado = new Application_Model_DbTable_Estado();        
        $registro = $tEstado->createRow();
               
        $registro->descripcion = $this->getValue(self::E_NOMBRE);
        $registro->id_color = $this->getValue(self::E_COLOR);
        $registro->tipo_documento = $this->getValue(self::E_TIPO);              
        $registro->save(); 
        
        
   }
   
    /* 
    * Método que permite editar un estado.
    */   
   public function editarEstado($idEstado) {
    
        
        $registro = Application_Model_DbTable_Estado::findOneById($idEstado);
        
        if (!$registro) {
            throw new Exception('No puede modificar este registro');
        }else{
        
        // Se actualiza el registro correspondiente al estado.
        $registro->descripcion = $this->getValue(self::E_NOMBRE);
        $registro->id_color = $this->getValue(self::E_COLOR);
        $registro->tipo_documento = $this->getValue(self::E_TIPO);
        $registro->save(); 
        
        }
        
    }    
    
    public function proceso(array $data)
            
    {       $this->setDefaults($data);  
    
            if (($this->getValue(self::E_GUARDAR)) && ($this->isValid($data))) {
                //Fmo_Logger::debug($this->getValue(self::E_NOMBRE));
                $filter = new Zend_Filter_StringToUpper();
                $estado = $filter->filter($this->getValue(self::E_NOMBRE));
                
                if(!Application_Model_Estado::validarEstado($estado, $this->getValue(self::E_TIPO))){
                    $this->guardarNuevo();
                    
                }else{
                $this->getElement(self::E_NOMBRE)->addError('Existe el estado en ese documento');    
                }
            }
       return !$this->hasErrors();
       
   }
   
    public function valoresPorDefecto($id,$tipo)
    {
        $nombre = Application_Model_Estado::getAllEstadoColoresId($id);
        $this->setDefault(self::E_NOMBRE, $nombre->descripcion)                
             ->setDefault(self::E_COLOR, $nombre->color_id)
             ->setDefault(self::E_TIPO,$tipo);
    }
    
    
}