<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_Nueva extends Fmo_Form_Abstract
{
    const E_DESCRIPCION     =  'ceco_descri';
    const E_CENTRO_COSTO    = 'ceco_ceco';
    const E_SIGLAS          = 'sigla';
    const E_RESPONSABLE     = 'responsable';
    const E_FICHA           = 'ficha';
    const E_BUSCAR          = 'buscar'; 
    const E_FICHA_HIDDEN    = 'ficha_hidden';
    const E_NOMBRE          = 'nombre';
    const E_NOMBRE_HIDDEN   = 'nombreh';
    const E_CEDULA          = 'cedulas';
    const E_GUARDAR         = 'guardar';
    const E_TPGCIA          = 'gcia'; 
    const E_COORD           = 'coordinacion';
    const E_LIMPIAR         = 'limpiar';    
    const E_VOLVER          = 'volver';
    const E_GCIAGRAL        = 'gga_costo';
    const E_MODGCIA_HIDDEN  = 'tgcia';
    const E_CEDSUPLENTE     = 'suplecedula';
    const E_NOMBSUPLENTE    = 'nomsuplente';
    const E_NOMBSUP_HIDDEN  = 'nomsuplenteh';
    const E_FICHASUPLENTE   = 'fichasuplente';
    const E_BUSCASUPLE      = 'bsuplente';
    const E_TIPOGCIA          = 'tpgcia';
    const E_CEDBUS          = 'cedu';
    const E_GCIA_HIDDEN     = 'gciah';  
    
    public function init()
    {
          $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
        $this->setAction($this->getView()->url());
        
        if (stripos($this->getAction(), 'modificar') !== false) { 
             $paramId = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', '0'); 
             $consulta   = Application_Model_GerenciaGeneralCoordinacion::getDatosGerencia($paramId); 
             $valor      = $consulta->tipo_gerencia ;
               if ($valor == 1){
                   $desc = 'Gerencia';
               }else{
                   $desc = 'Coordinación';
               }  
               $bus = new Zend_Form_Element_Radio(self::E_TPGCIA);
               $bus->setLabel('TIPO GERENCIA:')
                        ->setRequired() 
                          ->addMultiOption($consulta->tipo_gerencia, $desc) 
                        ->setDecorators($this->_decoratorElement);
                $this->addElement($bus); 
           
        } else {
            //radio para seleccionar el tipo si es Gerencia o Coordinacion. 
            $bus = new Zend_Form_Element_Radio(self::E_TPGCIA);
            $bus->setLabel('TIPO GERENCIA:')
                    ->setRequired()
                    ->setAttrib('onchange', 'this.form.submit();')
                    ->addMultiOption('1', 'Gerencia')
                    ->addMultiOption('2', 'Coordinación')
                    ->setDecorators($this->_decoratorElement);
            $this->addElement($bus);
            $this->setDefault(self::E_TPGCIA,'1');  
            
            Fmo_Logger::debug('Nuevo ' . $this->getAction());
        }
        
        //Combobox para seleccionar el tipo de documento del centro de costo.
        $comboboxCentrocosto = new Zend_Form_Element_Select(self::E_CENTRO_COSTO);
        $comboboxCentrocosto->setLabel('CENTRO DE COSTO:')
                ->setRequired(false)
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_CentroCosto::getCentroCosto())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxCentrocosto); 
      //id de la gerencia
         $idgcia= new Zend_Form_Element_Hidden(self::E_TIPOGCIA);
        $idgcia->setLabel('IDG');
        $this->addElement($idgcia);  
      
     //Crear un textitem
        $sigla = new Zend_Form_Element_Text(self::E_SIGLAS);
        $sigla->setLabel('SIGLAS')
              ->setAttrib('size', '5')
              ->setAttrib('maxlength', '5')
              ->addValidator('StringLength', false, array('min' => 1, 'max' => 5))
              ->addFilter('StringToUpper') 
              ->setRequired(true);
        $this->addElement($sigla);   
     //Item responsable
        $responsable =  new Zend_Form_Element_Text(self::E_RESPONSABLE);
        $responsable->setLabel('RESPONSABLE')
                     ->setAttrib('size', '5')
                    ->setRequired(true);
        $this->addElement($responsable);
        //
        $nombre= new Zend_Form_Element_Note(self::E_NOMBRE);
        $nombre->setLabel('NOMBRE');
        $this->addElement($nombre);
        $nombrehidden= new Zend_Form_Element_Hidden(self::E_NOMBRE_HIDDEN);
        $nombrehidden->setLabel('NOMBREH');
        $this->addElement($nombrehidden);
        //
        $cedula= new Zend_Form_Element_Hidden(self::E_CEDULA); 
        $cedula->setLabel('CEDULA');
        $this->addElement($cedula);
        $cedulab= new Zend_Form_Element_Hidden(self::E_CEDBUS); 
        $cedulab->setLabel('CEDUB');
        $this->addElement($cedulab);
        //
        $ggral = new Zend_Form_Element_Note(self::E_GCIAGRAL);
        $ggral->setLabel('GERENCIA:');
        $this->addElement($ggral);
        $ggralhid = new Zend_Form_Element_Hidden(self::E_GCIA_HIDDEN);
        $ggralhid->setLabel('GE:');
        $this->addElement($ggralhid);
        //
        //
        $nomsupl = new Zend_Form_Element_Note(self::E_NOMBSUPLENTE);
        $nomsupl->setLabel('NOMBRE SUPLENTE:');
        $this->addElement($nomsupl);
        $nomsuplh = new Zend_Form_Element_Hidden(self::E_NOMBSUP_HIDDEN);
        $nomsuplh->setLabel('NOMBRESH:');
        $this->addElement($nomsuplh); 
        //
        $cedsupl =  new Zend_Form_Element_Hidden(self::E_CEDSUPLENTE);
        $cedsupl->setLabel('CEDSUPLENTE:') ;
        $this->addElement($cedsupl);
        //E_FICHASUPLENTE
        $fichasupl =  new Zend_Form_Element_Text(self::E_FICHASUPLENTE);
        $fichasupl->setLabel('SUPLENTE:')
                  ->setAttrib('size', '5') ;
        $this->addElement($fichasupl);
        //
        $gciahiden= new Zend_Form_Element_Hidden(self::E_MODGCIA_HIDDEN); 
        $gciahiden->setLabel('Tipo Gerencia');
        $this->addElement($gciahiden);
       // Botones del formulario.
        $this->addElement('submit', 'buscar', array('label' => 'Buscar')); 
       //boton submit para enviar valores a buscar
        $this->addElement('submit', 'limpiar', array('label' => 'Limpiar')); 
        $this->addElement('submit', 'enviar', array('label' => 'Enviar'));
        $guardar = new Zend_Form_Element_Submit(self::E_GUARDAR);
        $guardar->setLabel('Guardar')
                ->setIgnore(true);
        $this->addElement($guardar);   
        //
        $volver = new Zend_Form_Element_Submit(self::E_VOLVER);
        $volver->setLabel('Volver')
                ->setIgnore(true);
        $this->addElement($volver);  
        //
        $bsuple = new Zend_Form_Element_Submit(self::E_BUSCASUPLE);
        $bsuple->setLabel('Suplente')
                ->setIgnore(true);
        $this->addElement($bsuple);
    }   
     /* ****************************
     * Método que permite editar.
     *******************************/   
   public function modificarGcia($id) {
        $registro   = Application_Model_DbTable_GerenciaGeneralCoordinacion::findOneById($id); 
                   
        $nrotrab    = $this->getValue(self::E_RESPONSABLE);  
        
        $trabajador = Fmo_Model_Personal::findOneByFicha($nrotrab); 
        
        $usuario    = $trabajador->{Fmo_Model_Personal::SIGLADO}; 
        $descri     = NULL; 
        $cedu       = $this->getValue(self::E_CEDBUS);//$this->getValue(self::E_CEDULA);//
         if ($usuario== null){
             $usuario = 'N/A';
         }  
        if (!$registro) {
            throw new Exception('No puede modificar este registro');
        }else{ 
            if ($this->getValue(self::E_TPGCIA) == 2) {  
                 $descri = $this->getValue(self::E_COORD);  
                 $registro->descripcion        = $descri; 
            }                   
            }    
         if ($cedu== null){
             $cedu = $trabajador->{Fmo_Model_Personal::CEDULA}; 
         }
            $registro->cedula             = $cedu;//$this->getValue(self::E_CEDBUS);
            $registro->siglas             = $this->getValue(self::E_SIGLAS);  
            $registro->usuario_responsable= $usuario;  
            $registro->save();     
   }
   /***************************
     * Metodo para modificar suplente
     ***************************/
   public function modificarSuplente($id){  
   
    $suplente    = Application_Model_DbTable_Suplente::findOneById($id);  
    $nrotrab     = $this->getValue(self::E_FICHASUPLENTE);  
    $trabajador  = Fmo_Model_Personal::findOneByFicha($nrotrab); 
    $usuario     = $trabajador->{Fmo_Model_Personal::SIGLADO}; 
     if ($usuario== null){
             $usuario = 'N/A';
         }          
       //Modifica suplente     
        $suplente->cedula         = $trabajador->{Fmo_Model_Personal::CEDULA};
        $suplente->usuario        = $usuario;     
        $suplente->save(); 
     } 
    /***************************
     * Metodo para guardar suplente
     ***************************/
   public function guardarSuplente($id_gcia){
    $ultregistro = new Application_Model_DbTable_GerenciaGeneralCoordinacion();     
    $suplente    = new Application_Model_DbTable_Suplente();
    
    $nrotrab     = $this->getValue(self::E_FICHASUPLENTE); 
    $trabajador  = Fmo_Model_Personal::findOneByFicha($nrotrab);     
    $usuario     = $trabajador->{Fmo_Model_Personal::SIGLADO};
     if ($usuario== null){
             $usuario = 'N/A';
         }
      if ($id_gcia == NULL) {//Guarda un registro desde el boton guardar  
    //Busca el ultimo ID inggresado en la tabla gerencia
       $idr = Application_Model_GerenciaGeneralCoordinacion::getUltReg();
       $id = $idr->a; 
      }else{//Guarda un nuevo registro desde Modificar
        $id = $id_gcia;  
      }
    //Guarda suplente     
        $registro                 = $suplente->createRow(); 
        $registro->cedula         =  $trabajador->{Fmo_Model_Personal::CEDULA};//$this->getValue(self::E_CEDSUPLENTE);
        $registro->id_gga         = (int) $id ;
        $registro->usuario        = $usuario; 
        $registro->fecha_creacion = date("d-m-Y H:i");      
        $registro->save();
    }
    /***************************
     * Metodo para guardar Gerencia o coordinacion
     ***************************/
   public function guardarNuevo(){ 
         $ggral      = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
         $nrotrab    = $this->getValue(self::E_RESPONSABLE); 
         $tpgcia     = $this->getValue(self::E_TPGCIA);
         $gggral     = null;
         $ggcosto    = null; 
         $trabajador = Fmo_Model_Personal::findOneByFicha($nrotrab); 
         $usuario    = $trabajador->{Fmo_Model_Personal::SIGLADO};    
         if ($usuario== null){
             $usuario = 'N/A';
         }
             
             
         if ($tpgcia == 2) {
             $descri= trim($this->getValue(self::E_COORD));
         } else{
             $descri  = $this->getElement(self::E_CENTRO_COSTO)->getMultiOption($this->getValue(self::E_CENTRO_COSTO));
             $ggcosto = trim($this->getValue(self::E_CENTRO_COSTO));
             $gggral  = substr($this->getValue(self::E_CENTRO_COSTO),-5,2);
         }
        //Guarda Gerencia o Coordinacion      
        $registro                     = $ggral->createRow(); 
        $idnew                        = $registro->id;
        $registro->gga_ggral          = $gggral;
        $registro->gga_costo          = $ggcosto ;
        $registro->descripcion        = $descri; 
        $registro->cedula             = $trabajador->{Fmo_Model_Personal::CEDULA};//$this->getValue(self::E_CEDULA);
        $registro->siglas             = $this->getValue(self::E_SIGLAS);  
        $registro->usuario_responsable= $usuario;
        $registro->tipo_gerencia      = $this->getValue(self::E_TPGCIA); 
        $registro->save();
         
         Fmo_Logger::debug($registro->toArray());
     }
      /***************************
     * Metodos para procesar
     ***************************/ 
     public function buscarSuplente($ficha, $defaults){
          parent::setDefaults($defaults);    
         $trabajador = Fmo_Model_Personal::findOneByFicha($ficha);  
            if ($trabajador) :                
              if($trabajador->{Fmo_Model_Personal::ACTIVIDAD} != 'RETIRADO'){
                $this->setDefault(self::E_NOMBSUPLENTE,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");                
                $this->setDefault(self::E_CEDSUPLENTE, "{$trabajador->{Fmo_Model_Personal::CEDULA}}");    
                $this->setDefault(self::E_NOMBSUP_HIDDEN,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");                
                }else{  
                 $this->getElement(self::E_FICHASUPLENTE)->
                        addError('El Trabajador se encuentra '.$trabajador->{Fmo_Model_Personal::ACTIVIDAD}.' no lo puede agregar');        
                }
            else : 
              $this->getElement(self::E_FICHASUPLENTE)->addError('Ficha no existe');
            endif;
           // }   
       parent::setDefaults($defaults);      
     }     
    /***************************
     * Metodos para procesar
     ***************************/ 
     public function buscar($ficha,$defaults){
        
         $trabajador = Fmo_Model_Personal::findOneByFicha($ficha);  
         
          parent::setDefaults($defaults);     
            if ($trabajador) :     
              if($trabajador->{Fmo_Model_Personal::ACTIVIDAD} != 'RETIRADO'){ 
                 
                $this->setDefault(self::E_NOMBRE,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");                
                $this->setDefault(self::E_CEDULA, "{$trabajador->{Fmo_Model_Personal::CEDULA}}"); //E_CEDBUS
                 $this->setDefault(self::E_CEDBUS, "{$trabajador->{Fmo_Model_Personal::CEDULA}}"); //
                 $this->setDefault(self::E_NOMBRE_HIDDEN, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                
                }else{  
                 $this->getElement(self::E_RESPONSABLE)->
                        addError('El Trabajador se encuentra '.$trabajador->{Fmo_Model_Personal::ACTIVIDAD}.' no lo puede agregar');        
                }
            else : 
              $this->getElement(self::E_RESPONSABLE)->addError('Ficha no existe');
            endif;
         parent::setDefaults($defaults); 
     }   
            
    // }   
     /**/
     public function atribModifica(array $defaults)
          {
        parent::setDefaults($defaults); 
            //Descripcion de la Ggral
            $coord = new Zend_Form_Element_Note(self::E_DESCRIGCIA);
            $coord->setLabel('Tipo Gerencia:');
            $this->addElement($coord); 
            parent::setDefaults($defaults); 
         
        return $this; 
    }   
    /*set default*/         
    public function setDefaults(array $defaults)
    {
        parent::setDefaults($defaults);
        if ($this->getValue(self::E_TPGCIA) == '2') {
            //Coordinacion
            $coord = new Zend_Form_Element_Text(self::E_COORD);
            $coord->setLabel('COORDINACION')  
                  ->setAttrib('size', '30')
                  ->setRequired(true)  
                  //->setAttrib('style', 'text-align: left; width:97%;')
                  ->setAttrib('maxlength', '100')      
                  ->addFilter('StringToUpper')               
                  ->addValidator('StringLength', true)
                  ->addValidator('StringLength', false, array('min' => '1', 'max' => '100', 'encoding' => $this->getView()->getEncoding()))
                  ->addFilter('StringTrim');
            $this->addElement($coord);
            parent::setDefaults($defaults);
        }  
         
        return $this; 
    }
     
     /**************************
      * Metodo para asignar valores
      ***************************/
    public function valoresPorDefecto($id,$post){
    $consulta   = Application_Model_GerenciaGeneralCoordinacion::getDatosGerencia($id); 
    $trabajador = Fmo_Model_Personal::findOneByCedula($consulta->cedula);       
    $tsuplente  = Application_Model_Suplente::getSuplente($id);
    $cedusuple  = null;
    $nombresup  = NULL;
    $nombresuph = null;
    $fichasup   = null;
     if (!empty($tsuplente)){
        $cedusuple  = $tsuplente->cedula;
        $datosuple  = Fmo_Model_Personal::findOneByCedula($tsuplente->cedula);       
        $nombresup  = "{$datosuple->{Fmo_Model_Personal::NOMBRE}} {$datosuple->{Fmo_Model_Personal::APELLIDO}}";
        $nombresuph = "{$datosuple->{Fmo_Model_Personal::NOMBRE}} {$datosuple->{Fmo_Model_Personal::APELLIDO}}";
        $fichasup   = "{$datosuple->{Fmo_Model_Personal::FICHA}}";
     }  
    
    $this->setDefault(self::E_TPGCIA, $consulta->tipo_gerencia);  
     $this->setDefault(self::E_TIPOGCIA,$consulta->tipo_gerencia);
    if ($this->getValue(self::E_TPGCIA) == 2) {   
     //if ($consulta->tipo_gerencia == 2) {
            $this->setDefaults($post);
            $this->setDefault(self::E_COORD, $consulta->descripcion); 
       }  else{
           $this->setDefault(self::E_GCIAGRAL, $consulta->descripcion);
           $this->setDefault(self::E_GCIA_HIDDEN, $consulta->descripcion);
       } 
    $this->setDefault(self::E_RESPONSABLE, "{$trabajador->{Fmo_Model_Personal::FICHA}}") 
         ->setDefault(self::E_NOMBRE,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}")
         ->setDefault(self::E_NOMBRE_HIDDEN,"{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}")
         ->setDefault(self::E_SIGLAS,$consulta->siglas)  
         ->setDefault(self::E_CEDULA,$consulta->cedula)  
         ->setDefault(self::E_CEDSUPLENTE, $cedusuple)
         ->setDefault(self::E_NOMBSUPLENTE,$nombresup)
         ->setDefault(self::E_NOMBSUP_HIDDEN,$nombresuph)
         ->setDefault(self::E_FICHASUPLENTE,$fichasup); 
    }    
          
  }