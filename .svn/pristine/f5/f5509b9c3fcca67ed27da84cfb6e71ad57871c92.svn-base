<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of miembro
 *
 * @author manuelry
 */
class Application_Form_Miembro extends Fmo_Form_Abstract {

    const E_CARGO  = 'cargo';
    const E_CEDULA = 'cedula'; 
    const E_FICHA  = 'ficha';
    const E_FECHA  = 'fecha';    
    const E_FECHA_JUNTA = 'fecha_jun';
    const E_NOMBRE = 'nombre_miembro';
    const E_CEDULA_MIEMBRO = 'miembro_cedula';
    
    const E_MODIFICAR = 'modificar';    
    const E_AGREGAR = 'agregar';
    const E_BUSCAR  = 'buscar'; 
    const E_GUARDAR = 'guardar';
    const E_CANCELAR = 'cancelar';
    
       
    /*
     * Método de creación del formulario.
     */
    public function init() 
    {
        $this->getView()->jQuery()->enable();
        $this->getView()->jQuery()->uiEnable();
        $this->getView()->headScript()->appendFile($this->getView()->baseUrl('public/js/acordeon.js'));
        $this->getView()->headLink()->appendStylesheet($this->getView()->baseUrl('public/css/style.css'));
        
    
        // Combobox para seleccionar el cargo del miembro.
        $comboboxCargo = new Zend_Form_Element_Select(self::E_CARGO);
        $comboboxCargo->setLabel('Cargo:')
                ->setRequired()
                ->addMultiOption('', 'Seleccione')
                ->addMultiOptions(Application_Model_Cargo::getCargosCombo())
                ->setDecorators($this->_decoratorElement);
        $this->addElement($comboboxCargo);
                
        // Campo de texto para ingresar el número de ficha del miembro.
        $campoFicha = new Zend_Form_Element_Text(self::E_FICHA);
        $campoFicha->setLabel('Ficha:')
                    ->addValidator('Int', true)
                    ->setRequired()
                    
                    ->addValidator('digits', true)
                    ->addValidator('stringLength', false, array(4, 5));
        $this->addElement($campoFicha);
        
        // Campo de texto para guardar fecha_junta 
        $campoFec = new Zend_Form_Element_Text(self::E_FECHA_JUNTA);
        $campoFec->setLabel('Fecha:');
                    
        $this->addElement($campoFec);
                  
        // Campo de texto para ingresar la cedula del miembro.
        $campoCedula = new Zend_Form_Element_Note(self::E_CEDULA);
        $campoCedula->setLabel('Cedula:')
                ->addValidator('Int', true)
                ->setRequired();
        $this->addElement($campoCedula);
        
           // Campo de texto para ingresar la cedula del miembro.
        $campoCedula1 = new Zend_Form_Element_Note(self::E_CEDULA_MIEMBRO);
        $campoCedula1->setLabel('Cedula:')
                ->addValidator('Int', true);
        $this->addElement($campoCedula1);
        
        
          // Campo de texto para ingresar el nombre del miembro.
        $campoNombre = new Zend_Form_Element_Note(self::E_NOMBRE);
        $campoNombre->setLabel('Nombre:')
                ->setRequired();
                $this->addElement($campoNombre);
        
          // Campo fecha del periodo de junta directiva  
        $fecha = new Fmo_Form_Element_DatePicker(self::E_FECHA);
        $fecha->setLabel('Fecha-JD:')
              ->setDescription('Formato de Fecha: DD/MM/AAAA')
              ->setRequired();
        $valDbw2 = new Fmo_Validate_DateBetween(array('format' => $fecha->getValidator('Date')->getFormat()));
        $hoy = new Zend_Date();
        $valDbw2->setMin($valDbw2->getMinDate()->subyear(50));
        $valDbw2->setMax($hoy);

        $scrip2 = 'Calendar.setup( { '
                . "inputField : '{$fecha->getName()}', "
                . "trigger: 'img-{$fecha->getName()}', "
                . "ifFormat: '%d/%m/%Y', "
                . "dateFormat: '%d/%m/%Y', "
                . 'onSelect: function() { this.hide(); }, '
                //. "min: {$valDbw2->getMinDate()->toString('yyyyMMdd')}, "
                . "max: {$valDbw2->getMaxDate()->toString('yyyyMMdd')} "
                . '} );';
        $fecha->setCalendarScript($scrip2)->addValidator($valDbw2);
        
        $this->addElement($fecha);
        $this->_decoratorElementDatePicker[0][1]['viewScript'] = 'dp.phtml';                           
       
        // Botones del formulario.
        $guardar = new Zend_Form_Element_Submit(self::E_GUARDAR);
        $guardar->setLabel('Guardar')
                ->setIgnore(true);
    $this->addElement($guardar);
    
     // Botones del formulario.
        $agregar = new Zend_Form_Element_Submit(self::E_AGREGAR);
        $agregar->setLabel('Agregar')
                ->setIgnore(true);
        $this->addElement($agregar);
        
     // Botones del formulario.
        $cancelar = new Zend_Form_Element_Submit(self::E_CANCELAR);
        $cancelar->setLabel('Cancelar')
                ->setIgnore(true);
        $this->addElement($cancelar);
        
            
    // Botones del formulario.
        $buscar = new Zend_Form_Element_Submit(self::E_BUSCAR);
        $buscar->setLabel('Buscar')
                ->setAttrib('onchange', 'form.submit();')
                ->setIgnore(true);
        $this->addElement($buscar);
        
    // Botones del formulario.
        $modificar = new Zend_Form_Element_Submit(self::E_MODIFICAR);
        $modificar->setLabel('Modificar')
                ->setIgnore(true);
        $this->addElement($modificar);
        
        $this->setCustomDecorators();
        
        
    }
     /* 
     * Método que permite guardar un nuevo miembro de la junta directiva actual.
     */
    public function guardarNuevo($fecha,$cedulaMiembro,$nombreMiembro) {
        
        $tMiembro = new Application_Model_DbTable_Miembros();  
        $registro = $tMiembro->createRow();
        
        $registro->cedula = $cedulaMiembro;
        $registro->id_cargo = $this->getValue(self::E_CARGO);
        $registro->nombre = $nombreMiembro;
        $registro->ficha = $this->getValue(self::E_FICHA);
        //$registro->fecha_inicio_miembro = $fecha;
        $registro->fecha_periodo = $fecha;
        $registro->m_vigencia_jd = '1';        
        $registro->save();
       
        
        $juntaAnterior = Application_Model_Miembros::getMiembrosActuales();
        $fecha_dos = Fmo_Util::stringToZendDate($fecha)->toString('yyyy-MM-dd');
        foreach ($juntaAnterior as $juntaAnterior){
            if($juntaAnterior->fecha_periodo < $fecha_dos){
                Fmo_Logger::debug('entro');
            $registro1 = Application_Model_DbTable_Miembros::findOneById($juntaAnterior->cedula,$juntaAnterior->fecha_periodo,$juntaAnterior->id_cargo);
                    Fmo_Logger::debug($registro1);
                    if (!$registro1) {
                        throw new Exception('No puede modificar este registro');
                    }else{
                        //$registro->fecha_fin_miembro = Zend_Date::now()->toString('yyyy-MM-dd');     
                        $registro->fecha_periodo = Zend_Date::now()->toString('yyyy-MM-dd');     
                        $registro1->m_vigencia_jd = 0;                         
                        $registro1->save();
                    }
            }
        }
        
        
   }
   /* 
     * Método que permite cambiar un miembro de la junta directiva actual.
     */   
    public function modificarMiembro($cargo,$cedulaMiembro,$nombreMiembro) {
        
        // DE ESTA MANERA CUANDO MODIFICA DUPLICANDO LA JUNTA DIRECTIVA CON EL NUEVO MIEMBRO
    //$tMiembro = Application_Model_Miembros::getMiembrosActuales();
        //foreach ($tMiembro as  $tMiembronuevo):
           /* Fmo_Logger::debug($tMiembronuevo->fecha_periodo);
                $fecha_f = new Zend_Date($this->getValue(self::E_FECHA));
                $formato =  $fecha_f->toString('yyyy-MM-dd');
                Fmo_Logger::debug($formato.'   '.$tMiembronuevo->fecha_periodo);
           
            if($formato != $tMiembronuevo->fecha_periodo){
                Fmo_Logger::debug('$tMiembronuevo->fecha_periodo');
            
            
            $tMiembros = new Application_Model_DbTable_Miembros();  
            $registro = $tMiembros->createRow();
                if ($tMiembronuevo->ficha == $ficha) {        
                $registro->cedula = $cedulaMiembro;
                $registro->id_cargo = $tMiembronuevo->id_cargo;
                $registro->nombre = $nombreMiembro;
                $registro->ficha = $this->getValue(self::E_FICHA);
                $registro->fecha_periodo = $this->getValue(self::E_FECHA);
                $registro->m_vigencia_jd = '1';        
                $registro->save();
                }else{
                $registro->cedula = $tMiembronuevo->cedula;
                $registro->id_cargo = $tMiembronuevo->id_cargo;
                $registro->nombre = $tMiembronuevo->nombre;
                $registro->ficha = $tMiembronuevo->ficha;
                $registro->fecha_periodo = $this->getValue(self::E_FECHA);
                $registro->m_vigencia_jd = '1';        
                $registro->save();
                }
            }else{*/
                 
                $fecha_f = Fmo_Util::stringToZendDate($this->getValue(self::E_FECHA_JUNTA))->toString('yyyy-MM-dd');
                Fmo_Logger::debug($fecha_f.' sdasd'.$this->getValue(self::E_CEDULA_MIEMBRO).$cargo);
                $registro = Application_Model_DbTable_Miembros::findOneById($this->getValue(self::E_CEDULA_MIEMBRO),$fecha_f,$cargo);
                Fmo_Logger::debug($registro);
                if (!$registro) {
                    throw new Exception('No puede modificar este registro');
                }else{
                    $registro->m_vigencia_jd = '0';
                    
                    //$registro->fecha_fin_miembro = Zend_Date::now()->toString('yyyy-MM-dd');
                    $registro->fecha_periodo = Zend_Date::now()->toString('yyyy-MM-dd');
                    $registro->save();
                    
                    $tMiembro = new Application_Model_DbTable_Miembros();  
                    $registro2 = $tMiembro->createRow();

                    $registro2->cedula = $cedulaMiembro;
                    $registro2->id_cargo = $cargo;
                    $registro2->nombre = $nombreMiembro;
                    $registro2->ficha = $this->getValue(self::E_FICHA);
                    $registro2->fecha_periodo = $this->getValue(self::E_FECHA);
                    $registro2->fecha_periodo = $this->getValue(self::E_FECHA_JUNTA);
                    $registro2->m_vigencia_jd = '1';   //Aquí     
                    $registro2->save(); 
                    }
                
            
         //endforeach;
         
        
   }
   
