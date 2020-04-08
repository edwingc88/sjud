<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ResolucionController
 *
 * @author manuelry
 */
class ResolucionController extends Fmo_Controller_Action_Abstract 
{
    /*
     * Ruta por defecto.
     * 
     */

   private $urlDefault  = 'default/Resolucion/nuevo';   
   private $urlDefault1 = 'default/Resolucion/seguimiento';   
   private $urlDefault2 = 'default/resolucion/listado';     
   private $urlDefault3 = 'default/Resolucion/adjunto';        
   private $urlDefault4 = 'default/Resolucion/relacion';      
   private $urlDefault5 = 'default/Resolucion/estatus';         
   private $urlDefault6 = 'default/Resolucion/avance'; 
   //private $_fotos = null;
   private $ruta = Fmo_Config::PATH_UPLOAD_FILES;
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
     * Accion ejecutada para registrar nueva resolucion 
     */
    public function nuevoAction() {
        $form = new Application_Form_Resolucion();
        $this->view->form = $form;        
        
        $form->removeElement(Application_Form_Resolucion::E_AÑO2);
        $form->removeElement(Application_Form_Resolucion::E_ESTADO);
        
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }else{
            try {
                if ($this->request->isPost() ){ 
                         
                  if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                    
                        $this->addMessageSuccessful('Se guardo exitosamente la resolucion');
                        $this->redirect($this->urlDefault);
                   }else {
                    $this->view->asuntoView = $this->getParam(Application_Form_Resolucion::E_ASUNTO);                        
                    $this->view->numResolucionView = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION);                        
                    $this->view->numResolucion1View = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
                    $this->view->añoView = $this->getParam(Application_Form_Resolucion::E_AÑO);
                    $this->view->numReunionView = $this->getParam(Application_Form_Resolucion::E_NUM_REUNION);
                    $this->view->notificacionView = $this->getParam(Application_Form_Resolucion::E_NOTIFICACION);
                    $this->view->gerenciaView = $this->getParam(Application_Form_Resolucion::E_GERENCIA);
                    $this->view->fechaView = $this->getParam(Application_Form_Resolucion::E_FECHA);
                    }
                        
                }
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault);
            }
        }
        
        
              
    }
    
    
    /*
     * Accion ejecutada para modificar alguna resolucion 
     */
    public function listadoAction() {
        $form = new Application_Form_Resolucion();
        $this->view->form = $form;
        $this->view->idView = $this->getParam('id');
        $this->view->id1View = $this->getParam('id1');
        $this->view->añoView = $this->getParam('anio');
        $form->limpiarRequeridos();
        
        //$form->getElement(Application_Form_Resolucion::E_FECHA)->setRequired(false);
        $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION)->setRequired(true);      
        $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION1)->setRequired(true); 
        $form->getElement(Application_Form_Resolucion::E_AÑO)->setRequired(true); 
        
        $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION)->setAttrib('style', 'text-align: left; width: 18%');
        $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION1)->setAttrib('style', 'text-align: left; width: 18%');
        $form->getElement(Application_Form_Resolucion::E_AÑO)->setAttrib('style', 'text-align: left; width: 28%');
        
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
            $this->redirect($this->urlDefault2);
        }
        if ( $this->getParam(Application_Form_Resolucion::E_BUSCAR)&& ($form->isValid($this->request->getPost()))) {
                            // Al presionar "Buscar":
                            
                            $id = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION);                            
                            $idnum = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
                            $año = $this->getParam(Application_Form_Resolucion::E_AÑO);
                            
                                Fmo_Logger::debug('num resolucion'.$id.' '.$idnum.' '.$año) ; 
                                $consultaResolucion = Application_Model_Resolucion::getResolucion($id.$idnum.$año);
                                //Fmo_Logger::debug($consultaResolucion);
                                
                                if($consultaResolucion){
                                $this->view->resolucionesView = true;
                                //Fmo_Logger::debug($consultaResolucion->id_gga);
                                $gerencia = $consultaResolucion->gga_nombre;
                                $this->view->idView = $id ;
                                $this->view->id1View = $idnum;
                                $this->view->añoView = $año;
                                
                                
                                }else{
                                    $this->view->idView = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION); ;
                                    $this->view->id1View = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
                                    $this->view->añoView = $this->getParam(Application_Form_Resolucion::E_AÑO);
                                    $this->addMessageInformation('No se encontro resolucion');
                                }
                            
                            
        } else {            
            if( ($this->getParam('id')!= null)&&($this->getParam('id1')!= null)&&($this->getParam('anio')!= null)){
            $this->view->resolucionesView = true;   
            }
            $form->setDefaults($this->getAllParams());
                }
     }
    
     
    /*
     * Accion ejecutada para editar los datos de una resolucion 
     */
    public function editarAction() {
        $id = $this->getParam('id');      
        $id1 = $this->getParam('id1');
        $anio = $this->getParam('anio');        
        $indice = $this->getParam('indice');
        Fmo_Logger::debug($indice);
        
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
            $this->redirect("default/Resolucion/listado/id/{$id}/id1/{$id1}/anio/{$anio}");
        }else{
            try {
            $form = new Application_Form_Resolucion();
            /*$form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION)->setAttrib('readonly', 'readonly');
            $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION)->setAttrib('readonly', 'readonly');
            $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION)->setAttrib('readonly', 'readonly');*/
            $form->IndiceResolucion($indice);
            $form->valoresPorDefecto($id,$id1,$anio);            
            $form->setLegend($id.'/'.$id1.'/'.$anio);
            
            $form->removeElement(Application_Form_Resolucion::E_AÑO2);
            $form->removeElement(Application_Form_Resolucion::E_ESTADO);
                if ($this->request->isPost() ){ 
                         
                  if (($form->proceso($this->request->getPost())) && ($form->isValid($this->request->getPost()))) {
                    
                        $this->addMessageSuccessful('Se modifico exitosamente la resolucion');
                        $this->redirect("default/Resolucion/listado/id/{$id}/id1/{$id1}/anio/{$anio}");
        
                    }
                        
                } else {
                    $form->setDefaults($this->getAllParams());
                    
                }
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault3);
            }
        }
        
        $this->view->form = $form;
        
    }
    
     
    /*
     * Accion ejecutada para adjuntar archivos a una resolucion 
     */
    public function adjuntoAction() {
      $id = $this->getParam('id');      
      $id1 = $this->getParam('id1');
      $anio = $this->getParam('anio');
      $this->view->id1View = $id;      
      $this->view->id2View = $id1;      
      $this->view->anioView = $anio;
      
      $form = new Application_Form_AdjuntoResolucion();           
      $form->setLegend($id.'/'.$id1.'/'.$anio);
      //Fmo_Logger::debug($id.'/'.$id1.'/'.$anio);
      $post = $this->getRequest()->getPost();
      $consultaResolucion = Application_Model_Resolucion::getResolucion($id.$id1.$anio);
      $this->view->idView = $consultaResolucion->indice;
      $indice = $consultaResolucion->indice; 

        if ( $this->getParam(Application_Form_AdjuntoResolucion::E_VOLVER) ) {
            $this->redirect("default/Resolucion/listado/id/{$id}/id1/{$id1}/anio/{$anio}");
        }else{
            try {
                
                if (($this->getParam(Application_Form_AdjuntoResolucion::E_AGREGAR))){
                    if($form->getElement(Application_Form_AdjuntoResolucion::E_BROWSE)->getFileName()){
                        $adjunto = pathinfo($form->getElement(Application_Form_AdjuntoResolucion::E_BROWSE)->getFileName());
                        $filename = $adjunto['basename'];
                        Fmo_Logger::debug($filename);
                        $form->setNombreArchivo($filename); //Juan                  
                        $form->subirArchivo($indice);
                        $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                    }else{
                    $this->addMessageWarning('Ingrese un archivo');    
                    }
                    
                    }                
                
            
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect("default/Resolucion/adjunto/id/{$id}/id1/{$id1}/anio/{$anio}");
            
            }
        }
        $this->view->form = $form;
    }
    
     
    /*
     * Accion ejecutada para seguimiento de las resoluciones 
     */
    public function seguimientoAction() {
        
        $form = new Application_Form_Resolucion();
        $this->view->form = $form; 
        $this->view->numResolucionView =  $this->getParam('numRes');
        $this->view->numResolucion1View =  $this->getParam('numResolucion');
        $this->view->anioResolucionView =  $this->getParam('anioRes');
        $this->view->numReunionView =  str_replace("_", "/", $this->getParam('numReu'));
        $this->view->palabraView =  $this->getParam('asunto');
        $this->view->fechaView =  str_replace("_", "/",$this->getParam('fecha'));
        $this->view->anio2View =  $this->getParam('anio2');
        Fmo_Logger::debug($this->getParam('estadoRes'));
        $form->limpiarrequeridos();    
        $form->getElement(Application_Form_Resolucion::E_FECHA)->setLabel('Fecha reunión:');
        $form->getElement(Application_Form_Resolucion::E_NUM_REUNION)->setLabel('Numero Reunión:');
        
        if ($this->getParam(Application_Form_Resolucion::E_LIMPIAR)) {
            $this->redirect($this->urlDefault1);
        }
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
            $this->redirect($this->urlDefault1);
        }else{
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
                        $this->view->mostrarView = true;
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
                          ||($this->getParam('fecha')!= '')||($this->getParam('estadoRes')!= '')||($this->getParam('anio2')!= '')){
                            
                            $form->setDefault(Application_Form_Resolucion::E_ESTADO,$this->getParam('estadoRes'));
                            $this->view->estadoView = $this->getParam(Application_Form_Resolucion::E_ESTADO);
                            $form->setDefault(Application_Form_Resolucion::E_GERENCIA,$this->getParam('gerenciaRes'));
                            $this->view->gerenciaView =  $this->getParam(Application_Form_Resolucion::E_GERENCIA);
                        
                            $resoluciones = Application_Model_Resolucion::getResoluciones($this->getParam('numRes'),
                            $this->getParam('numResolucion'),$this->getParam('anioRes'),str_replace("_", "/", $this->getParam('numReu')),$this->getParam('gerenciaRes'),
                            $this->getParam('asunto'),str_replace("_", "/",$this->getParam('fecha')),$this->getParam('estadoRes'),$this->getParam('anio2'));
                            
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
    
    /*
     * Accion ejecutada para relacionar una resolucion con otras resoluciones 
     */
    public function relacionAction() {
      $form = new Application_Form_Resolucion; 
      $indice = $this->getParam('id');
      $this->view->indiceView = $indice;
      $numResolucion =  $this->getParam('numRes');
      $numResolucion1 =  $this->getParam('numResolucion');
      $año =  $this->getParam('anioRes');
      $numReunion =  $this->getParam('numReu');
      $gerencia =  $this->getParam('gerenciaRes');
      $palabra =  $this->getParam('asunto');
      $fecha =  $this->getParam('fecha');
      $estado =  $this->getParam('estadoRes');
      $anio =  $this->getParam('anio2');
      
      Fmo_Logger::debug($numResolucion1);
      $resolucion = Application_Model_Resolucion::getResolucionIndice($indice);
      $form->setLegend($resolucion->id1.'/'.$resolucion->id2.'/'.$resolucion->anio);
      
      $form->limpiarRequeridos();
      //Se remueven los elementos para poder validar la forma de resolucion 
      //con los elementos necesarios para la misma
      $form->removerElementosRelaciones();
      
      
      $form->getElement(Application_Form_Resolucion::E_AÑO2)->setAttrib('style', 'text-align: left; width: 15%');      
      $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION)->setAttrib('style', 'text-align: left; width: 10%');      
      $form->getElement(Application_Form_Resolucion::E_NUM_RESOLUCION1)->setAttrib('style', 'text-align: left; width: 10%');      
      $form->getElement(Application_Form_Resolucion::E_AÑO)->setAttrib('style', 'text-align: left; width: 15%');
        
      
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
             $this->redirect("default/Resolucion/seguimiento/numRes/{$numResolucion}/numResolucion/{$numResolucion1}/anioRes/{$año}/numReu/{$numReunion}/gerenciaRes/{$gerencia}/asunto/{$palabra}/fecha/{$fecha}/estadoRes/{$estado}/anio2/{$anio}");
        
        }
        if ($this->getParam(Application_Form_Resolucion::E_LIMPIAR)) {
            $form->reset();
        } 
        if($this->getParam(Application_Form_Resolucion::E_BUSCAR) && ($form->isValid($this->request->getPost()))) {
            $consultaResoluciones = Application_Model_Resolucion::getResolucionRelaciones($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION),
            $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1),$this->getParam(Application_Form_Resolucion::E_AÑO),
            $this->getParam(Application_Form_Resolucion::E_GERENCIA),$this->getParam(Application_Form_Resolucion::E_AÑO2));
            $this->view->mostrarView = true; 
            Fmo_Logger::debug($consultaResoluciones);
            $this->view->datosView = $consultaResoluciones;
            $this->view->anioView = $this->getParam(Application_Form_Resolucion::E_AÑO2);                        
            $this->view->numResolucionView = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION);                        
            $this->view->numResolucion1View = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
            $this->view->añoView = $this->getParam(Application_Form_Resolucion::E_AÑO);
            $this->view->gerenciaView = $this->getParam(Application_Form_Resolucion::E_GERENCIA);
        }else{
            try {
                if ($this->getParam(Application_Form_Resolucion::E_AGREGAR)) {
                    $chkSelecciones = $this->_request->getParam('chk');                    
                    
                            if ($chkSelecciones != null && is_array($chkSelecciones)) {
                                $totalrelaciones = 0;
                                foreach ($chkSelecciones as $chkSeleccion) {
                                    //Registrar relaciones

                                    // $chkSeleccion esta compuesta por el indice de la resolucion
                                    
                                    $indiceResolB = $chkSeleccion;
                                    if (Application_Model_RelacionResolucion::validarRelacion($indice,$indiceResolB)){
                                        
                                    $consultaResolucion = Application_Model_Resolucion::getResolucionIndice($indiceResolB);
                                    $this->addMessageWarning('La resolucion '.$consultaResolucion->id.'/'.
                                            Fmo_Util::stringToZendDate($consultaResolucion->fecha_real)->toString('yyyy').
                                            ' no se relaciono debido a que existe la relacion');
                                
                                    }else{
                                    $form->guardarRelacion($indice,$indiceResolB);
                                    $totalrelaciones++;
                                    }
                                }
                                if ( $totalrelaciones == 1 ) {
                                    $this->addMessageSuccessful('Se relaciono una resolucion satisfactoriamente.');
                                } 
                                if ( $totalrelaciones == 0 ){
                                $this->addMessageInformation('No se relaciono por tener relacion con la resolucion.');
                                   
                                }if ( $totalrelaciones > 1 ){
                                 $this->addMessageSuccessful($totalrelaciones.' resoluciones fueron relacionadas satisfactoriamente.');
                                }
                            }else {
                                $this->addMessageWarning('No se seleccionó resolucion para la relacion.');
                                $consultaResoluciones = Application_Model_Resolucion::getResolucionRelaciones($this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION),
                                $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1),$this->getParam(Application_Form_Resolucion::E_AÑO),
                                $this->getParam(Application_Form_Resolucion::E_GERENCIA),$this->getParam(Application_Form_Resolucion::E_AÑO2));
                                $this->view->mostrarView = true; 
                                $this->view->datosView = $consultaResoluciones;
                                $this->view->anioView = $this->getParam(Application_Form_Resolucion::E_AÑO2);                        
                                $this->view->numResolucionView = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION);                        
                                $this->view->numResolucion1View = $this->getParam(Application_Form_Resolucion::E_NUM_RESOLUCION1);
                                $this->view->añoView = $this->getParam(Application_Form_Resolucion::E_AÑO);
                                $this->view->gerenciaView = $this->getParam(Application_Form_Resolucion::E_GERENCIA);
                            }
                    
                }
               } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault4);
            }
        }
        $this->view->form = $form;
    }
    
    /*
     * Accion ejecutada para eliminar relaciones o adjuntos de una resolucion 
     */
    public function eliminarAction(){
    $tipo = $this->getParam('tipo');
    $this->view->tipoView = $tipo;
        
    if($tipo != 'adjunto'){
        
        $form = new Application_Form_Resolucion; 
        $form->limpiarRequeridos();
        $idRelacion = $this->getParam('indice_relacion');
        $indice = $this->getParam('indice');        
        $indiceb = $this->getParam('indice_resolucionb');
        $this->view->idRelacionView = $idRelacion;
        $this->view->indiceView = $indice;
        $this->view->indicebView = $indiceb;
        Fmo_Logger::debug($indice);
            $pConfirmar = $this->getParam('confirmar');
           Fmo_Logger::debug($pConfirmar);
            try {
                if ($pConfirmar == 'S') {
                    
                    $registroRelacion = Application_Model_DbTable_RelacionResolucion::findOneById($idRelacion);
                    $mensaje = "El registro de la relacion (Código {$idRelacion}) ha sido eliminado satisfactoriamente.";
                    $registroRelacion->delete();
                    $this->addMessageSuccessful($mensaje);
                    $this->redirect("default/Resolucion/relacion/id/{$indice}");
         
                } else {
                    if ($pConfirmar == 'N') {
                        $this->addMessageInformation('Ha cancelado la eliminación de la relacion de resolucion');
                        $this->redirect("default/Resolucion/relacion/id/{$indice}");
                    }
                }
            } catch (Exception $ex) {
                if ($ex->getCode() == 23503) {
                    $this->addMessageWarning('No puede eliminarse el registro.');
                    $this->redirect("default/Resolucion/relacion/id/{$indice}");
            }
            }
        $this->view->form = $form; 
        }else{
            
        $form = new Application_Form_Resolucion();
        $this->view->form = $form;
        $numPagina = $this->getParam('page');
        $idadjunto = $this->getParam('id_adjunto');
        $id = $this->getParam('id');      
        $id1 = $this->getParam('id1');
        $anio = $this->getParam('anio');
        $this->view->id1View = $id;      
        $this->view->id2View = $id1;      
        $this->view->anioView = $anio;
        Fmo_Logger::debug($id);
        Fmo_Logger::debug($id1);
        Fmo_Logger::debug($anio);
        if(!empty($idadjunto)){
        $adjunto = Application_Model_AdjuntoResolucion::getAdjuntoResolucion($idadjunto);
        $nombre = $adjunto->ruta;
        $this->view->nombreView = $adjunto->nombre;
        $this->view->idAdjuntoView = $idadjunto;
        }
        
        Fmo_Logger::debug($nombre);
        
            $pConfirmar = $this->getParam('confirmar');
            Fmo_Logger::debug($pConfirmar);
            try {
                if ($pConfirmar == 'S') {
                    $consultaArchivo = Application_Model_AdjuntoResolucion::getAllAdjuntosResolucion($idadjunto);
                    $registroAdjunto = Application_Model_DbTable_AdjuntoResolucion::findOneById($idadjunto,$adjunto->indice_resolucion);
                    $mensaje = "El registro del adjunto (Código {$idadjunto}) ha sido eliminado satisfactoriamente.";
                    unlink($nombre)   ; 
                    $registroAdjunto->delete();                    
                    $this->addMessageSuccessful($mensaje);
                    $this->redirect("default/Resolucion/adjunto/id/{$id}/id1/{$id1}/anio/{$anio}");
         
                } else {
                    if ($pConfirmar == 'N') {
                        $this->addMessageInformation('Ha cancelado la eliminación del adjunto de la resolucion');
                        $this->redirect("default/Resolucion/adjunto/id/{$id}/id1/{$id1}/anio/{$anio}");
                    }
                }
            } catch (Exception $ex) {
                if ($ex->getCode() == 23503) {
                    $this->addMessageWarning('No puede eliminarse el registro.');
                    $this->redirect("default/Resolucion/adjunto/id/{$id}/id1/{$id1}/anio/{$anio}");
            }
            }
           
            
        }
    }
    
    /*
     * Accion ejecutada para cambiar el estatus de una resolucion
     */
    public function estatusAction(){
        
      $indice = $this->getParam('id');   
      $numResolucion =  $this->getParam('numRes');
      $numResolucion1 =  $this->getParam('numResolucion');
      $año =  $this->getParam('anioRes');
      $numReunion =  $this->getParam('numReu');
      $gerencia =  $this->getParam('gerenciaRes');
      $palabra =  $this->getParam('asunto');
      $fechaparametro =  $this->getParam('fecha');
      $estado =  $this->getParam('estadoRes');
      $anio =  $this->getParam('anio2');
      Fmo_Logger::debug($estado);
      $form = new Application_Form_Resolucion; 
      $resolucion = Application_Model_Resolucion::getResolucionIndice($indice);
      $form->getElement(Application_Form_Resolucion::E_FECHA)->setLabel('Fecha Procesado:');      
      $form->getElement(Application_Form_Resolucion::E_ASUNTO)->setLabel('Observaciones procesado:'); 
      $fecha = Fmo_Util::stringToZendDate($resolucion->fecha_real)->toString('yyyy');       
      $fecha_creacion = $resolucion->fecha_creacion;  
      $form->setLegend($resolucion->id1.'/'.$resolucion->id2.'/'.$resolucion->anio);      
      $form->limpiarRequeridos();      
      $form->setDefault(Application_Form_Resolucion::E_ESTADO,$resolucion->id_estado);
      
      if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
          $this->redirect("default/Resolucion/seguimiento/numRes/{$numResolucion}/numResolucion/{$numResolucion1}/anioRes/{$año}/numReu/{$numReunion}/gerenciaRes/{$gerencia}/asunto/{$palabra}/fecha/{$fechaparametro}/estadoRes/{$estado}/anio2/{$anio}");
        
      }else{
            try {
                if ($this->getParam(Application_Form_Resolucion::E_GUARDAR)&& ($form->isValid($this->request->getPost()))) {
                    $estado = Application_Model_Estado::getDatosEstado($this->getParam(Application_Form_Resolucion::E_ESTADO));                   
                    $descripcion_estado = $estado->descripcion;
                    $this->view->asuntoView = $this->getParam(Application_Form_Resolucion::E_ASUNTO);
                    $this->view->fechaView  = $this->getParam(Application_Form_Resolucion::E_FECHA);
                    //$idresol = $resolucion->id;
                    Fmo_Logger::debug($this->getParam(Application_Form_Resolucion::E_ASUNTO));
                    Fmo_Logger::debug($this->getParam(Application_Form_Resolucion::E_FECHA));
                    if($this->getParam(Application_Form_Resolucion::E_ESTADO) == $resolucion->id_estado){
                    $this->addMessageWarning('No puede modificar una resolucion con mismo estado');
                            
                    }else{
                        
                        Fmo_Logger::debug($this->getParam(Application_Form_Resolucion::E_ASUNTO));
                        Fmo_Logger::debug($this->getParam(Application_Form_Resolucion::E_FECHA));
                        Fmo_Logger::debug($descripcion_estado);
                        if(($descripcion_estado != 'PROCESADA')){
                            $form->modificarEstatusResolucion($this->getParam(Application_Form_Resolucion::E_ESTADO),$indice);
                            $this->addMessageSuccessful('Modificacion de estado exitosa');
                            $this->redirect($this->urlDefault1);
                        }
                        if(($descripcion_estado == 'PROCESADA') && 
                          (($this->getParam(Application_Form_Resolucion::E_ASUNTO) == null) || 
                           ($this->getParam(Application_Form_Resolucion::E_FECHA) == null)) ){
                        //$this->view->asuntoView = $this->getParam(Application_Form_Resolucion::E_ASUNTO);
                        //$this->view->fechaView =  $this->getParam(Application_Form_Resolucion::E_FECHA);      
                        $this->addMessageInformation('Debe ingresar todos los campos para modificar el estado a procesada');
                        }else{
                        $form->modificarEstatusResolucion($this->getParam(Application_Form_Resolucion::E_ESTADO),$indice);
                            $this->addMessageSuccessful('Modificacion de estado exitosa');
                            $this->redirect($this->urlDefault1);
                        }
                    }
                }
                
            } catch (Exception $ex) {
                //22 ERROR 
                $mensaje = $ex->getCode();
                $this->addMessageException($ex);
               $this->redirect("default/resolucion/estatus/id/{$indice}");
        
            }
        }
    $this->view->form = $form;
   }
   
    /*
     * Accion ejecutada para registrar avances de las resoluciones 
     */
    public function avanceAction(){
        
      $indice = $this->getParam('id'); 
      $numResolucion =  $this->getParam('numRes');
      $numResolucion1 =  $this->getParam('numResolucion');
      $año =  $this->getParam('anioRes');
      $numReunion =  $this->getParam('numReu');
      $gerencia =  $this->getParam('gerenciaRes');
      $palabra =  $this->getParam('asunto');
      $fechaparametro =  $this->getParam('fecha');
      $estado =  $this->getParam('estadoRes');
      $anio =  $this->getParam('anio2');
      $this->view->indiceView = $indice;
      $form = new Application_Form_Resolucion; 
      $form->limpiarRequeridos();
      $resolucion = Application_Model_Resolucion::getResolucionIndice($indice);
      $form->getElement(Application_Form_Resolucion::E_FECHA)->setLabel('Fecha Revisión:');      
      $form->getElement(Application_Form_Resolucion::E_ASUNTO)->setLabel('Observaciones:'); 
      $form->getElement(Application_Form_Resolucion::E_FECHA)->setRequired(true);      
      $form->getElement(Application_Form_Resolucion::E_ASUNTO)->setRequired(true);      
      $fecha = Fmo_Util::stringToZendDate($resolucion->fecha_real)->toString('yyyy');
      $form->setLegend($resolucion->id1.'/'.$resolucion->id2.'/'.$resolucion->anio);
      
      if ($this->getParam(Application_Form_Resolucion::E_CANCELAR) ) {
          $this->redirect("default/Resolucion/seguimiento/numRes/{$numResolucion}/numResolucion/{$numResolucion1}/anioRes/{$año}/numReu/{$numReunion}/gerenciaRes/{$gerencia}/asunto/{$palabra}/fecha/{$fechaparametro}/estadoRes/{$estado}/anio2/{$anio}");
       }else{
            try {
                $asunto = $this->getParam(Application_Form_Resolucion::E_ASUNTO);
                $fecha  = $this->getParam(Application_Form_Resolucion::E_FECHA);
                   
                if ($this->getParam(Application_Form_Resolucion::E_GUARDAR) && ($form->isValid($this->request->getPost()))) {
                    $form->guardarAvance($indice, $fecha, $asunto);
                    $this->addMessageSuccessful('Avance Registrado');
                   $this->redirect("default/Resolucion/avance/id/{$indice}");
   
                }else{
                $this->view->asuntoView = $this->getParam(Application_Form_Resolucion::E_ASUNTO);;
                $this->view->fechaView = $fecha  = $this->getParam(Application_Form_Resolucion::E_FECHA);;
                    
                }
                
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault5);
            }
        }
    $this->view->form = $form;
   }
   
    /*
     * Accion ejecutada para abrir adjuntos de las resoluciones 
     */
    public function abrirAction(){
        
    if(!$this->getRequest()->getParam('id_adjunto')){
        exit();
    }
    $adjunto = $this->getRequest()->getParam('id_adjunto');
    if($this->getParam('tipo_adjunto') == 'resolucion'){
    $consultaAdjunto = Application_Model_AdjuntoResolucion::getAdjuntoResolucion($adjunto);
        if(!empty($consultaAdjunto)){
        $nombre = $consultaAdjunto->nombre;
        $ruta = $consultaAdjunto->ruta; 
        }
    }else{
    $consultaAdjunto = Application_Model_AdjuntoPunto::getAdjuntoPunto($adjunto);
        if(!empty($consultaAdjunto)){
        $nombre = $consultaAdjunto->nombre;
        $ruta = $consultaAdjunto->ruta; 
        }        
    } 
    
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
        
        /*if($tipo != '.pdf'){        
        $this->_helper->layout()->disableLayout();
        $bits = file_get_contents($file);
        $this->_response->setHeader('Content-Type', '.jpg');
        $this->_response->setBody($bits);
        }else{*/            
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
        
    //} 
    }
}
