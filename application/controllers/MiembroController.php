<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MiembroController
 *
 * @author manuelry
 */
class MiembroController extends Fmo_Controller_Action_Abstract 
{
    /*
     * Ruta por defecto.
     * 
     */
    private $urlDefault = 'default/Miembro/nuevo';    
    private $urlDefault1 = 'default/Miembro/actuales';
    private $urlDefault2 = 'default/Miembro/listado';

  
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
//descomente aqui        
        $this->view->page = $this->getParam('page');
        $this->urlDefault = "{$this->request->getModuleName()}/{$this->request->getControllerName()}/listado/page/{$this->view->page}"; //hasta aqui
    
        }
    
    /*
     * Accion ejecutada para crear nueva junta directiva
     */
    public function nuevoAction() {        
        $form = new Application_Form_Miembro();
        $form->removeElement(Application_Form_Miembro::E_MODIFICAR);
        $form->setLegend('Registro Miembros Junta Directiva');  
        //$cargo = $this->getParam(Application_Form_Miembro::E_CARGO); 
        //$fecha = $this->getParam(Application_Form_Miembro::E_FECHA); 
        if ($this->getParam(Application_Form_Miembro::E_CANCELAR)) {
            $this->redirect($this->urlDefault1);
        }else{
            try {
               if ($this->request->isPost()) {
                 if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                        $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                        $fecha_junta = str_replace("/", "_", $this->getParam(Application_Form_Miembro::E_FECHA));
                        $this->redirect("default/Miembro/agregarmiembro/fecha_junta/{$fecha_junta}");

                        }else{

                        $this->view->idCargoView = $this->getParam(Application_Form_Miembro::E_CARGO);
                        $this->view->idFichaView = $this->getParam(Application_Form_Miembro::E_FICHA);
                        $this->view->fechaView =  $this->getParam(Application_Form_Miembro::E_FECHA); 
                        $trabajador = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Miembro::E_FICHA));
                        
                        if(!empty($trabajador)){
                            $form->setDefault(Application_Form_Miembro::E_NOMBRE, $trabajador->{Fmo_Model_Personal::NOMBRE} . $trabajador->{Fmo_Model_Personal::APELLIDO});
                            $form->setDefault(Application_Form_Miembro::E_CEDULA, $trabajador->{Fmo_Model_Personal::CEDULA});
                            }       
                    }
                }
            } catch (Exception $ex) {
                Fmo_Logger::debug($ex);
                if ($ex->getCode() == 23505) {                    
                    $this->view->idCargoView = $this->getParam(Application_Form_Miembro::E_CARGO);
                    $this->view->idFichaView = $this->getParam(Application_Form_Miembro::E_FICHA);
                    $this->view->fechaView =  $this->getParam(Application_Form_Miembro::E_FECHA);  
                    
                    $trabajador = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Miembro::E_FICHA));
                            if(!empty($trabajador)){
                            $form->setDefault(Application_Form_Miembro::E_NOMBRE, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                            $form->setDefault(Application_Form_Miembro::E_CEDULA, "{$trabajador->{Fmo_Model_Personal::CEDULA}}");
                            }$this->addMessageError('Ya existe el usuario con un cargo en el período de la junta directiva');    
                   } else {
                       $this->addMessageError($ex->getMessage());
                   }
            }
        }
        $this->view->form = $form; 
        
    }
  
    /*
     * Accion ejecutada para agregar miembros de junta directiva
     */
    public function agregarmiembroAction() {        
        $form = new Application_Form_Miembro();
        $fecha_junta = $this->getParam('fecha_junta');        
        Fmo_Logger::debug($fecha_junta);
        $fecha_nueva = Fmo_Util::stringToZendDate($fecha_junta)->toString('dd/MM/yyyy');
        
        $form->removeElement(Application_Form_Miembro::E_MODIFICAR);
        $form->removeElement(Application_Form_Miembro::E_CEDULA_MIEMBRO);
        $form->setDefault(Application_Form_Miembro::E_FECHA, $fecha_nueva);
        $form->getElement(Application_Form_Miembro::E_FECHA)->setRequired(false);
        
        $form->setLegend('Agregar Miembros Junta Directiva');  
        $this->view->fechaJuntaView = $fecha_nueva;
        
        if ($this->getParam(Application_Form_Miembro::E_CANCELAR)) {
            $this->redirect($this->urlDefault1);
        }else{
            try {
               if ($this->request->isPost()) {
                 if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                        $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                        $this->redirect("default/Miembro/agregarmiembro/fecha_junta/{$fecha_junta}");

                        }else{

                        $this->view->idCargoView = $this->getParam(Application_Form_Miembro::E_CARGO);
                        $this->view->idFichaView = $this->getParam(Application_Form_Miembro::E_FICHA);
                        $form->setDefault(Application_Form_Miembro::E_FECHA, $fecha_nueva);
                        $this->view->fechaView =  $fecha_nueva; 
                        $trabajador = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Miembro::E_FICHA));
                            if(!empty($trabajador)){
                            $form->setDefault(Application_Form_Miembro::E_NOMBRE, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                            $form->setDefault(Application_Form_Miembro::E_CEDULA, "{$trabajador->{Fmo_Model_Personal::CEDULA}}");
                            }       
                    }
                }
            } catch (Exception $ex) {
                Fmo_Logger::debug($ex);
                if ($ex->getCode() == 23505) {                    
                    $this->view->idCargoView = $this->getParam(Application_Form_Miembro::E_CARGO);
                    $this->view->idFichaView = $this->getParam(Application_Form_Miembro::E_FICHA);
                    $form->setDefault(Application_Form_Miembro::E_FECHA, $fecha_nueva);
                    $trabajador = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Miembro::E_FICHA));
                            if(!empty($trabajador)){
                            $form->setDefault(Application_Form_Miembro::E_NOMBRE, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                            $form->setDefault(Application_Form_Miembro::E_CEDULA, "{$trabajador->{Fmo_Model_Personal::CEDULA}}");
                            }
                    $this->addMessageError('Ya existe el usuario con un cargo en el período de la junta directiva');    
                    }
                       
            }
        }
        $this->view->form = $form; 
        
    }
  
    
    
    /*
     * Accion ejecutada para listar los miembros actuales de la junta directiva
     */
    public function actualesAction() {
        $form = new Application_Form_Miembro();
        $this->view->form = $form; 
               
    }
    
    /*
     * Accion ejecutada para listar los miembros anteriores de la junta directiva
     */
    public function listadoAction() {
        try {
            $form = new Application_Form_Miembro();
            
            $data = $this->paginator(Application_Model_Miembros::getMiembrosAnterioresConActual(),30);
            
        } catch (Exception $ex) {
            $data = null;
            $this->addMessageException($ex);
            //$this->redirect($this->urlDefault2);
        }
        
        $this->view->data = $data;
        $this->view->form = $form;       
        
    }
    
    /*
     * Accion ejecutada para modificar algun miembro de la junta directiva
     */
    public function editarAction() {
                           
       $form = new Application_Form_Miembro(); 
       $this->view->form = $form;            
       $form->setLegend('Modificar miembro');
       $form->getElement(Application_Form_Miembro::E_FECHA)->setLabel('Fecha-Inicio-Miembro');
            
        if ($this->getParam(Application_Form_Miembro::E_CANCELAR)) {
            $this->redirect($this->urlDefault1);
        }else{
            try {        
            $fecha = $this->getParam('fecha'); 
            $formato = new Zend_Date($fecha);
            $ficha = $this->getParam('ficha');
            $fecha_f =  $formato->toString('dd-MM-yyyy');
            $datos = Application_Model_Miembros::getMiembro($ficha, $fecha);
            $form->valoresPorDefecto($ficha, $datos->cedula, $datos->nombre, $datos->id_cargo,$fecha_f);
            $form->setDefault(Application_Form_Miembro::E_FECHA_JUNTA, $fecha);           
            $form->getElement(Application_Form_Miembro::E_CARGO)->setRequired(false);
            
            if ($this->request->isPost() ){                
              // Zend_Debug::dd($datos);
            
                    if (($form->proceso($this->request->getPost()))) {
                        $this->addMessageSuccessful('Se modifico exitosamente el registro');
                        $this->redirect($this->urlDefault1);
                    }else{
                        Fmo_Logger::debug('0');
                    
                        $this->view->fechaView = $form->getElement(Application_Form_Miembro::E_FECHA)->getValue();
                    }
                } 
            } catch (Exception $ex) {
                if ($ex->getCode() == 23505) {
                   $this->addMessageError('El usuario ya posee un cargo en la junta directiva');    
                   }
                   else{
                       Zend_Debug::dd($ex->getMessage());
                   }
                   }
            }
        
        $this->view->form = $form; 
     }
    
    
    
}