   public function valoresPorDefecto($ficha, $cedula,$nombre,$cargo,$fecha)
    {
            $fecha_f = new Zend_Date($fecha);
                
            $formato =  $fecha_f->toString('dd/MM/yyyy');
            $this->setDefault(self::E_FICHA, $ficha)                               
             ->setDefault(self::E_FECHA, $formato)
             ->setDefault(self::E_CEDULA, $cedula)
             ->setDefault(self::E_NOMBRE, $nombre)            
             ->setDefault(self::E_CARGO, $cargo)
            ->setDefault(self::E_CEDULA_MIEMBRO,$cedula);
             
    }
      
   
  public function proceso(array $data){
        $this->setDefaults($data);
        $cargo = $this->getValue(self::E_CARGO); 
        $fecha = $this->getValue(self::E_FECHA); 
        $trabajador = Fmo_Model_Personal::findOneByFicha($this->getValue(self::E_FICHA));
        $descri  = $this->getElement(self::E_CARGO)->getMultiOption($this->getValue(self::E_CARGO));
        
        if ($this->getValue(self::E_MODIFICAR)) {
            if(!empty($trabajador)){
            Fmo_Logger::debug('modificar');
            //Fmo_Logger::debug($this->getValue(self::E_CEDULA_MIEMBRO));
           // Fmo_Logger::debug($trabajador->{Fmo_Model_Personal::CEDULA});
            if($this->getValue(self::E_CEDULA_MIEMBRO) != $trabajador->{Fmo_Model_Personal::CEDULA}){
          Fmo_Logger::debug('distinto');
                $this->modificarMiembro($cargo,$trabajador->{Fmo_Model_Personal::CEDULA}, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
             }else{
            $this->getElement(self::E_FICHA)->addError('Ingrese otra ficha es la misma a modificar');      
                  
            } 
         }else{
        $this->getElement(self::E_FICHA)->addError('No puede guardar sin encontrar miembro');    

        }
        
        }
        if ($this->getValue(self::E_BUSCAR)&& ($this->isValid($data))) {
            // Fmo_Logger::debug($trabajador->{Fmo_Model_Personal::ACTIVIDAD});
             
                if(!empty($trabajador)){

                 Fmo_Logger::debug('existe');
                    if($trabajador->{Fmo_Model_Personal::ACTIVIDAD} != 'RETIRADO'){ 
                        if ($trabajador) {
                            $this->setDefault(self::E_NOMBRE, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                            $this->setDefault(self::E_CEDULA, "{$trabajador->{Fmo_Model_Personal::CEDULA}}");
                            return false;

                            } else {
                            $this->getElement(self::E_FICHA)->addError('Ficha no existe');
                        }
                    }else{
                    $this->getElement(self::E_FICHA)->addError('El Trabajador se encuentra '.$trabajador->{Fmo_Model_Personal::ACTIVIDAD}.' no lo puede agregar');    
                    }
                }else{
                $this->getElement(self::E_FICHA)->addError('Ficha no existe');    

                }
                 
                
        }
        
        
        if (($this->getValue(self::E_GUARDAR)) && ($this->isValid($data))) {
            
            if(!empty($trabajador)){
                if($trabajador->{Fmo_Model_Personal::ACTIVIDAD} != 'RETIRADO'){ 
                $presidente = Application_Model_Cargo::getDescriCargoDB(6);    
                
                   if( $descri == $presidente){
                       if (Application_Model_Miembros::validarPresidente($fecha,$cargo)){
                           $this->getElement(self::E_CARGO)->addError('No pueden existir dos (2) Presidentes en la Junta Directiva en un mismo período');                    
                       }else{
                           $this->guardarNuevo($fecha,$trabajador->{Fmo_Model_Personal::CEDULA}, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");     
                           $this->getMessageProcess()->add('Se agregó el nuevo miembro');   

                           }
                   }else{

                   $this->guardarNuevo($fecha,$trabajador->{Fmo_Model_Personal::CEDULA}, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                   $this->getMessageProcess()->add('Se agregó el nuevo miembro'); 

                   } 
               }else{
               $this->getElement(self::E_FICHA)->addError('El Trabajador se encuentra '.$trabajador->{Fmo_Model_Personal::ACTIVIDAD}.' no lo puede agregar');    
               }
            }else{
            $this->getElement(self::E_FICHA)->addError('No puede guardar sin encontrar miembro');    
    
            }
        }
        
        if (($this->getValue(self::E_AGREGAR)) && ($this->isValid($data))) {
            
       if(!empty($trabajador)){
            if($trabajador->{Fmo_Model_Personal::ACTIVIDAD} != 'RETIRADO'){
                $presidente = Application_Model_Cargo::getDescriCargoDB(6);    
                
                  if( $descri == $presidente){
                   
                    if (Application_Model_Miembros::validarPresidente($fecha,$cargo)){
                        $this->getElement(self::E_CARGO)->addError('No pueden existir dos (2) Presidentes en la Junta Directiva en un mismo período');                    
                    }else{
                        $this->guardarNuevo($fecha,$trabajador->{Fmo_Model_Personal::CEDULA}, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");     
                        $this->getMessageProcess()->add('Se agregó el nuevo miembro');   

                        }
                }else{

                $this->guardarNuevo($fecha,$trabajador->{Fmo_Model_Personal::CEDULA}, "{$trabajador->{Fmo_Model_Personal::NOMBRE}} {$trabajador->{Fmo_Model_Personal::APELLIDO}}");
                $this->getMessageProcess()->add('Se agregó el nuevo miembro'); 

                } 
               }else{
            $this->getElement(self::E_FICHA)->addError('El Trabajador se encuentra '.$trabajador->{Fmo_Model_Personal::ACTIVIDAD}.' no lo puede agregar');    
            } 
        }else{
        $this->getElement(self::E_FICHA)->addError('No puede guardar sin encontrar miembro');    

        }
        }
        
                  
        
    return !$this->hasErrors();
   }
   
}