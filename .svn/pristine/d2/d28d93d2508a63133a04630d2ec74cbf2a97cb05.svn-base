<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReunionController
 *
 * @author manuelry
 */
class ReunionController extends Fmo_Controller_Action_Abstract 
{
    /*
     * Ruta por defecto.
     * 
     */

    private $urlDefault = '/default/Reunion/index';

    
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
        $this->view->page = $this->getParam('page');
        //$this->urlDefault = "{$this->request->getModuleName()}/{$this->request->getControllerName()}/listado/page/{$this->view->page}";
    }
    
    /*
     * Accion ejecutada para mostrar el calendario
     */
    public function indexAction() {
        
        $pAnio = $this->_getParam('anio');
        Fmo_Logger::debug($pAnio);
        //$pReunion = $this->_getParam('agregar reunion');
        //$pNombres = $this->_getParam('nombres');
        $url = $this->urlDefault;
        $pVolver = rawurldecode($this->_getParam('volver', $url));
        $calendario = new Application_Model_Calendario();
        $fecha = new Zend_Date();
        $anioHoy = $fecha->get(Zend_Date::YEAR);        
        $calendario->setAnio($pAnio);
        $calendario->setUrlEditar($this->view->url(array('controller' => 'Reunion',
            'action' => 'nueva',
            'anioactual' => $anioHoy,
                ), null, true));
        $calendario->setUrlDetalle($this->view->url(array('controller' => 'Reunion',
            'action' => 'detalle',
            'anioactual' => $anioHoy,
                ), null, true));
        //Aqui
       
        
        $calendario->setAnio($pAnio);
        $calendario->setTitulo('AGENDA DE REUNIONES');
        $calendario->setUrlSigAntAnio($this->view->url(array(
            'module' => 'application',
            'controller' => 'Reunion',
            'action' => 'index',
            'anioactual' => $anioHoy,
            'volver' => rawurlencode($pVolver)
                ), null, true));
        try {
            $reuniones = new Application_Model_Reunion;
            $fecha = $reuniones->getAllReunionAño($calendario->getAnio());
            if(!empty($fecha)):
               $contador = 0;
               foreach ($fecha as $index => $fecha):
                   $cont = 0;
                    $titulo = '';
                    $fechaReunion = new Zend_Date($fecha->fecha_real, Zend_Date::DATES);
                    $formato = new Zend_Date($fecha->fecha_real);
                    $nueva =  $formato->toString('dd/MM/yyyy');
                    $fechaReunion->setYear($calendario->getAnio());
                    $imgSrc = 'ico_reunion9.png';
                    $arreglo = array();
                    $arreglo ['id'] = $fecha->indice;
                    
                    $id_reunion = $fecha->id;
                    if($fecha->tipo_nombre == 'LABORAL NORMAL'|| $fecha->tipo_nombre == 'NO LABORAL'){
                    $titulo = 'Reunion '.$fecha->tipo_nombre.' '.$nueva;    
                    }else{
                    $titulo = $fecha->tipo_nombre.':'.$nueva;
                    }
                    $arreglo ['descripcion'] = $titulo;
                    $calendario->addElementoReunion($fechaReunion, $fecha->tipo_nombre);
                    $calendario->addElementoImg($fechaReunion, $imgSrc, $arreglo);
               endforeach;
               endif;
                
            } catch (Exception $e) {
                $this->addMessageException($e);
            }
        $this->view->calendario = $calendario;
        $this->view->volver = $pVolver;
            
    }
    
    
    /*
     * Accion ejecutada para registrar una nueva reunion en el calendario
     */
    public function nuevaAction() {
        $anio = $this->getParam('anio');      
        $mes = $this->getParam('mes');             
        $dia = $this->getParam('dia');
        $fecha = $anio.'-'.$mes.'-'.$dia.'-';
        $tipo = $this->getParam('tipo');        
        $form = new Application_Form_Reunion();         
        $this->view->form = $form; 
        $form->valoresPorDefecto($anio, $mes,$dia,$tipo);      
        
        if ($this->getParam(Application_Form_Reunion::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }else{
            try {
                if ($this->request->isPost() ){                    
                    Fmo_Logger::debug($anio);
                        if (($form->proceso($this->request->getPost(),$fecha)) && ($form->isValid($this->request->getPost()))) {
                        $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                        $this->redirect($this->urlDefault);
                        }else{ 
                        $this->view->idReunionView = $this->getParam(Application_Form_Reunion::E_REUNION);                        
                        $this->view->nuevoView = $this->getParam(Application_Form_Reunion::E_ESTADO_NUEVO);     
                        $this->view->idReunionView = $this->getParam(Application_Form_Reunion::E_REUNION);                        
                        }
                       
                }
            } catch (Exception $ex) {
              $this->addMessageException($ex);
              $this->redirect($this->urlDefault);
              }
        } 
     }
    
     
    /*
     * Accion ejecutada para editar los datos de una reunion
     */
    public function detalleAction() {        
        $id = $this->getParam('id');   
        $tipo = $this->getParam('tipo');
        Fmo_Logger::debug($tipo);
        $form = new Application_Form_Reunion();              
        $this->view->form = $form; 
        //Fmo_Logger::debug($id);
        $reunion = Application_Model_Reunion::getReunionIndice($id);
        Fmo_Logger::debug($reunion);
        $form->valoresPorDetalle($tipo,$id);
        $form->getElement(Application_Form_Reunion::E_REUNION)->setAttrib('readonly', 'readonly');      
        $form->getElement(Application_Form_Reunion::E_ESTADO_NUEVO)->setLabel('Tipo Reunion:');
        if($reunion){
        $form->setDefault(Application_Form_Reunion::E_ESTADO_NUEVO, $reunion->id_tipo_reunion);
        }
        if ($this->getParam(Application_Form_Estado::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }else{
            try {
                if ($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();
                $form->setDefaults($post);
                 if(isset($post[Application_Form_Cargo::E_MODIFICAR]) && $form->isValid($post)){
                        $form->editarReunion($id);
                        $this->addMessageSuccessful('Se modifico exitosamente el registro');
                        $this->redirect($this->urlDefault);
                      
                }
                }
                
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault);
                }
        }
        $this->view->form = $form;  
     }
     
    
    
    
}
