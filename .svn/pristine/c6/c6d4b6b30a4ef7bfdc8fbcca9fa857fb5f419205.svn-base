<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CargoController
 *
 * @author manuelry
 */
class CargoController extends Fmo_Controller_Action_Abstract 
{
    /*
     * Ruta por defecto.
     * 
     */

   private $urlDefault = 'default/cargo/nuevo';

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
     * Accion ejecutada para crear un nuevo cargo
     */    
    public function nuevoAction() {
                   
        if ($this->getParam(Application_Form_Cargo::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }
        try {
            $form = new Application_Form_Cargo();
            $data = $this->paginator(Application_Model_Cargo::getAllCargosLista(),10);

            if ($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();
                $form->setDefaults($post);
                $nivel = $this->getParam(Application_Form_Cargo::E_NIVEL);
                $filter = new Zend_Filter_StringToUpper();
                $cargo = $filter->filter($this->getParam(Application_Form_Cargo::E_NOMBRE));
                
                if(Application_Model_Cargo::validarCargo(trim($cargo))){
                    $this->view->nombreView = $this->getParam(Application_Form_Cargo::E_NOMBRE);
                    $this->view->nivelView = $this->getParam(Application_Form_Cargo::E_NIVEL);
                        $this->addMessageWarning('El nombre del cargo ya existe.');   
                        }else {
                                if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                                $this->addMessageSuccessful('Se guardo exitosamente el registro');
                                $this->redirect($this->urlDefault); 
                                }else{
                                $this->view->nombreView = $this->getParam(Application_Form_Cargo::E_NOMBRE);
                                $this->view->nivelView = $this->getParam(Application_Form_Cargo::E_NIVEL);
                                }
                            }   
            }
        } catch (Exception $ex) {
            $data = null;
            $this->addMessageException($ex);
            $this->redirect($this->urlDefault);
        }
        
        $this->view->data = $data;
        $this->view->form = $form;
    }
    
     /*
     * Accion ejecutada para editar cargo
     */   
    public function editarAction() {
    $idCargo = $this->getParam('id_cargo');
    $consultaCargo = Application_Model_Cargo::getDatoCargo($idCargo);
    $nombre = $consultaCargo->descripcion;
    $nivel = $consultaCargo->nivel_cargo;
    
    if ($this->getParam(Application_Form_Cargo::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }
         try {
            $form = new Application_Form_Cargo();
            $form->valoresPorDefecto($nombre,$nivel);
            if ($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();                
                 if(isset($post[Application_Form_Cargo::E_MODIFICAR]) && $form->isValid($post)){
                     $filter = new Zend_Filter_StringToUpper();
                     $cargo = $filter->filter($this->getParam(Application_Form_Cargo::E_NOMBRE));
                     $nivelCargo = $this->getParam(Application_Form_Cargo::E_NIVEL);                
                        if(($cargo != $nombre)){                            
                            if(Application_Model_Cargo::validarCargo(trim($cargo))){
                            $this->addMessageWarning('El nombre del cargo ya existe.');   
                            }else{       
                            $form->editarCargo($idCargo);
                            $this->addMessageSuccessful('Se modifico exitosamente el registro');
                            $this->redirect($this->urlDefault);
                            }                       
                       }
                        if(($nivelCargo != $nivel)&& ($cargo == $nombre)){
                            $form->editarCargo($idCargo);
                            $this->addMessageSuccessful('Se modifico exitosamente el registro');
                            $this->redirect($this->urlDefault);

                        }
                        if(($nivelCargo == $nivel)&& ($cargo == $nombre)){
                            $this->addMessageWarning('Modifica alguno de los datos del cargo para modificar');
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
