<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tipo Reunion
 *
 * @author manuelry
 */
class Application_Form_TipoReunion extends Fmo_Form_Abstract {

    const E_NOMBRE   = 'descripcion'  ;
    
    const E_EDITAR  = 'editar' ;
    const E_GUARDAR  = 'guardar' ;
    const E_MODIFICAR  = 'modificar' ;
    const E_CANCELAR = 'cancelar';

    /*
     * Método de creación del formulario.
     */
    public function init() {
        
        $tEstatus = new Application_Model_DbTable_Estado();
              $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
           // Campo para ingresar el nombre del tipo de reunion.
        $campoNombre = new Zend_Form_Element_Text(self::E_NOMBRE);
        $campoNombre->setLabel('Nombre Tipo:')
                    ->setRequired()   
                    //->addValidator('alpha',' ',true)
                    ->addFilter('StringTrim')
                    ->addFilter('StringToUpper')             
                    ->addValidator('StringLength', false, array('min' => 1, 'max' => 50))
                    //->addValidator('Db_NoRecordExists', false, array('table' => $tEstatus->info(Zend_Db_Table::NAME),
                    //'schema' => $tEstatus->info(Zend_Db_Table::SCHEMA),
                    //'field' => 'descripcion'))   
                    ->setDecorators($this->_decoratorElement);
        $this->addElement($campoNombre);
        
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
    * Método que permite guardar un nuevo Tipo de reunion.
    */
    public function guardarNuevo() {
                
        $tTipo = new Application_Model_DbTable_TipoReunion();        
        $registro = $tTipo->createRow();
               
        $registro->descripcion = $this->getValue(self::E_NOMBRE);              
        $registro->save(); 
        
   }
   
    /* 
    * Método que permite editar un Tipo de reunion.
    */   
   public function editarTipoReunion($idTipo) {
    
        
        $registro = Application_Model_DbTable_TipoReunion::findOneById($idTipo);
        
        if (!$registro) {
            throw new Exception('No puede modificar este registro');
        }else{
        
        // Se actualiza el registro correspondiente al estado.
        $registro->descripcion = $this->getValue(self::E_NOMBRE);
        $registro->save(); 
        
        }
        
    }    
    
    /*
     * Metodo que procesa el guardar de un tipo de reunion
     * 
     */
    public function proceso(array $data)
            
    {       
        $this->setDefaults($data);
            if (($this->getValue(self::E_GUARDAR)) && ($this->isValid($data))) {
                //Fmo_Logger::debug($this->getValue(self::E_NOMBRE));
                $filter = new Zend_Filter_StringToUpper();
                $tipo = $filter->filter($this->getValue(self::E_NOMBRE));
                
                if(!Application_Model_Reunion::validarTipoReunion($tipo)){
                    $this->guardarNuevo();
                    
                }else{
                $this->getElement(self::E_NOMBRE)->addError('Ya existe este tipo de reunion');    
                }
            }
       return !$this->hasErrors();
       
   }
   /*
    * Metodo para Valores por defecto a la hora de editar
    */
   
    public function valoresPorDefecto($id)
    {
        $tipo_reunion = Application_Model_Reunion::getTipoReunion($id);
        $this->setDefault(self::E_NOMBRE, $tipo_reunion->descripcion);
    }
    
    
}