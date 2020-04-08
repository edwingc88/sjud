<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PuntoController
 *
 * @author manuelry
 */
class PuntoController extends Fmo_Controller_Action_Abstract 
{
    /*
     * Ruta por defecto.
     * 
     */

   private $urlDefault = 'default/Punto/nuevo';
   private $urlDefault1 = 'default/Punto/modificar';

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
        //$this->view->page = $this->getParam('page');
        //$this->urlDefault = "{$this->request->getModuleName()}/{$this->request->getControllerName()}/listado/page/{$this->view->page}";
    }
    
    /*
     * Accion ejecutada para crear un nuevo Punto
     */
    public function nuevoAction() {
        $form = new Application_Form_Punto();
        $gerencia = $this->getParam(Application_Form_Punto::E_GERENCIA);
        $modalidad = $this->getParam(Application_Form_Punto::E_MODALIDAD);
        
        if ($this->getParam(Application_Form_Punto::E_CANCELAR)) {
            $this->redirect($this->urlDefault);
        }else{
            try {
                   
                if($gerencia){
                $this->view->gerenciaView = $gerencia;   
                $consultaSiglas = Application_Model_GerenciaGeneralCoordinacion::getDatosGerencia($gerencia);
                    if($consultaSiglas ){
                        Fmo_Logger::debug($consultaSiglas->siglas);
                    $form->siglaPorDefecto($consultaSiglas->siglas) ;
                    
                    }
                }
                if($modalidad != null){
                $this->view->modalidadView = $modalidad;
                $consultaPunto = Application_Model_Punto::getModalidades($modalidad);
                
                    if($consultaPunto == 1){
                    $consultaUltPunto = Application_Model_Punto::getUltPunto($consultaPunto,Fmo_Util::stringToZendDate($this->getParam(Application_Form_Punto::E_FECHA))->toString('yyyy'));
                    if($consultaUltPunto){
                    $ult = 'Pto-Cta '.$consultaUltPunto->id.'/'.Fmo_Util::stringToZendDate($consultaUltPunto->fecha_real)->toString('yyyy');
                    $tipo = 'Pto-Cta';
                    }else{
                    $ult = 'Pto-Cta' ;
                    $tipo = 'Pto-Cta';   
                    }
                    $form->valoresPorDefecto($ult, $tipo);
                    }else{
                        $consultaUltPunto = Application_Model_Punto::getUltPunto($consultaPunto);
                        if($consultaUltPunto){
                        $ult = 'Pto-I '.$consultaUltPunto->id.'/'.Fmo_Util::stringToZendDate($consultaUltPunto->fecha_real)->toString('yyyy');
                        $tipo = 'Pto-I';
                        }else{
                        $ult = 'Pto-Cta' ;
                        $tipo = 'Pto-Cta';   
                        }
                        $form->valoresPorDefecto($ult, $tipo);
                        }
                } 
                //$num =  $this->getParam(Application_Form_Punto::E_NUM_PUNTO1);
                //$modalidad = $this->getParam(Application_Form_Punto::E_MODALIDAD);
                //$año =  $this->getParam(Application_Form_Punto::E_AÑO);
                
                $post = $this->getRequest()->getPost();
            
                    //if ( $num && $modalidad && $año){
                        //if(! Application_Model_Punto::validarPunto($this->getParam(Application_Form_Punto::E_NUM_PUNTO1),$this->getParam(Application_Form_Punto::E_MODALIDAD),$this->getParam(Application_Form_Punto::E_AÑO))){
                            if ($form->proceso($post)){ 
                            $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                            $this->redirect($this->urlDefault);    
                                
                            }else {
                            //$this->view->modalidadView = $modalidad;
                            //$this->view->gerenciaView = $gerencia;
                            $this->view->tipoView = $this->getParam(Application_Form_Punto::E_TIPO_PUNTO);
                            //$this->view->numPuntoView = $this->getParam(Application_Form_Punto::E_SIGLAS);
                            $this->view->numPunto1View = $this->getParam(Application_Form_Punto::E_NUM_PUNTO1);
                            $this->view->añoView = $this->getParam(Application_Form_Punto::E_AÑO);
                            $this->view->asuntoView = $this->getParam(Application_Form_Punto::E_ASUNTO); 
                    
                            } 
                        //}else{
                        //$punto = $this->getParam(Application_Form_Punto::E_TIPO_PUNTO);
                        //$this->addMessageInformation('Ya existe el punto para el año '.$this->getParam(Application_Form_Punto::E_AÑO));     
                        //}
                    //}
               
                
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault);
            }
            
        $this->view->form = $form;
        }
        
              
    }
    
    
    /*
     * Accion ejecutada para modificar algun Punto
     */
    public function modificarAction() {
        $form = new Application_Form_Punto();
        $form->setAjax($this->getAllParams());
        $this->view->form = $form;     
        $form->limpiarRequeridos();   
        $form->getElement(Application_Form_Punto::E_MODALIDAD)->setAttrib('onchange', 'form.submit();');
        $form->getElement(Application_Form_Punto::E_DATOS_GERENCIA)->setAttrib('style', 'text-align: left; width: 25%');
        $form->getElement(Application_Form_Punto::E_NUM_PUNTO1)->setAttrib('style', 'text-align: left; width: 12%');
        $form->getElement(Application_Form_Punto::E_AÑO)->setAttrib('style', 'text-align: left; width: 20%');
        $siglas = $this->getParam('siglas');     
        $id = $this->getParam('id');   
        
        $indice = $this->getParam('indice');  
        
        $anio = $this->getParam('anio');        
        $modalidad = $this->getParam('modalidad');        
        $tipo = $this->getParam('tipo');
        //Fmo_Logger::debug($siglas.' '.$id.' '.$anio);
        $filter = new Zend_Filter_StringToUpper();
     
        if ($this->getParam(Application_Form_Punto::E_CANCELAR)) {
            $this->redirect($this->urlDefault1);
        }else{
            try {
            if ($this->request->isPost() ){ 
                $modalidad = $this->getParam(Application_Form_Punto::E_MODALIDAD);
                $buscar = $this->getParam(Application_Form_Punto::E_BUSCAR);
                if($buscar != null){
                 $siglas = $this->getParam(Application_Form_Punto::E_DATOS_GERENCIA);
                 $filtro = $filter->filter($siglas);
                 //Fmo_Logger::debug($filtro);
                 $form->setDefault(Application_Form_Punto::E_DATOS_GERENCIA, $filtro);
                 $form->setDefault(Application_Form_Punto::E_NUM_PUNTO1, $this->getParam(Application_Form_Punto::E_NUM_PUNTO1));
                 $form->setDefault(Application_Form_Punto::E_AÑO, $this->getParam(Application_Form_Punto::E_AÑO));
                 $this->view->siglasView = $filtro;
                 $this->view->numPuntoView = $this->getParam(Application_Form_Punto::E_NUM_PUNTO1);
                 $this->view->añoView = $this->getParam(Application_Form_Punto::E_AÑO);
                 $this->view->mostrarView = true;  
                }
                
                if($modalidad != null){
                $this->view->modalidadView = $modalidad;
                $consultaPunto = Application_Model_Punto::getModalidades($modalidad);
                    if($consultaPunto == 1){
                    $consultaUltPunto = Application_Model_Punto::getUltPunto($consultaPunto);
                    $ult = 'Pto-Cta '.$consultaUltPunto->id.'/'.Fmo_Util::stringToZendDate($consultaUltPunto->fecha_real)->toString('yyyy');
                    $tipo = 'Pto-Cta';
                    $this->view->tipoView = 'Pto-Cta ';
                    $form->valoresPorDefecto($ult, $tipo);
                    
                    }else{
                        $consultaUltPunto = Application_Model_Punto::getUltPunto($consultaPunto);
                        $ult = 'Pto-I '.$consultaUltPunto->id.'/'.Fmo_Util::stringToZendDate($consultaUltPunto->fecha_real)->toString('yyyy');
                        $tipo = 'Pto-I';                        
                        $this->view->tipoView = 'Pto-I ';
                        $form->valoresPorDefecto($ult, $tipo);
                    
                        }
                }
                
                
            } else {
                if(($this->getParam('indice')!=null)&&($this->getParam('tipo')!=null) ){
                    $consulta = Application_Model_Punto::getPuntoIndice($indice);
                    $this->view->siglasView = $consulta->siglas;
                    $this->view->numPuntoView = $consulta->id;
                    $this->view->añoView = $consulta->anio;                  
                    $this->view->modalidadView = $consulta->id_modalidad;
                    $this->view->tipoView = $this->getParam('tipo');
                    $this->view->mostrarView = true;
                    $form->setDefault(Application_Form_Punto::E_DATOS_GERENCIA, $consulta->siglas);
                    $form->setDefault(Application_Form_Punto::E_NUM_PUNTO1,$consulta->id);
                    $form->setDefault(Application_Form_Punto::E_AÑO, $consulta->anio);
                    $form->setDefault(Application_Form_Punto::E_MODALIDAD, $consulta->id_modalidad);                 
                    $form->setDefault(Application_Form_Punto::E_TIPO_PUNTO, $this->getParam('tipo'));
                }
          
                }
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect($this->urlDefault1);
            }
        }
     }
         
    /*
     * Accion ejecutada para editar datos de un Punto
     */
    public function editarAction() {
       $form = new Application_Form_Punto();
                        
        $tipo = $this->getParam('tipo'); 
        $siglas = $this->getParam('siglas');      
        $id = $this->getParam('id');    
        $indice = $this->getParam('indice');
        $anio = $this->getParam('anio'); 
        $pagina = $this->getParam('page');
        $modalidad = $this->getParam('modalidad');
        $pagina = $this->getParam('page');
        $form->valoresDefecto($indice);
       
        $form->setLegend($tipo.' '.$siglas.'/'.$id.'/'.$anio);

               
        $gerencia = $this->getParam(Application_Form_Punto::E_GERENCIA);
               
        Fmo_Logger::debug($indice);
       
        if ($this->getParam(Application_Form_Resolucion::E_CANCELAR)) {
            $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
        }else{
            try { 
               if($gerencia != null){
                $consultaSiglas = Application_Model_GerenciaGeneralCoordinacion::getDatosGerencia($gerencia);
                    $form->siglaPorDefecto($consultaSiglas->siglas) ;
                    
                }else{
                                        
                    $form->siglaPorDefecto($siglas) ;
                       
                }
               
                $punto_modalidad = $this->getParam(Application_Form_Punto::E_MODALIDAD);
               
               if($punto_modalidad != null){
                   
                 Fmo_Logger::debug($punto_modalidad);
                $consultaPunto = Application_Model_Punto::getModalidades($punto_modalidad);
                 $ult = ' ';
                    if($consultaPunto == 1){
                    $tipo = 'Pto-Cta';
                    $form->valoresPorDefecto($ult,$tipo);
                    }else{
                    $tipo = 'Pto-I';
                    $form->valoresPorDefecto($ult,$tipo);
                        }
                }
                if ($this->request->isPost() ){ 
                   $form->indicePunto($indice);
                        if ($form->proceso($this->request->getPost())){ 
                            $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                            $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
                        }
                    } 
            } catch (Exception $ex) {
                $this->addMessageException($ex);
                $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
           }
        }
        //$form->getElement(Application_Form_Punto::E_MODALIDAD)->setAttrib('readonly', 'readonly');

        $this->view->form = $form;
        
    }
        
    /*
     * Accion ejecutada para ver y agregar adjuntos delPunto
     */
    public function adjuntoAction() {
        $tipo = $this->getParam('tipo'); 
        $siglas = $this->getParam('siglas');      
        $id = $this->getParam('id');
        $año = $this->getParam('anio');
        $modalidad = $this->getParam('modalidad');   
        $this->view->tipoView = $tipo;
        $this->view->siglasView = $siglas;
        $this->view->idView = $id;       
        $this->view->anioView = $año;
        $this->view->modalidadView = $modalidad;
        
        $indice = $this->getParam('indice');   
        $this->view->indiceView = $indice; 
        
                $form = new Application_Form_AdjuntoPunto();
                $form->setLegend($tipo.' '.$siglas.'/'.$id.'/'.$año);
                  
      //$consultaPunto = Application_Model_Punto::getPunto($siglas, $id, $año, $modalidad);
        //$this->view->idView = $consultaPunto->indice;
        if ( $this->getParam(Application_Form_AdjuntoPunto::E_VOLVER) ) {
            $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
        } else{
            //try {
                
                if (($this->getParam(Application_Form_AdjuntoPunto::E_AGREGAR))){
                    if($form->getElement(Application_Form_AdjuntoPunto::E_BROWSE)->getFileName()){
                        $adjunto = pathinfo($form->getElement(Application_Form_AdjuntoPunto::E_BROWSE)->getFileName());
                        $filename = $adjunto['basename'];
                        Fmo_Logger::debug($filename);
                        $form->setNombreArchivo($filename);                    
                        $form->subirArchivo($indice);
                        $this->addMessageSuccessful($form->getMessageProcess()->getAll());
                    }else{
                    $this->addMessageWarning('Ingrese un archivo');    
                    }
                    
                    }             
            
            //} catch (Exception $ex) {
               // $this->addMessageException($ex);
               // $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
           //}
        }
        $this->view->form = $form;
    }
    
    
    /*
     * Accion ejecutada para modificar el estatus del Punto
     */
    public function estatusAction(){
        
      $indice = $this->getParam('id');   
      $tipo = $this->getParam('tipo');
      $form = new Application_Form_Punto(); 
      $punto = Application_Model_Punto::getPuntoIndice($indice);
      $form->getElement(Application_Form_Punto::E_FECHA)->setLabel('Fecha Procesado:');      
      $form->getElement(Application_Form_Punto::E_ASUNTO)->setLabel('Observaciones procesado:'); 
      $fecha = Fmo_Util::stringToZendDate($punto->fecha_real)->toString('yyyy');      
      $fecha_creacion = $punto->fecha_creacion;
      $form->setLegend($tipo.' '.$punto->siglas.'/'.$punto->id.'/'.$fecha);      
      $form->limpiarRequeridosConsulta();
      
      $form->setDefault(Application_Form_Punto::E_ESTADO,$punto->id_estado);
      if ($this->getParam(Application_Form_Punto::E_CANCELAR)) {
          $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
        } else{
            try {
                
                if ($this->getParam(Application_Form_Resolucion::E_GUARDAR)&& ($form->isValid($this->request->getPost()))) {
                    
                    $estado = Application_Model_Estado::getDatosEstado($this->getParam(Application_Form_Punto::E_ESTADO));                   $descripcion_estado = $estado->descripcion;
                    $this->view->asuntoView = $this->getParam(Application_Form_Punto::E_ASUNTO);
                    $this->view->fechaView  = $this->getParam(Application_Form_Punto::E_FECHA);
                    $asunto = $this->getParam(Application_Form_Punto::E_ASUNTO);
                    $fecha  = $this->getParam(Application_Form_Punto::E_FECHA);
                    $idpunto = $punto->id;
                    Fmo_Logger::debug($descripcion_estado);
                    $estadoActual = Application_Model_Estado::getDatosEstado($punto->id_estado);                   
                    if($descripcion_estado == $estadoActual){
                    $this->addMessageWarning('No puede modificar un punto de cuenta o informacion con mismo estado');
                            
                    }else{
                        if(($descripcion_estado != 'PROCESADA')){
                            $form->modificarEstatusPunto($descripcion_estado,$asunto,$indice,$fecha);
                            $this->addMessageSuccessful('Modificacion de estado exitosa');
                             $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
                           
                        }
                        if(($descripcion_estado == 'PROCESADA') && 
                          (($this->getParam(Application_Form_Punto::E_ASUNTO) == null) || 
                           ($this->getParam(Application_Form_Punto::E_FECHA) == null)) ){
                        //$this->view->asuntoView = $this->getParam(Application_Form_Resolucion::E_ASUNTO);
                        //$this->view->fechaView =  $this->getParam(Application_Form_Resolucion::E_FECHA);      
                        $this->addMessageInformation('Debe ingresar todos los campos para modificar el estado a procesada');
                        }else{
                            $form->modificarEstatusPunto($descripcion_estado,$asunto,$indice,$fecha);
                            $this->addMessageSuccessful('Modificacion de estado exitosa');
                            $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
                           
                        }                        
                    }
                }
            } catch (Exception $ex) {
                //22 ERROR 
                $mensaje = $ex->getCode();
                $this->addMessageException($ex);
               $this->redirect("default/Punto/modificar/indice/{$indice}/tipo/{$tipo}");
                           
        
            }
        }
    $this->view->form = $form;
   }
    
   
    /*
     * Accion ejecutada para eliminar adjuntos del Punto
     */
    public function eliminarAction(){
       
        $form = new Application_Form_Punto();
        $this->view->form = $form;        
        $idadjunto = $this->getParam('id_adjunto');
        $indice = $this->getParam('indice');
        $tipo = $this->getParam('tipo'); 
        $siglas = $this->getParam('siglas');      
        $id = $this->getParam('id');
        $año = $this->getParam('anio');
        $modalidad = $this->getParam('modalidad');  
        $this->view->tipoView = $tipo;
        $this->view->siglasView = $siglas;
        $this->view->idView = $id;        
        $this->view->indiceView = $indice; 
        $this->view->anioView = $año;
        $this->view->modalidadView = $modalidad;
        
        if(!empty($idadjunto)){
        $adjunto = Application_Model_AdjuntoPunto::getAdjuntoPunto($idadjunto);
        $nombre = $adjunto->ruta;
        $this->view->nombreView = $adjunto->nombre;
        $this->view->idAdjuntoView = $idadjunto;
        }
        
            $pConfirmar = $this->getParam('confirmar');
            Fmo_Logger::debug($pConfirmar);
            try {
                if ($pConfirmar == 'S') {
                    
                    $registroAdjunto = Application_Model_DbTable_AdjuntoPunto::findOneById($idadjunto,$adjunto->indice_punto);
                    $mensaje = "El registro del adjunto (Código {$idadjunto}) ha sido eliminado satisfactoriamente.";
                    unlink($nombre)   ;
                    $registroAdjunto->delete();                    
                    $this->addMessageSuccessful($mensaje);
                    $this->redirect("default/Punto/adjunto/siglas/{$siglas}/id/{$id}/anio/{$año}/modalidad/{$modalidad}/indice/{$indice}/tipo/{$tipo}");
           
                } else {
                    if ($pConfirmar == 'N') {
                        $this->addMessageInformation('Ha cancelado la eliminación del adjunto de la resolucion');
                       $this->redirect("default/Punto/adjunto/siglas/{$siglas}/id/{$id}/anio/{$año}/modalidad/{$modalidad}/indice/{$indice}/tipo/{$tipo}");
           }
                }
            } catch (Exception $ex) {
                if ($ex->getCode() == 23503) {
                    $this->addMessageWarning('No puede eliminarse el registro.');
                    $this->redirect("default/Punto/adjunto/siglas/{$siglas}/id/{$id}/anio/{$año}/modalidad/{$modalidad}/indice/{$indice}/tipo/{$tipo}");
            }
            }    
        
    }
    
}
