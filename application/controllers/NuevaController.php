<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NuevaController extends Fmo_Controller_Action_Abstract
{
    /*
     * Ruta por defecto.
     * 
     */

    private $urlDefault = 'default/Nueva/mostrar';
    
    private $urlDefault1 = 'default/Nueva/listar';
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

    public function mostrarAction()
    {
        $form = new Application_Form_Nueva();
        $values = $form->getValues();
        $this->view->form = $form;
        //$this->addMessageSuccessful("prueba");
        if ($this->getParam(Application_Form_Nueva::E_VOLVER)) {
            $this->redirect($this->urlDefault1);
        }
        
        if ($this->getParam(Application_Form_Nueva::E_LIMPIAR)) {
            $this->redirect($this->urlDefault);
        } else {

            try {
           
                if ($this->getRequest()->isPost()) {
                   $post = $this->getRequest()->getPost();
                   $form->setDefaults($post);
                   
                   //if ($form->isValid($post)) {
                        $nombre = $this->getParam(Application_Form_Nueva::E_NOMBRE_HIDDEN);  
                        $nombresuple = $this->getParam(Application_Form_Nueva::E_NOMBSUPLENTE);   
                        $nombresuph = $this->getParam(Application_Form_Nueva::E_NOMBSUP_HIDDEN);
                        $ficha       = $this->getParam(Application_Form_Nueva::E_RESPONSABLE);
                        $sig         = $this->getParam(Application_Form_Nueva::E_SIGLAS);  
                        $cedula      = $this->getParam(Application_Form_Nueva::E_CEDULA);  
                        $fichasuple  = $this->getParam(Application_Form_Nueva::E_FICHASUPLENTE);       
                        
                    if ($form->getValue(Application_Form_Nueva::E_GUARDAR) && $form->isValid($post)) {  
                             $tpgcia = $this->getParam(Application_Form_Nueva::E_TPGCIA) ;
                              //verifica si existe trabajador
                             if ($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE )!= NULL){
                               $trabsuple = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE)); 
                               $suple =  $trabsuple->{Fmo_Model_Personal::CEDULA};//$this->getParam(Application_Form_Nueva::E_CEDSUPLENTE);  
                               //verifica si existe suplente
                                $existesuple = null;
                                 if ($suple != null){
                                     $existesuple = Application_Model_Suplente::getExisteSuplenteSinId($suple); 
                                  }
                               }  
                              $trab = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_RESPONSABLE));   
                              $existetrab = Application_Model_GerenciaGeneralCoordinacion::getExisteCedulaSinId($trab->{Fmo_Model_Personal::CEDULA}); 
                              //veririfca si existe centro de costo
                              if ($tpgcia =='1') { 
                                $costo  = $this->getParam(Application_Form_Nueva::E_CENTRO_COSTO);
                                $existe = Application_Model_GerenciaGeneralCoordinacion::getExisteGerencia($costo);   
                              }
                            
                            
                            if (empty($existe) or ($tpgcia =='2')){
                                if (empty($existetrab)){ 
                                    if (empty($existesuple)) { 
                                           $form->guardarNuevo();
                                           if ($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE )!= NULL){
                                            $form->guardarSuplente(null);
                                           }
                                            $this->addMessageSuccessful('Se guardo exitosamente el registro'); 
                                            $this->redirect($this->urlDefault1);
                                            }else{
                                            $this->addMessageError('El Suplente que intenta Cargar Ya se encuentra Asignado a una Gerencia/Coordinacion!');    
                                            $form->setDefault(Application_Form_Nueva::E_NOMBRE, $nombre);
                                            $form->setDefault(Application_Form_Nueva::E_RESPONSABLE, $ficha);
                                            $form->setDefault(Application_Form_Nueva::E_SIGLAS, $sig); 
                                            $form->setDefault(Application_Form_Nueva::E_CEDULA, $cedula); 
                                            $form->setDefault(Application_Form_Nueva::E_FICHASUPLENTE, $fichasuple);
                                            $form->setDefault(Application_Form_Nueva::E_NOMBSUPLENTE, $nombresuph);
                                             }
                                 }else{   
                                      $this->addMessageError('Responable Ya se encuentra Asignado a una Gerencia!'); 
                                      $form->setDefault(Application_Form_Nueva::E_NOMBRE, $nombre);
                                      $form->setDefault(Application_Form_Nueva::E_RESPONSABLE, $ficha);
                                      $form->setDefault(Application_Form_Nueva::E_SIGLAS, $sig); 
                                      $form->setDefault(Application_Form_Nueva::E_CEDULA, $cedula); 
                                      $form->setDefault(Application_Form_Nueva::E_FICHASUPLENTE, $fichasuple);
                                      $form->setDefault(Application_Form_Nueva::E_NOMBSUPLENTE, $nombresuph);
                                      
                                 }

                              }else{
                                                                     
                                  $this->addMessageError('Gerencia Ya Registrada!');
                                  $form->setDefault(Application_Form_Nueva::E_NOMBRE, $nombre);
                                  $form->setDefault(Application_Form_Nueva::E_RESPONSABLE, $ficha);
                                  $form->setDefault(Application_Form_Nueva::E_SIGLAS, $sig); 
                                  $form->setDefault(Application_Form_Nueva::E_CEDULA, $cedula); 
                                  $form->setDefault(Application_Form_Nueva::E_FICHASUPLENTE, $fichasuple);
                                  $form->setDefault(Application_Form_Nueva::E_NOMBSUPLENTE, $nombresuph); 
                                 
                                   } 
                    } elseif ($form->getValue(Application_Form_Nueva::E_BUSCAR)) {
                        $form->Buscar($this->getParam(Application_Form_Nueva::E_RESPONSABLE),$post);
                        $form->setDefault(Application_Form_Nueva::E_NOMBSUPLENTE, $nombresuple);
                         if ($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE)!= null) { 
                         $trabsuple = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE));   
                         $form->setDefault(Application_Form_Nueva::E_NOMBSUPLENTE,"{$trabsuple->{Fmo_Model_Personal::NOMBRE}} {$trabsuple->{Fmo_Model_Personal::APELLIDO}}"); 
                         $form->setDefault(Application_Form_Nueva::E_CEDSUPLENTE, "{$trabsuple->{Fmo_Model_Personal::CEDULA}}");    
                         }
                        
                    }elseif ($form->getValue(Application_Form_Nueva::E_BUSCASUPLE)) {  
                        $form->buscarSuplente($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE),$post);
                        $form->setDefault(Application_Form_Nueva::E_NOMBRE, $nombre);
                         $trab = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_RESPONSABLE));   
                        $form->setDefault(Application_Form_Nueva::E_NOMBRE,"{$trab ->{Fmo_Model_Personal::NOMBRE}} {$trab ->{Fmo_Model_Personal::APELLIDO}}"); 
               
                } else {
                    $form->setDefaults($this->getAllParams());
                }
                }
            } catch (Exception $ex) { 
                $this->addMessageException($ex);
               // $this->redirect($this->urlDefault1);
            }
        }
    }
    /*Listar*/
     public function listarAction()
    {
        $form = new Application_Form_Nueva();
        $values = $form->getValues();
        $this->view->form = $form;
        try { 
            $tgcia = new Application_Model_DbTable_GerenciaGeneralCoordinacion(); 
            $select = $tgcia->select(); 
            $resultado = $tgcia->getAdapter()->fetchAll($select);
        return $resultado;//$onlySelect ? $select : $resultado;
        } catch (Exception $ex) {
           $resultado = null;
            $this->addMessageException($ex);
        } 
    }
    /*Modificar*/
    public function modificarAction(){
         $form = new Application_Form_Nueva();
         $id = $this->getParam('id');  
        //  Fmo_Logger::debug($id);
        
         $values = $form->getValues();
         $this->view->form = $form;
       
         
        if ($this->getParam(Application_Form_Nueva::E_VOLVER)) { 
            $this->redirect($this->urlDefault1);
        }
        
        if ($this->getRequest()->isPost()) {
                 $ficha       = $this->getParam(Application_Form_Nueva::E_RESPONSABLE);
                 $sig         = $this->getParam(Application_Form_Nueva::E_SIGLAS);  
                 $cedula      = $this->getParam(Application_Form_Nueva::E_CEDULA);  
                 $fichasuple  = $this->getParam(Application_Form_Nueva::E_FICHASUPLENTE); 
                 $nombresupleh = $this->getParam(Application_Form_Nueva::E_NOMBSUP_HIDDEN);  
                 $post  =  $this->getRequest()->getPost();   
                 $form->setDefaults($post); 
                 $form->valoresPorDefecto($id,$post);   
                 $nombre       = $this->getParam(Application_Form_Nueva::E_NOMBRE_HIDDEN);   
                 $nombresupleh = $this->getParam(Application_Form_Nueva::E_NOMBSUP_HIDDEN);  
                 $tpgcia = $this->getParam(Application_Form_Nueva::E_TPGCIA) ;
                 $trab = $this->getParam(Application_Form_Nueva::E_CEDBUS); 
                 
                 if ($trab == NULL) {
                     $trab = $this->getParam(Application_Form_Nueva::E_CEDULA);
                 }  
                   
                   if ($form->getValue(Application_Form_Nueva::E_GUARDAR)) {  
                     if ($form->isValid( $this->getRequest()->getPost())) { 
                         $trab = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_RESPONSABLE));   
                         $existetrab = Application_Model_GerenciaGeneralCoordinacion::getExisteCedula($trab->{Fmo_Model_Personal::CEDULA},$id);    
                           if ($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE )!= NULL){
                               $trabsuple = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE)); 
                               $suple =  $trabsuple->{Fmo_Model_Personal::CEDULA};//$this->getParam(Application_Form_Nueva::E_CEDSUPLENTE);  
                               //verifica si existe suplente
                                $existesuple = null;
                                 if ($suple != null){
                                     $existesuple = Application_Model_Suplente::getExisteSuplenteSinId($suple); 
                                  }
                               }  
                           
                           if (empty($existetrab)){  
                                $form->modificarGcia($id);        
                                ////////////////////////////////
                                 if (empty($existesuple)){  
                                        $suplente    = Application_Model_Suplente::getSuplente($id);  
                                        if (!empty($suplente)){     
                                            Fmo_Logger::debug('SUPLENTE '); 
                                            $form->modificarSuplente($id);       
                                        }else{
                                            if ($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE )!= NULL){
                                                $form->guardarSuplente($id); 
                                            }
                                                 
                                        }
                                     $this->addMessageSuccessful('Se Modifico exitosamente el registro'); 
                                      $this->redirect($this->urlDefault1);
                                }else{
                                   $this->addMessageError('No se Modifico Registro. El Suplente que intenta Cargar Ya se encuentra Asignado a una Gerencia/Coordinacion!');    
                                  }                                  
                              
                              }else{   
                                     $this->addMessageError('No se Modifico Registro. Responsable Ya se encuentra Asignado a una Gerencia!');  
                                    
                              }     
                        
                        }
                    } elseif ($this->getParam(Application_Form_Nueva::E_BUSCAR)) {
                        
                        $cedubusc    = $this->getParam(Application_Form_Nueva::E_CEDBUS);  
                        $form->Buscar($ficha,$post); 
                         if ($this->getParam(Application_Form_Nueva::E_CEDULA)!= null) { 
                         $trabajador = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE));   
                         $form->setDefault(Application_Form_Nueva::E_NOMBSUPLENTE,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}"); 
                         $form->setDefault(Application_Form_Nueva::E_CEDSUPLENTE, "{$trabajador->{Fmo_Model_Personal::CEDULA}}");    
                         }
                     
                    }elseif ($this->getParam(Application_Form_Nueva::E_BUSCASUPLE)) { 
                        $this->getValue(Application_Form_Nueva::E_FICHASUPLENTE);  
                        $form->buscarSuplente($this->getParam(Application_Form_Nueva::E_FICHASUPLENTE),$post);  
                        $trabajador = Fmo_Model_Personal::findOneByFicha($this->getParam(Application_Form_Nueva::E_RESPONSABLE));   
                        $form->setDefault(Application_Form_Nueva::E_NOMBRE,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}"); 
                     
                       
                    }
                 
                        
        } else {
            // solo cuando entra vez
            // los valores por defecto
            $post  =  $this->getRequest()->getPost();   
            $form->setDefaults($post); 
            $form->valoresPorDefecto($id,$post); 
        }
        }
        
  
}
