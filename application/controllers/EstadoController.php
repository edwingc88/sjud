<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadoController
 *
 * @author manuelry
 */
class EstadoController extends Fmo_Controller_Action_Abstract
{
    /*
     * Ruta por defecto.
     * 
     */

    private $urlDefault = 'default/estado/nuevo';

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
    public function init()
    {
        parent::init();
        $this->request = $this->getRequest();
    }

    /*
     * Acciion ejecutada para crear un nuevo estado.
     */

    public function nuevoAction()
    {

        $form = new Application_Form_Estado();
        //Fmo_Logger::debug(Application_Model_Estado::getAllEstadoColores());

        if ($this->getParam(Application_Form_Estado::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        } else {
            try {
                $data = $this->paginator(Application_Model_Estado::getAllEstadoColores(),10);

                if ($this->request->isPost()) {
                    if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                        $this->addMessageSuccessful('Se guardo exitosamente el estado');
                        $this->redirect($this->urlDefault); 
                    } else {
                        $this->view->nombreView = $this->getParam(Application_Form_Estado::E_NOMBRE);
                        $this->view->tipoDocumentoView = $this->getParam(Application_Form_Estado::E_TIPO);
                        $this->view->idColorView = $this->getParam(Application_Form_Estado::E_COLOR);
                    }
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
     * Aciion ejecutada para editar un estado.
     */

    public function editarAction()
    {
        $idEstado = $this->getParam('id_estado');
        $tipo = $this->getParam('tipo');
        $consultaEstado = Application_Model_Estado::getDatosEstado($idEstado);

        $id_color = $consultaEstado->id_color;
        $tipo_documento = $consultaEstado->tipo_documento;
        $nombre = $consultaEstado->descripcion;
        if ($this->getParam(Application_Form_Estado::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }
        try {
            $form = new Application_Form_Estado();
            $form->valoresPorDefecto($idEstado, $tipo);
            if ($this->getRequest()->isPost()) {
                $post = $this->getRequest()->getPost();
                if (isset($post[Application_Form_Estado::E_MODIFICAR]) && $form->isValid($post)) {
                    $tipoDocumento = $form->getElement(Application_Form_Estado::E_TIPO)->getValue();
                    $filter = new Zend_Filter_StringToUpper();
                    $nombreEstado = $filter->filter($this->getParam(Application_Form_Estado::E_NOMBRE));
                    $color = $this->getParam(Application_Form_Estado::E_COLOR);
                    
                    if (($nombreEstado != $nombre) || ($tipo_documento != $tipoDocumento) || ($id_color != $color)) {
                        if ($nombreEstado != $nombre) {
                            if (Application_Model_Estado::validarEstado($nombreEstado, $tipoDocumento)) {
                                $this->addMessageWarning('El nombre del estado ya existe.');
                            } else {
                                $form->editarEstado($idEstado);
                                $this->addMessageSuccessful('Se modifico exitosamente el registro');
                                $this->redirect($this->urlDefault);
                            }
                        } else {
                            $form->editarEstado($idEstado);
                            $this->addMessageSuccessful('Se modifico exitosamente el registro');
                            $this->redirect($this->urlDefault);
                        }
                    }
                    if (($tipo_documento == $tipoDocumento) && ($id_color == $color) && ($nombreEstado == $nombre)) {
                        $this->addMessageInformation('Modifica alguno de los datos del estado para modificar');
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
