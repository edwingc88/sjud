<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConsultaController
 *
 * @author manuelry
 */
class ConsultaController extends Fmo_Controller_Action_Abstract
{
    /*
     * Ruta por defecto.
     * 
     */

    private $urlDefault = 'default/Miembro/nuevo';
    private $urlDefault1 = 'default/Miembro/actuales';
    private $urlDefault2 = 'default/Consulta/resoluciones';
    private $urlDefault3 = 'default/Consulta/punto';
    private $urlDefault4 = 'default/Consulta/resolucionessinavance';
    private $urlDefault5 = 'default/Consulta/detalleresolucion';

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
        //$this->view->page = $this->getParam('page');
        //$this->urlDefault = "{$this->request->getModuleName()}/{$this->request->getControllerName()}/listado/page/{$this->view->page}";
    }

    public function nuevoAction()
    {
        
    }

    public function actualesAction()
    {
        $form = new Application_Form_Miembro();
        $this->view->form = $form;

        // FECHA EN LETRAS 
        //        Fmo_Logger::debug($cal['fecha']->get(Zend_Date::DATE_LONG));
    }

    public function listadoAction()
    {
       try {
            $form = new Application_Form_Miembro();
            $data = $this->paginator(Application_Model_Miembros::getMiembrosAnterioresConActual(),30);
        } catch (Exception $ex) {
            $data = null;
            $this->addMessageException($ex);
            $this->redirect($this->urlDefault2);
        }
        
        $this->view->data = $data;
        $this->view->form = $form; 
    }

    public function resolucionesAction()
    {
        $form = new Application_Form_Resolucion();
        $this->view->form = $form; 
        $this->view->numResolucionView =  $this->getParam('numRes');
        $this->view->numResolucion1View =  $this->getParam('numResolucion');
        $this->view->anioResolucionView =  $this->getParam('anioRes');
        $this->view->numReunionView =  str_replace("_", "/", $this->getParam('numReu'));
        $this->view->palabraView =  $this->getParam('asunto');
        $this->view->fechaView =  str_replace("_", "/",$this->getParam('fechaRes'));
        $this->view->anio2View =  $this->getParam('anio2');
        
        $form->limpiarrequeridos();
        $form->getElement(Application_Form_Resolucion::E_FECHA)->setLabel('Fecha reunión:');
        $form->getElement(Application_Form_Resolucion::E_NUM_REUNION)->setLabel('Numero Reunión:');

        if ($this->getParam(Application_Form_Resolucion::E_LIMPIAR)) {
            $this->redirect($this->urlDefault2);
        }
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
            $this->redirect($this->urlDefault2);
        } else {
            try {
                    if ($this->getParam(Application_Form_Resolucion::E_BUSCAR) && ($form->isValid($this->request->getPost()))) {
                  
                    if(($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) != null) || ($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) != null) 
                            || ($this->getParam(Application_Form_Resolucion::E_AÑO) != null)||($this->getParam(Application_Form_Resolucion::E_NUM_REUNION) != null) 
                            || ($this->getParam(Application_Form_Resolucion::E_GERENCIA) != null )|| ($this->getParam(Application_Form_Resolucion::E_PALABRA_CLAVE) != null) 
                            || ($this->getParam(Application_Form_Resolucion::E_FECHA) != null )||($this->getParam(Application_Form_Resolucion::E_ESTADO) != null) 
                            || ($this->getParam(Application_Form_Resolucion::E_AÑO2) != null)){
                        
                        if(($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) != null &&
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) == null && $this->getParam(Application_Form_Resolucion::E_AÑO) == null)||
                                ($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) == null &&
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) != null && $this->getParam(Application_Form_Resolucion::E_AÑO) != null)||
                                ($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) == null &&
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) == null && $this->getParam(Application_Form_Resolucion::E_AÑO) != null)||
                                ($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) != null &&
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) != null && $this->getParam(Application_Form_Resolucion::E_AÑO) == null)||
                                ($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) == null &&
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) != null && $this->getParam(Application_Form_Resolucion::E_AÑO) != null)||
                                ($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION) != null &&
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1) == null && $this->getParam(Application_Form_Resolucion::E_AÑO) != null)){
                        //$this->view->mostrarView = true;
                        $this->view->numResolucionView =  $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION);
                        $this->view->numResolucion1View =  $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
                        $this->view->anioResolucionView =  $this->getParam(Application_Form_Resolucion::E_AÑO);
                        $this->view->numReunionView =  $this->getParam(Application_Form_Resolucion::E_NUM_REUNION);
                        $form->setDefault(Application_Form_Resolucion::E_GERENCIA,$this->getParam(Application_Form_Resolucion::E_GERENCIA));
                        $this->view->gerenciaView =  $this->getParam(Application_Form_Resolucion::E_GERENCIA);
                        $this->view->palabraView =  $this->getParam(Application_Form_Resolucion::E_PALABRA_CLAVE);
                        $this->view->fechaView =  $this->getParam(Application_Form_Resolucion::E_FECHA);
                        $form->setDefault(Application_Form_Resolucion::E_ESTADO,$this->getParam(Application_Form_Resolucion::E_ESTADO));
                        $this->view->estadoView = $this->getParam(Application_Form_Resolucion::E_ESTADO);
                        $this->view->anio2View =  $this->getParam(Application_Form_Resolucion::E_AÑO2);
                            $form->getElement(Application_Form_Resolucion::E_AÑO)->addError('Ingrese todos los campos para buscar una resolucion'); 
                        }else{
                        //Fmo_Logger::debug('$consultaResoluciones');
                        $resoluciones = Application_Model_Resolucion::getResoluciones($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION),
                        $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1),$this->getParam(Application_Form_Resolucion::E_AÑO),
                        $this->getParam(Application_Form_Resolucion::E_NUM_REUNION),$this->getParam(Application_Form_Resolucion::E_GERENCIA),
                        $this->getParam(Application_Form_Resolucion::E_PALABRA_CLAVE),$this->getParam(Application_Form_Resolucion::E_FECHA),
                        $this->getParam(Application_Form_Resolucion::E_ESTADO),$this->getParam(Application_Form_Resolucion::E_AÑO2));
                    
                        if(!empty ($resoluciones)){
                        $data = $this->paginator($resoluciones);

                        }else{
                        $data = null;    
                        }
                        $this->view->mostrarView = true; 
                        $this->view->data = $data;
                        $this->view->numResolucionView =  $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION);
                        $this->view->numResolucion1View =  $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
                        $this->view->anioResolucionView =  $this->getParam(Application_Form_Resolucion::E_AÑO);
                        $this->view->numReunionView =  $this->getParam(Application_Form_Resolucion::E_NUM_REUNION);
                        $form->setDefault(Application_Form_Resolucion::E_GERENCIA,$this->getParam(Application_Form_Resolucion::E_GERENCIA));
                        $this->view->gerenciaView =  $this->getParam(Application_Form_Resolucion::E_GERENCIA);
                        $this->view->palabraView =  $this->getParam(Application_Form_Resolucion::E_PALABRA_CLAVE);
                        $this->view->fechaView =  $this->getParam(Application_Form_Resolucion::E_FECHA);
                        $form->setDefault(Application_Form_Resolucion::E_ESTADO,$this->getParam(Application_Form_Resolucion::E_ESTADO));
                        $this->view->estadoView = $this->getParam(Application_Form_Resolucion::E_ESTADO);
                        $this->view->anio2View =  $this->getParam(Application_Form_Resolucion::E_AÑO2);   
                        }
                    }else{   
                    $this->addMessageInformation('Ingrese al menos un criterio para la busqueda');
                    }
                  }else {
                          if( (($this->getParam('numRes')!= '')&&($this->getParam('numResolucion')!= '')&&($this->getParam('anioRes')!= ''))
                          ||($this->getParam('numReu')!= '')||($this->getParam('gerenciaRes')!= '')||($this->getParam('asunto')!= '')
                          ||($this->getParam('fechaRes')!= '')||($this->getParam('estadoRes')!= '')||($this->getParam('anio2')!= '')){
                            
                            $form->setDefault(Application_Form_Resolucion::E_ESTADO,$this->getParam('estadoRes'));
                            $this->view->estadoView = $this->getParam(Application_Form_Resolucion::E_ESTADO);
                            $form->setDefault(Application_Form_Resolucion::E_GERENCIA,$this->getParam('gerenciaRes'));
                            $this->view->gerenciaView =  $this->getParam(Application_Form_Resolucion::E_GERENCIA);
                        
                            $resoluciones = Application_Model_Resolucion::getResoluciones($this->getParam('numRes'),
                            $this->getParam('numResolucion'),$this->getParam('anioRes'),str_replace("_", "/", $this->getParam('numReu')),$this->getParam('gerenciaRes'),
                            $this->getParam('asunto'),str_replace("_", "/",$this->getParam('fechaRes')),$this->getParam('estadoRes'),$this->getParam('anio2'));
                            
                            if(!empty ($resoluciones)){
                            $data = $this->paginator($resoluciones);

                            }else{
                            $data = null;    
                            }
                            $this->view->mostrarView = true; 
                            $this->view->data = $data;
                            
                            }
                    }
                
            } catch (Exception $ex) {
                //$data = null;
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault1);
            }
        }
    }

    public function avanceresolucionAction()
    {

        $indice = $this->getParam('id');
        $numResolucion =  $this->getParam('numRes');
        $numResolucion1 =  $this->getParam('numResolucion');
        $año =  $this->getParam('anioRes');
        $numReunion =  $this->getParam('numReu');
        $gerencia =  $this->getParam('gerenciaRes');
        $palabra =  $this->getParam('asunto');
        $fechaparametro =  $this->getParam('fechaRes');
        $estado =  $this->getParam('estadoRes');
        $anio =  $this->getParam('anio2');
        Fmo_Logger::debug($año);
        $this->view->indiceView = $indice;
        $form = new Application_Form_Resolucion;
        $resolucion = Application_Model_Resolucion::getResolucionIndice($indice);
        $fecha = Fmo_Util::stringToZendDate($resolucion->fecha_real)->toString('yyyy');
        $form->setLegend($resolucion->id1 . '/' . $resolucion->id2 . '/' . $resolucion->anio);

        if ($this->getParam(Application_Form_Resolucion::E_VOLVER)) {
            $this->redirect("default/Consulta/resoluciones/numRes/{$numResolucion}/numResolucion/{$numResolucion1}/anioRes/{$año}/numReu/{$numReunion}/gerenciaRes/{$gerencia}/asunto/{$palabra}/fechaRes/{$fechaparametro}/estadoRes/{$estado}/anio2/{$anio}");
         }
        $this->view->form = $form;
    }

    public function adjuntoresolucionAction()
    {

        $indice = $this->getParam('id');
        $numResolucion =  $this->getParam('numRes');
        $numResolucion1 =  $this->getParam('numResolucion');
        $año =  $this->getParam('anioRes');
        $numReunion =  $this->getParam('numReu');
        $gerencia =  $this->getParam('gerenciaRes');
        $palabra =  $this->getParam('asunto');
        $fechaparametro =  $this->getParam('fechaRes');
        $estado =  $this->getParam('estadoRes');
        $anio =  $this->getParam('anio2');
        
        $this->view->indiceView = $indice;
        $form = new Application_Form_AdjuntoResolucion();
        
        if ($this->getParam(Application_Form_AdjuntoResolucion::E_VOLVER)) {
             $this->redirect("default/Consulta/resoluciones/numRes/{$numResolucion}/numResolucion/{$numResolucion1}/anioRes/{$año}/numReu/{$numReunion}/gerenciaRes/{$gerencia}/asunto/{$palabra}/fechaRes/{$fechaparametro}/estadoRes/{$estado}/anio2/{$anio}");
        
        }

        try{
            $resolucion = Application_Model_Resolucion::getResolucionIndice($indice);
            $fecha = Fmo_Util::stringToZendDate($resolucion->fecha_real)->toString('yyyy');
            $form->setLegend($resolucion->id1 . '/' . $resolucion->id2 . '/' . $resolucion->anio);
            $post = $this->getRequest()->getPost();
            $consultaResolucion = Application_Model_Resolucion::getResolucion($resolucion->id1.$resolucion->id2. $resolucion->anio);
            if (!empty($consultaResolucion)) {
            $this->view->idView = $consultaResolucion->indice;
            } 
            
            
        } catch (Exception $ex) {
                //$data = null;
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault1);
        }
       

        
        $this->view->form = $form;
    }

    public function detalleresolucionAction()
    {

        $form = new Application_Form_Resolucion();
        $indiceResolucion = $this->getParam('id');
        $indiceImprimir = $this->getParam('indice');
        $tipo = $this->getParam('tipo');
        
        $this->view->numResolucionView =  $this->getParam('numRes');
        $this->view->numResolucion1View =  $this->getParam('numResolucion');
        $this->view->anioResolucionView =  $this->getParam('anioRes');
        $this->view->numReunionView =  $this->getParam('numReu');
        $this->view->gerenciaView =  $this->getParam('gerenciaRes');
        $this->view->palabraView =  $this->getParam('asunto');
        $this->view->fechaView =  $this->getParam('fechaRes');
        $this->view->estadoView =  $this->getParam('estadoRes');
        $this->view->anio2View =  $this->getParam('anio2');
        
        $this->view->indice = $this->getParam('id');
        $this->view->id1 = $this->getParam('id1');
        $this->view->id2 = $this->getParam('id2');
       
        if ($indiceResolucion != ' ') {
            $this->view->mostrarView = true;
            $this->view->data = Application_Model_Resolucion::getResolucionIndice($indiceResolucion);
            $consulta = Application_Model_Resolucion::getResolucionIndice($indiceResolucion);
            $this->view->anio =$consulta->anio;
            $this->view->form = $form;
        }
        if ($indiceImprimir != null && $tipo == 'pdf') {
            try {
                $tSolicitud = new Application_Model_Resolucion();
                $query = $tSolicitud->getResolucionIndice($indiceImprimir, 1);
                Fmo_Logger::debug($query);

                $this->_helper->viewRenderer->setNoRender();
                $this->_helper->layout()->disableLayout();
                $jr = new Fmo_JasperStarter();

                $filename = "Resolucion_" . Fmo_Util::stringToZendDate(Zend_Date::now())->toString('dd-MM-yyyy');
                Fmo_Logger::debug($filename);
                //var_dump($filename);exit;
                $jr->setReport('jr_consulta_resolucion_detalle');
                $jr->addParam('query', $query)
                        ->addParam('PATH_IMAGES', realpath(__DIR__ . '/../../public/images'))
                        ->send($filename);
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault5);
            }
        }
        if ($indiceImprimir != null && $tipo == 'excel') {
            $this->view->datos = Application_Model_Resolucion::getResolucionIndice($indiceImprimir);
            $consultaResoluciones = Application_Model_Resolucion::getResolucionIndice($indiceImprimir);
            $this->view->id1 = $consultaResoluciones->id1;
            $this->view->id2 = $consultaResoluciones->id2;
            $this->view->anio = $consultaResoluciones->anio;

            $this->view->generarExcel = true;
            // Para generar el reporte en excel:
            // Se deshabilita el layout, para que sus datos no se
            // impriman en el reporte en excel.
            $this->_helper->layout->disableLayout();

            header("Pragma: public");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: pre-check=0, post-check=0, max-age=0");
            header("Pragma: no-cache");
            header("Expires: 0");
            header('Content-Transfer-Encoding: none');
            header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Type: application/vnd.ms-excel;");
            header("Content-type: application/x-msexcel");
            header("Content-Disposition: attachment; filename=Detalle_Resolucion" . Fmo_Util::stringToZendDate(Zend_Date::now())->toString('dd-MM-yyyy') . ".xls");
        }
    }

    public function resolucionessinavanceAction()
    {
        $form = new Application_Form_Resolucion();
        $this->view->form = $form;
        $this->view->mostrarView = true;

        $resoluciones = Application_Model_Resolucion::getAllResolucionSinAvance();
        $tSolicitud = new Application_Model_Resolucion();
        $query = $tSolicitud->getAllResolucionSinAvance(true, 1);
        Fmo_Logger::debug($query);
        //Fmo_Logger::debug($resoluciones);
        //Fmo_Logger::debug('VACIO?');
        if (!empty($resoluciones)) {
            $data = $this->paginator($resoluciones, $elementos = 10);
            $this->view->data = $data;
            //$data = Zend_Paginator::factory($resoluciones);
        } else {
            $data = null;
        }
        
        if ($this->getParam(Application_Form_Resolucion::E_PDF)) {
            try {
                if(!empty($resoluciones)){
                $tSolicitud = new Application_Model_Resolucion();
                $query = $tSolicitud->getAllResolucionSinAvance(true, 1);
                Fmo_Logger::debug($query);


                Fmo_Logger::debug($resoluciones);
                $this->_helper->viewRenderer->setNoRender();
                $this->_helper->layout()->disableLayout();
                $jr = new Fmo_JasperStarter();

                $filename = "Detalle_de_Resoluciones_Sin_Avance_Actual_" . Fmo_Util::stringToZendDate(Zend_Date::now())->toString('dd-MM-yyyy');
                Fmo_Logger::debug($filename);
                //var_dump($filename);exit;
                $jr->setReport('jr_consulta_sin_avance');
                $jr->addParam('query', $query)
                        ->addParam('PATH_IMAGES', realpath(__DIR__ . '/../../public/images'))
                        ->send($filename);
                }else{
                $this->addMessageWarning('No hay resoluciones para generar un pdf')  ; 
                }
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault4);
            }
        }
        if ($this->getParam(Application_Form_Resolucion::E_EXCEL)) {
            if(!empty($resoluciones)){
                    
            $this->view->generarExcel = true;
            // Para generar el reporte en excel:
            // Se deshabilita el layout, para que sus datos no se
            // impriman en el reporte en excel.
            $this->_helper->layout->disableLayout();

            header("Pragma: public");
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: pre-check=0, post-check=0, max-age=0");
            header("Pragma: no-cache");
            header("Expires: 0");
            header('Content-Transfer-Encoding: none');
            header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Type: application/vnd.ms-excel;");
            header("Content-type: application/x-msexcel");
            header("Content-Disposition: attachment; filename=Reporte_Resoluciones_Sin_Avance_Actual" . Fmo_Util::stringToZendDate(Zend_Date::now())->toString('dd-MM-yyyy') . ".xls");
            }else{
                $this->addMessageWarning('No hay resoluciones para generar un pdf');   
                }
            
        }
    }

    public function puntoAction()
    {
        $form = new Application_Form_Punto();
        $form->limpiarRequeridosConsulta();        
        $form->getElement(Application_Form_Punto::E_FECHA)->setLabel('Fecha registro:');
        $form->getElement(Application_Form_Punto::E_ASUNTO)->setLabel('Palabra clave asunto:');
        $gerencia = $this->getParam(Application_Form_Punto::E_GERENCIA);
                $modalidad = $this->getParam(Application_Form_Punto::E_MODALIDAD);
                $this->view->tipoView = $this->getParam(Application_Form_Punto::E_TIPO_PUNTO);
                //$this->view->gerenciaView = $gerencia;
                //$this->view->modalidadView = $modalidad;
                $this->view->año2View = $this->getParam(Application_Form_Punto::E_AÑO2);

                if ($gerencia != null) {
                    $this->view->gerenciaView = $gerencia;
                    $consultaSiglas = Application_Model_GerenciaGeneralCoordinacion::getDatosGerencia($gerencia);
                    if($consultaSiglas ){
                    $this->view->numPuntoView = $consultaSiglas->siglas ;
                    }
                    
                }
                if ($modalidad != null) {
                    $this->view->modalidadView = $modalidad;
                    $consultaPunto = Application_Model_Punto::getModalidades($modalidad);

                    if ($consultaPunto == 1) {
                        $consultaUltPunto = Application_Model_Punto::getUltPunto($consultaPunto);
                        $ult = 'Pto-Cta ' . $consultaUltPunto->id . '/' . Fmo_Util::stringToZendDate($consultaUltPunto->fecha_real)->toString('yyyy');
                        $tipo = 'Pto-Cta';
                        $form->valoresPorDefecto($ult, $tipo);
                    } else {
                        $consultaUltPunto = Application_Model_Punto::getUltPunto($consultaPunto);
                        $ult = 'Pto-I ' . $consultaUltPunto->id . '/' . Fmo_Util::stringToZendDate($consultaUltPunto->fecha_real)->toString('yyyy');
                        $tipo = 'Pto-I';
                        $form->valoresPorDefecto($ult, $tipo);
                    }
                }

        if ($this->getParam(Application_Form_Punto::E_LIMPIAR)) {
            $this->redirect($this->urlDefault3);
        }
        if ($this->getParam(Application_Form_Punto::E_CANCELAR)) {
            $this->redirect($this->urlDefault3);
        } else {
            try {
                
             
                    if ($this->getParam(Application_Form_Punto::E_BUSCAR) && ($form->isValid($this->request->getPost()))) {

                        if ($this->getParam(Application_Form_Punto::E_GERENCIA) != null || $this->getParam(Application_Form_Punto::E_MODALIDAD) != null || $this->getParam(Application_Form_Punto::E_SIGLAS) != null ||
                                $this->getParam(Application_Form_Punto::E_NUM_PUNTO1) != null || $this->getParam(Application_Form_Punto::E_AÑO) != null ||
                                $this->getParam(Application_Form_Punto::E_ASUNTO) != null || $this->getParam(Application_Form_Punto::E_FECHA) != null ||
                                $this->getParam(Application_Form_Punto::E_ESTADO) != null || $this->getParam(Application_Form_Punto::E_AÑO2)) {
                                                        
                            $this->view->mostrarView = true;
                            $gerencia = $this->getParam(Application_Form_Punto::E_GERENCIA);
                            $modalidad = $this->getParam(Application_Form_Punto::E_MODALIDAD);
                            $consultaPuntos = Application_Model_Punto::getPuntos($this->getParam(Application_Form_Punto::E_GERENCIA), $this->getParam(Application_Form_Punto::E_MODALIDAD), $this->getParam(Application_Form_Punto::E_SIGLAS), $this->getParam(Application_Form_Punto::E_NUM_PUNTO1), $this->getParam(Application_Form_Punto::E_AÑO), $this->getParam(Application_Form_Punto::E_ASUNTO), $this->getParam(Application_Form_Punto::E_FECHA), $this->getParam(Application_Form_Punto::E_ESTADO), $this->getParam(Application_Form_Punto::E_AÑO2));
                            //Fmo_Logger::debug($consultaPuntos);
                            if (!empty($consultaPuntos)) {
                                //Fmo_Logger::debug($consultaPuntos);
                                $data = $this->paginator($consultaPuntos);
                                //$data = Zend_Paginator::factory($resoluciones);
                            } else {
                                $data = null;
                            }

                            $this->view->data = $data;
                            $this->view->datosView = $consultaPuntos;
                            $form->setDefault($this->getParam(Application_Form_Punto::E_GERENCIA), $this->getParam('gerenciaPun'));
                            $form->setDefault($this->getParam(Application_Form_Punto::E_MODALIDAD), $this->getParam('modalidadPun'));
                            $form->setDefault($this->getParam(Application_Form_Punto::E_ESTADO), $this->getParam('estadoPun'));
                            $form->setDefault($this->getParam(Application_Form_Punto::E_TIPO_PUNTO), $this->getParam('tipoPun'));
                            
                            $this->view->gerenciaView = $this->getParam(Application_Form_Punto::E_GERENCIA);
                            $this->view->modalidadView = $this->getParam(Application_Form_Punto::E_MODALIDAD);
                            //$this->view->numPuntoView = $this->getParam(Application_Form_Punto::E_SIGLAS);
                            $this->view->numPunto1View = $this->getParam(Application_Form_Punto::E_NUM_PUNTO1);
                            $this->view->añoView = $this->getParam(Application_Form_Punto::E_AÑO);
                            $this->view->asuntoView = $this->getParam(Application_Form_Punto::E_ASUNTO);
                            $this->view->fechaView = $this->getParam(Application_Form_Punto::E_FECHA);
                            $form->setDefault($this->getParam(Application_Form_Punto::E_ESTADO), $this->getParam(Application_Form_Punto::E_ESTADO));
                            $this->view->estadoView = $this->getParam(Application_Form_Punto::E_ESTADO);
                            $this->view->año2View = $this->getParam(Application_Form_Punto::E_AÑO2);
                            $this->view->tipoView = $this->getParam(Application_Form_Punto::E_TIPO_PUNTO);
                        //}
                        
                        }else {
                            $this->addMessageInformation('Ingrese al menos un criterio para la busqueda');
                        }
                    }else {
                          if((($this->getParam('gerenciaPun')!= '')||($this->getParam('modalidadPun')!= '')||($this->getParam('siglasPun')!= '')||
                          $this->getParam('numPun')||($this->getParam('anioPun')!= '')||($this->getParam('palabraPun')!= '')||($this->getParam('fechaPun')!= '')||
                                  ($this->getParam('estadoPun')!= '')||($this->getParam('anio2')!= ''))){
                                    
                            $this->view->gerenciaView =  $this->getParam('gerenciaPun');
                            $this->view->modalidadView =  $this->getParam('modalidadPun');
                            $this->view->asuntoView =  $this->getParam('palabraPun');
                            $this->view->fechaView =  str_replace("_", "/",$this->getParam('fechaPun'));
                            $this->view->año2View =  $this->getParam('anio2');        
                            $this->view->numPuntoView = $this->getParam('siglasPun');
                            $this->view->numPunto1View = $this->getParam('numPun');
                            $this->view->añoView = $this->getParam('anioPun');     
                            $form->setDefault(Application_Form_Punto::E_TIPO_PUNTO,$this->getParam('tipoPun'));
                            $this->view->mostrarView = true;
                            $form->setDefault($this->getParam(Application_Form_Punto::E_TIPO_PUNTO),$this->getParam('tipoPun'));
                            
                            if($this->getParam('gerenciaPun')){
                                $this->view->gerenciaView = $this->getParam('gerenciaPun');                            
                                $consultaSiglas = Application_Model_GerenciaGeneralCoordinacion::getDatosGerencia($this->getParam('gerenciaPun'));
                                if ($consultaSiglas) {
                                $this->view->numPuntoView = $consultaSiglas->siglas;
                                }
                            }
                            $this->view->modalidadView = $this->getParam('modalidadPun');
                            
                            
                            $this->view->añoView = $this->getParam('anioPun');                  
                            $form->setDefault(Application_Form_Punto::E_ESTADO,$this->getParam('estadoPun'));
                            $this->view->estadoView = $this->getParam(Application_Form_Punto::E_ESTADO);
                            //$form->setDefault($this->getParam(Application_Form_Punto::E_TIPO_PUNTO), $this->getParam('tipoPun'));
                            Fmo_Logger::debug('entro');                            
                            $gerencia = $this->getParam('gerenciaPun');
                            $modalidad = $this->getParam('modalidadPun');
                            $siglas = $this->getParam('siglasPun');
                            $id = $this->getParam('numPun');
                            $año = $this->getParam('anioPun');     
                            $clave = $this->getParam('palabraPun');
                            $fecha_registro = $this->getParam('fechaPun');
                            $estatus = $this->getParam('estadoPun');
                            $año2 = $this->getParam('anio2');                            
                            
                            $consultaPuntos = Application_Model_Punto::getPuntos(($this->getParam('gerenciaPun')),($this->getParam('modalidadPun')),($this->getParam('siglasPun')),
                            $this->getParam('numPun'),($this->getParam('anioPun')),($this->getParam('palabraPun')),str_replace("_", "/",$this->getParam('fechaPun')),($this->getParam('estadoPun')),
                            ($this->getParam('anio2')));
                            
                            Fmo_Logger::debug($consultaPuntos);
                            if (!empty($consultaPuntos)) {
                                //Fmo_Logger::debug($consultaPuntos);
                                $data = $this->paginator($consultaPuntos);
                                //$data = Zend_Paginator::factory($resoluciones);
                            } else {
                                $data = null;
                            }
                          
                            $this->view->data = $data;
                            $this->view->datosView = $consultaPuntos;
                            
                            }
                    }
                
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault3);
            }
        }

        $this->view->form = $form;
    }

    public function adjuntopuntoAction()
    {

        $indice = $this->getParam('id');
        $this->view->indiceView = $indice;        
        $gerencia =  $this->getParam('gerenciaPun');
        $modalidad =  $this->getParam('modalidadPun');
        $asunto =  $this->getParam('palabraPun');
        $fechaparametro =  $this->getParam('fechaPun');
        $estado =  $this->getParam('estadoPun');
        $anio2 =  $this->getParam('anio2');        
        $siglas = $this->getParam('siglasPun');
        $numPun = $this->getParam('numPun');
        $anioPun = $this->getParam('anioPun');        
        $tipo = $this->getParam('tipoPun');
        $form = new Application_Form_AdjuntoPunto();
        
        if ($this->getParam(Application_Form_AdjuntoPunto::E_VOLVER)) {
           $this->redirect("default/Consulta/punto/gerenciaPun/{$gerencia}/modalidadPun/{$modalidad}/palabraPun/{$asunto}/fechaPun/{$fechaparametro}/estadoPun/{$estado}/anio2/{$anio2}/siglasPun/{$siglas}/numPun/{$numPun}/anioPun/{$anioPun}/tipoPun/{$tipo}");
        
        } 
        
        try{
            $punto = Application_Model_Punto::getPuntoIndice($indice);
        $fecha = Fmo_Util::stringToZendDate($punto->fecha_real)->toString('yyyy');
        $form->setLegend($punto->nombre_modalidad.' '.$punto->siglas.'/'.$punto->id.'/'.$punto->anio);
        $post = $this->getRequest()->getPost();
        if (!empty($indice)) {
            $this->view->idView = $indice;
        }
            
            
        } catch (Exception $ex) {
                //$data = null;
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault1);
        }
               
        

        

        $this->view->form = $form;
    }
 
    
    public function reunionAction()
    {
        $this->view->generarExcel = null;
        $pAnio = $this->_getParam('anio');
        $pTipo = $this->_getParam('tipo');
        //$pReunion = $this->_getParam('agregar reunion');
        //$pNombres = $this->_getParam('nombres');
        $url = $this->urlDefault;
        $pVolver = rawurldecode($this->_getParam('volver', $url));
        $calendario = new Application_Model_Calendario();
        $calendario->setConsulta('consulta');
        $fecha = new Zend_Date();
        $anioHoy = $fecha->get(Zend_Date::YEAR);
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
            $this->view->data = $fecha; 
            if (!empty($fecha)) {
                $contador = 0;
                foreach ($fecha as $index => $fecha):
                    $cont = 0;
                    $titulo = '';
                    $fechaReunion = new Zend_Date($fecha->fecha_real, Zend_Date::DATES);
                    $formato = new Zend_Date($fecha->fecha_real);
                    $nueva = $formato->toString('dd/MM/yyyy');
                    $fechaReunion->setYear($calendario->getAnio());
                    $imgSrc = 'ico_reunion9.png';
                    $arreglo = array();
                    $arreglo ['id'] = $fecha->indice;

                    $id_reunion = $fecha->id;
                    if ($fecha->tipo_nombre == 'LABORAL NORMAL' || $fecha->tipo_nombre == 'NO LABORAL') {
                        $titulo = 'Reunion ' . $fecha->tipo_nombre . ' ' . $nueva;
                    } else {
                        $titulo = $fecha->tipo_nombre . ':' . $nueva;
                    }
                    $arreglo ['descripcion'] = $titulo;
                    $calendario->addElementoReunion($fechaReunion, $fecha->tipo_nombre);
                    $calendario->addElementoImg($fechaReunion, $imgSrc, $arreglo);
                endforeach;
            }

            if ($pTipo == 'excel') {
                $this->view->generarExcel = true;
                // Para generar el reporte en excel:
                // Se deshabilita el layout, para que sus datos no se
                // impriman en el reporte en excel.
                $this->_helper->layout->disableLayout();

                header("Pragma: public");
                header("Cache-Control: no-store, no-cache, must-revalidate");
                header("Cache-Control: pre-check=0, post-check=0, max-age=0");
                header("Pragma: no-cache");
                header("Expires: 0");
                header('Content-Transfer-Encoding: none');
                header('Content-Encoding: UTF-8');
                header('Content-Type: text/csv; charset=utf-8');
                header("Content-Type: application/vnd.ms-excel;");
                header("Content-type: application/x-msexcel");
                header("Content-Disposition: attachment; filename=Reporte_Resoluciones_Sin_Avance_Actual" . Fmo_Util::stringToZendDate(Zend_Date::now())->toString('dd-MM-yyyy') . ".xls");
            }
            if ($pTipo == 'pdf') {
            try {
                $tSolicitud = new Application_Model_Reunion;
                $query = $tSolicitud->getAllReunionAño($calendario->getAnio(), 1);
                Fmo_Logger::debug($query);
                if(!empty($query)){
                $this->_helper->viewRenderer->setNoRender();
                $this->_helper->layout()->disableLayout();
                $jr = new Fmo_JasperStarter();

                $filename = "Agenda_Reuniones_Año_".$calendario->getAnio();
                Fmo_Logger::debug($filename);
                //var_dump($filename);exit;
                $jr->setReport('jr_consulta_agenda_reunion');
                $jr->addParam('query', $query)
                        ->addParam('anio', $calendario->getAnio())
                        ->addParam('PATH_IMAGES', realpath(__DIR__ . '/../../public/images'))
                        ->send($filename);
                }else{
                    $this->addMessageInformation('No se encontraron Reuniones para el año en curso');
                }
                    
                    
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect("default/Consulta/reunion");
         }
        }
            
        } catch (Exception $e) {
            $this->addMessageException($e);
        }


        $this->view->calendario = $calendario;
    }
    
    public function abrirAction(){
        
        
    if(!$this->getRequest()->getParam('id_adjunto')){
        exit();
    }    
    $adjunto = $this->getRequest()->getParam('id_adjunto');    
    if($this->getParam('tipo_adjunto') == 'resolucion'){
        
        //    Fmo_Logger::debug('Resolucion');
    $consultaAdjunto = Application_Model_AdjuntoResolucion::getAdjuntoResolucion($adjunto);
        if(!empty($consultaAdjunto)){
        $nombre = $consultaAdjunto->nombre;
        $ruta = $consultaAdjunto->ruta; 
        }
    }else{
        
         //   Fmo_Logger::debug('punto');
    $consultaAdjunto = Application_Model_AdjuntoPunto::getAdjuntoPunto($adjunto);
        if(!empty($consultaAdjunto)){
            $nombre = $consultaAdjunto->nombre;
        $ruta = $consultaAdjunto->ruta; 
        }        
    }   
    //Anaicelys Brito
    /*$tipo = substr($nombre, strlen($nombre)-4,  strlen($nombre));  
    //Fmo_Logger::debug($tipo);
        $file = (PATH_UPLOAD_FILES.$nombre);
        Fmo_Logger::debug($file);// Anaicelys Brito
        /*
         * 
         * Hay que desactivar el layout, si no, la imagen no se va a mostrar
         */  
        $pathSplitted = explode(DIRECTORY_SEPARATOR, $ruta);
        $fileName = $pathSplitted[count($pathSplitted) - 1];
        //$tipo = substr($nombre, strlen($nombre)-4,  strlen($nombre));
        //Fmo_Logger::debug($tipo);
        //$file = (PATH_UPLOAD_FILES . DIRECTORY_SEPARATOR . $nombre);
        $file = (PATH_UPLOAD_FILES . DIRECTORY_SEPARATOR . $fileName);

        Fmo_Logger::debug($file);
        /*
         * 
         * Hay que desactivar el layout, si no, la imagen no se va a mostrar
         */  
        
        
            if(!file_exists($file)){
            die('Error: File not found: '.$file);
            }
            else
            {                // Set headers
                 // Set headers
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$nombre");
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
            readfile($file);
            }
        
   
    }
}

