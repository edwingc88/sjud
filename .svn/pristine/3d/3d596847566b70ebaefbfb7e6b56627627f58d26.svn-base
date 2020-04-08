<?php

/**
 * Controlador base del sistema
 *
 * @author Rafael Rodríguez - F8741 <rafaelars@ferrominera.com>
 */
abstract class My_Controller_Action_Abstract extends Fmo_Controller_Action_Abstract 
{
    
    /**
     * Nombre del parámetro para la confirmación para las eliminaciones
     */
    const P_CONFIRMAR = 'confirmar';    
    
    /**
     * Petición
     * 
     * @var Zend_Controller_Request_Http
     */
    protected $request;
    
    /**
     * Dirección por defecto.
     * 
     * @var string
     */
    protected $urlDefault;
    
    /**
     * Inicialización
     */
    public function init()
    {
        parent::init();
        $this->request = $this->getRequest();
        $params = $this->request->getUserParams();
        unset($params[self::P_CONFIRMAR]);
        $params['action'] = 'listado';
        $urlArray = array();
        foreach ($params as $paramName => $paramValue) {
            if ($paramName != 'module' && $paramName != 'controller' && $paramName != 'action') {
                $urlArray[] = $paramName;
            }
            $urlArray[] = $paramValue;
        }
        $this->view->urlDefault = $this->urlDefault = implode('/', $urlArray);
    }
    
    /**
     * Actión por defecto en el listado
     */
    abstract public function listadoAction();
    
    /**
     * Actión de nuevo
     */
    abstract public function nuevoAction();

    /**
     * Actión de editar
     */
    abstract public function editarAction();

    /**
     * Actión de eliminar
     */
    abstract public function eliminarAction();

    /**
     * Actión de detalle
     */
    abstract public function detalleAction();
            
}
