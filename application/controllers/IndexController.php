<?php

/**
 * Controlador principal
 */ 

class IndexController extends Fmo_Controller_Action_Abstract
{

    /**
     * Acción por defecto
     */
    public function indexAction()
    {  
    //   $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
        //Fmo_Logger::debug(realpath(__DIR__ . '/../../public/images'));
               $style = '#menu ,  #informacion { display: none; },  #contenido { top: 0%; } ';
        $this->view->headStyle()->appendStyle($style);
        $this->view->sistema = Zend_Registry::get('sistema');
        $this->view->usuario = Fmo_Model_Seguridad::getUsuarioSesion();
        
     function bootstrap()
    {
        //agregar librerias
        $this->view->bootstrap()->enable();
        $this->view->jQueryX()->enable();
        $this->view->bootstrap()->jsEnable();
        $this->view->dataTables()->enable();
    }
 
    }

}