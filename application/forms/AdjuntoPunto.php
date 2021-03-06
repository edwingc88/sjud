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
class Application_Form_AdjuntoPunto extends Fmo_Form_Abstract {

    
    const E_VOLVER = 'volver';    
    const E_AGREGAR = 'agregar';
    const E_BROWSE = 'cargar';    
    const E_CANCELAR = 'cancelar';
    private $nombreArchivo;
    
    /*
     * Método de creación del formulario.
     */
    public function init() {
            $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));      
         $this->setName('adjuntar')
                ->setEnctype(Zend_Form::ENCTYPE_MULTIPART)
                ->setAction($this->getView()->url())
                ->setLegend('Adjuntar');
         
        
        // Botones del formulario.
        $volver = new Zend_Form_Element_Submit(self::E_VOLVER);
        $volver->setLabel('Volver')
                ->setIgnore(true);
        $this->addElement($volver);
        
        // Botones del formulario.
        $cancelar = new Zend_Form_Element_Submit(self::E_CANCELAR);
        $cancelar->setLabel('Cancelar')
                ->setIgnore(true);
        $this->addElement($cancelar);
        
        // Botones del formulario.
        $agregar = new Zend_Form_Element_Submit(self::E_AGREGAR);
        $agregar->setLabel('Agregar')
                ->setIgnore(true);
        $this->addElement($agregar);
        
          // Botones del formulario.
        $browse =  new Zend_Form_Element_File(self::E_BROWSE);
        $browse->setDescription('Browse')
                ->addValidator('Extension', false, 'pdf')
               ->setIgnore(true);
        $this->addElement($browse);
        
        $this->setCustomDecorators();
                
    }
  
    public function getNombreArchivo()
    {
        return $this->nombreArchivo;
    }

    public function setNombreArchivo($nombre)
    {
        $this->nombreArchivo = $nombre;
    }

    private function borrarArchivo()
    {
        unlink($this->getNombreArchivo());
        $this->setNombreArchivo(NULL);
    }

    public function subirArchivo($indice)
    {
       //new Zend_Form_Element_File();
        $eleFile = $this->getElement(self::E_BROWSE);  
        $rutaFinal = $eleFile->getDestination() . DIRECTORY_SEPARATOR . uniqid('sjudPunto');               
        $eleFile->addFilter('File_Rename', array( 'target' => $rutaFinal));
        
        if ($eleFile->receive()) {
            //$eleFile->addError($eleFile->getFileName());
            $tArchivo = new Application_Model_DbTable_AdjuntoPunto();
            $tArchivo->createRow(array('indice_punto' => $indice, 'nombre' => str_replace(array(' ','/'),'_',$this->getNombreArchivo()), 'ruta' => $rutaFinal))
                     ->save();
            $this->getMessageProcess()->add("Se agrego el archivo '{$this->getNombreArchivo()}'");
            //}            
        } else {
            $this->getElement(self::E_BROWSE)->addError('Fallo al adjuntar el archivo');
        }
        return !$this->hasErrors();
    }


}
