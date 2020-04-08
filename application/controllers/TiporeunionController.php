<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TipoReunionController
 *
 * @author manuelry
 */
    class TipoReunionController extends Fmo_Controller_Action_Abstract 
{
    /*
     * Ruta por defecto.
     * 
     */
   private $urlDefault = 'default/Tiporeunion/nuevo';

    /**
     * Petición Http
     * 
     * @var Zend_Controller_Request_Http
     */
    private $request;
    //private $page;

    /**
     * Inicialización del controlador
     */
    public function init() {
        parent::init();
        $this->request = $this->getRequest();         
    
        
    }
    
    /* 
    * Accion ejecutada para crear un nuevo tipo reunion.
    */    
    public function nuevoAction() {
        
      ;
        
        if ($this->getParam(Application_Form_TipoReunion::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }else{
            try {
                $form = new Application_Form_TipoReunion();
                $data = $this->paginator(Application_Model_Reunion::getAllTiposReunion(),10);
            
                if ($this->request->isPost() ){                
                    if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                    $this->addMessageSuccessful('Se guardo exitosamente el tipo de reunion');
                    $this->redirect($this->urlDefault);      
                    }else{
                    $this->view->nombreView = $this->getParam(Application_Form_Estado::E_NOMBRE);
                              
                    }
                } else {
                    $form->setDefaults($this->getAllParams());
                }
            } catch (Exception $ex) {
                $data = null;
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault);
            }
        }
        
        $this->view->form = $form;
         $this->view->data = $data; 
     
        
    }
    
    /* 
    * Aciion ejecutada para editar un tipo de reunion.
    */    
    public function editarAction() {
        
    $idTipo = $this->getParam('id_tipo'); 
    if ($this->getParam(Application_Form_TipoReunion::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }
         try {
            $form = new Application_Form_TipoReunion();
            $form->valoresPorDefecto($idTipo);
            if ($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();
                $form->setDefaults($post);
                if(isset($post[Application_Form_Tiporeunion::E_MODIFICAR]) && $form->isValid($post)){
                    
                $filter = new Zend_Filter_StringToUpper();
                $nombreEstado = $filter->filter($this->getParam(Application_Form_TipoReunion::E_NOMBRE));
                
                    if(Application_Model_Reunion::validarTipoReunion($nombreEstado)){
                        $this->addMessageError('El nombre del tipo ya existe.');   
                    }else{
                        $form->editarTipoReunion($idTipo);
                        $this->addMessageSuccessful('Se guardo exitosamente el registro');
                        $this->redirect($this->urlDefault);   
                        }    
                }
            }
        } catch (Exception $ex) {
            $this->addMessageException($ex);
            $this->redirect($this->urlDefault);
        }
        
        $this->view->form = $form;
        
   }
    
    
            
       
    
    
}
