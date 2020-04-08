<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calendario
 *
 * @author Rafael Rodríguez - F8741 <rafaelars@ferrominera.com>
 */




class Application_Model_Calendario extends Fmo_Calendario
{
    
    protected $reuniones = null;    
    protected $urlEditar = null;      
    protected $urlDetalle = null;       
    protected $consulta = null; 
    
    public function addElementoImg(Zend_Date $fecha, $imgSrc, $titulo)
    {
         
                
        $this->elemento[$fecha->get(Zend_Date::YEAR)][$fecha->get(Zend_Date::MONTH)][$fecha->get(Zend_Date::DAY)][] = array(
            'fecha' => $fecha,
            'titulo' => $titulo['descripcion'],
            'id' => $titulo['id'],
            'imgHtml' => $this->getView()->img($imgSrc, array('title' => $titulo['descripcion']))
        );
        return $this;
    }
    
    public function getUrlDetalle()
    {
        return $this->urlDetalle;
    }

    public function setUrlDetalle($url)
    {
        $this->urlDetalle = $url;
        return $this;
    }

    public function getUrlEditar()
    {
        return $this->urlEditar;
    }

    public function setUrlEditar($url)
    {
        $this->urlEditar = $url;
        return $this;
    }
    
    public function setConsulta($valor){
        
       $this->consulta = $valor;
        return $this;   
    }
    public function getConsulta()
    {
        return $this->consulta;
    }
    
    public function addElementoReunion(Zend_Date $fecha, $estado)
    {
        $this->reuniones[$fecha->get(Zend_Date::YEAR)][$fecha->get(Zend_Date::MONTH)][$fecha->get(Zend_Date::DAY)][] = array(
            'estado' => $estado,
            'fecha' => $fecha->toString(self::$formatoId)
        );
        return $this;
    }
    
    
    protected function build()
    {
        try {
            $domSemSanta = Fmo_Util::calcularDomingoSemanaSanta($this->getAnio());
            $lunSemSanta = $domSemSanta->copyPart(Zend_Date::TIMESTAMP)->subDayOfYear(6);
            $this->semanaSanta = array('lunes' => $lunSemSanta, 'domingo' => $domSemSanta);
            unset($domSemSanta, $lunSemSanta);
        } catch (Exception $e) {
            $this->semanaSanta = array();
        }
        $titulo = $this->getTitulo();
        $url = $this->getUrlSigAntAnio();
        if (Fmo_Util::right($url, 1) != '/') {
            $url .= '/';
        }
        $url .= 'anio/';
        
        $html = '<table class="calendario" summary="' . $this->getTitulo() . '">' . PHP_EOL;
        
        $html .= '<caption>';
        $textoAnio = $this->getAnio() - 1;
        $html .= '<a href="' . $url . $textoAnio . '" title="Ver ' . self::$campos['year'] . ' ' . $textoAnio . '">';
        $html .= $this->getView()->img('ico_fecha_anterior.png');
        $html .= '</a> ';
        if (!empty($titulo)) {
            $html .= $titulo . ' - ';
        }
        $html .= 'Año ' . $this->getAnio();
        $textoAnio = $this->getAnio() + 1;
        $html .= ' <a href="' . $url . $textoAnio . '" title="Ver ' . self::$campos['year'] . ' ' . $textoAnio . '">';
        $html .= $this->getView()->img('ico_fecha_siguiente.png');
        $html .= '</a>';
        
        $html .= '<br>' . PHP_EOL;
        $html .= '</caption>' . PHP_EOL;
        $html .= '<br>' . PHP_EOL;
        
  // Icono volver a la página principal
    
       // $html .= '<a class="pureCssMenui0" href="'. $urlDefaul.'" title="Página Principal">';
       // $html .= '<img src="../sjud/public/images/vol_1.png" alt="vol_1.png" align="right" >';
       // $html .= '</a>';
    
      $html .= '<a class="pureCssMenui0" href="../" title="Página Principal">';
      $html .= '<img src="../public/images/vol_1.png" alt="vol_1.png" align="right" >';
      $html .= '</a>';
        
        for ($mes = 1; $mes <= 12; $mes++) {
            $this->setMes($mes);
            if ($mes % $this->getFormato() == 1) {
                $html .= '<tr>' . PHP_EOL;
            }
            $html .= '<td width="' . round(100.0 / $this->getFormato()) . '%">' . $this->buildAnioMes() . '</td>' . PHP_EOL;
            if ($mes % $this->getFormato() == 0) {
                $html .= '</tr>' . PHP_EOL;
            }
        }
        
        /* $html .= '<p>' . PHP_EOL;*/
        $html .= '<b>Leyenda:</b><br/>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class"hoy" style=" color: black;
    background-color: pink; border: 1px black solid;">N</span> No Laboral.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class"hoy" style=" color: black;
    background-color: white; border: 1px black solid;">N</span> Laboral Normal.</span>' . PHP_EOL;
        /*Modificación Anaicelys Brito*/
        $html .= '<span class="elementoLeyenda">';        
        $html .= $this->getView()->img(' ico_reunion2.png');
        $html .= ' Reunión.</span>' . PHP_EOL;
       /* $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: skyblue;border: 1px black solid;">N</span> Reunion Ordinaria.</span>' . PHP_EOL;*/ //Anaicelys
      /*  $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: yellow;border: 1px black solid;">N</span> Reunion Extraordinaria.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: turquoise;border: 1px black solid;">N</span> Reunion Efectuada.</span>' . PHP_EOL;*/
    /*    $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: browm;
    background-color: brown;border: 1px black solid;">_</span> Reunion .</span>' . PHP_EOL;*/
       $html .= '<span class="elementoLeyenda">';        
        $html .= $this->getView()->img('ico_semana_santa.png');
        $html .= ' Semana Santa.</span>' . PHP_EOL;
        $html .= '</table>' . PHP_EOL;
      

        return $html;
        return parent::build();
    }
    
    
    

    protected function buildAnioMes()
    {
        $keyDiaSem = $this->isNombreDiaSemanaAbreviado() ? 'abbreviated' : 'wide';
        $keyMes = $this->isNombreMesAbreviado() ? 'abbreviated' : 'wide';
        $html = '<table class="calendarioMesAnio" style="width:' .$this->getAncho().'" align="'.$this->getAlineacion().'" summary="Mes de ' . self::$meses['format'][$keyMes][$this->getMes()] . '">' . PHP_EOL;
        $html .= '<caption>';
        $html .= self::$meses['format'][$keyMes][$this->getMes()];
        $html .= '</caption>' . PHP_EOL;
        $html .= '<thead>' . PHP_EOL;
        $html .= '<tr>' . PHP_EOL;
        $html .= '<th>' . ($this->isNombreDiaSemanaAbreviado() ? Fmo_Util::left(self::$campos['week'], 3) : self::$campos['week']) . '</th>' . PHP_EOL;
        $html .= '<th> '. self::$dias['format'][$keyDiaSem]['mon'] . '</th>' . PHP_EOL;
        $html .= '<th>' . self::$dias['format'][$keyDiaSem]['tue'] . '</th>' . PHP_EOL;
        $html .= '<th>' . self::$dias['format'][$keyDiaSem]['wed'] . '</th>' . PHP_EOL;
        $html .= '<th>' . self::$dias['format'][$keyDiaSem]['thu'] . '</th>' . PHP_EOL;
        $html .= '<th>' . self::$dias['format'][$keyDiaSem]['fri'] . '</th>' . PHP_EOL;
        $html .= '<th>' . self::$dias['format'][$keyDiaSem]['sat'] . '</th>' . PHP_EOL;
        $html .= '<th>' . self::$dias['format'][$keyDiaSem]['sun'] . '</th>' . PHP_EOL;
        $html .= '</tr>' . PHP_EOL;
        $html .= '</thead>' . PHP_EOL;
        $html .= '<tbody>' . PHP_EOL;
        $datos = $this->toArray();
        $mesDosDigitos = Fmo_Util::right('0' . $this->getMes(), 2);
        $anioMes = $this->getAnio() . $mesDosDigitos;
        $cont = 0;
        foreach ($datos as $cal) {
            $cont++;
            $diaSemana = $cal['fecha']->get(Zend_Date::WEEKDAY_DIGIT);
            $id = $anioMes . '-' . $cal['fecha']->toString(self::$formatoId);
             $url = $this->getUrlEditar();
             $urld = $this->getUrlDetalle();
             if (Fmo_Util::right($url, 1) != '/' ) {
                    $url .= '/anio/';
                    } 
                   
                    $mes = '/mes/';
                    $dia = '/dia/';
                    $textoAnio = $this->getAnio();                    
                    $textoMes = $cal['fecha']->get(Zend_Date::MONTH);                                       
                    $textodia = $cal['fecha']->get(Zend_Date::DAY);                    
                    $dia2 = $cal['fecha'];
            
            // si el día de la semana es lunes abrimos la fila
            if ($diaSemana == 1) {
                
                $html .= '<tr >' . PHP_EOL;
                $html .= '<td id="semana-' . $id . '">' . $cal['fecha']->toString('w'). PHP_EOL;
                $html .= '</td>' . PHP_EOL;
                
            }
                /*$diaa = $cal['fecha']->get(Zend_Date::DAY);
                $mess = $cal['fecha']->get(Zend_Date::MONTH);
                $añoo = $cal['fecha']->get(Zend_Date::YEAR);      
                $formato = new Zend_Date($añoo.'-'.$mess.'-'.$diaa);
                $nueva =  $formato->toString('yyyy-MM-dd');
                $tipo_reunion = Application_Model_Reunion::getTipoReunionPorFecha($nueva);
                if($tipo_reunion != null){
                    Fmo_Logger::debug('Reunion '. $tipo_reunion->estado);
                     if($tipo_reunion->estado == 'Laboral Normal'){
                     Fmo_Logger::debug($tipo_reunion);
                     $html .= '<td id="dia' . $id . '"bgcolor="white"';
                     }
                     if($tipo_reunion->estado == 'No Laboral'){
                     Fmo_Logger::debug($tipo_reunion);
                     $html .= '<td id="dia' . $id . '"bgcolor="pink"';
                     }
                     if($tipo_reunion->estado == 'Reunion Ordinaria'){
                     Fmo_Logger::debug($tipo_reunion);
                     $html .= '<td id="dia' . $id . '"bgcolor="sky blue"';
                     }
                     if($tipo_reunion->estado == 'Reunion Extraordinaria'){
                     Fmo_Logger::debug($tipo_reunion);
                     $html .= '<td id="dia' . $id . '"bgcolor="yellow"';
                     }
                     if($tipo_reunion->estado == 'Reunion Efectuada'){
                     Fmo_Logger::debug($tipo_reunion);
                     $html .= '<td id="dia' . $id . '"bgcolor="turquoise"';
                     }
                     if($tipo_reunion->estado == 'Reunion Ordinaria No Efectuada'){
                     Fmo_Logger::debug($tipo_reunion);
                     $html .= '<td id="dia' . $id . '"bgcolor="gray"';
                     }
                     
                }
                  $html .= '<td id="dia' . $id . '"';*/
            
                if (isset($this->reuniones[$cal['fecha']->get(Zend_Date::YEAR)][$cal['fecha']->get(Zend_Date::MONTH)][$cal['fecha']->get(Zend_Date::DAY)])) {
                   //REUNIONES
                    foreach ($this->reuniones[$cal['fecha']->get(Zend_Date::YEAR)][$cal['fecha']->get(Zend_Date::MONTH)][$cal['fecha']->get(Zend_Date::DAY)] as $elem) {
                       
                        if($elem['estado'] == 'LABORAL NORMAL'){
                        $html .= '<td id="dia' . $id . '"bgcolor="white"';
                        }
                        if($elem['estado'] == 'NO LABORAL'){
                        $html .= '<td id="dia' . $id . '"bgcolor="pink"';
                        }
                        if($elem['estado'] == 'REUNION ORDINARIA'){
                        $html .= '<td id="dia' . $id . '"bgcolor="skyblue"';
                        }
                        if($elem['estado'] == 'REUNION EXTRAORDINARIA'){
                        $html .= '<td id="dia' . $id . '"bgcolor="yellow"';
                        }
                        if($elem['estado'] == 'REUNION EFECTUADA'){
                        $html .= '<td id="dia' . $id . '"bgcolor="turquoise"';
                        }
                        if($elem['estado'] == 'REUNION ORDINARIA NO EFECTUADA'){
                        $html .= '<td id="dia' . $id . '"bgcolor="gray"';
                        }
                        
                    }
                }
                $html .= '<td id="dia' . $id . '"';
                        
              
            
            if ($diaSemana == 6 || $diaSemana == 0 ) {
                $html .= 'bgcolor="pink"';
                $id .= '-findesemana';
                $tipo= '/tipo/';
                $textoTipo =  'No Laboral';
            }else{
            $tipo= '/tipo/';
            $textoTipo =  'Laboral Normal';    
            }
            
            
            if (!empty($this->semanaSanta) && $cal['fecha']->compareDate($this->semanaSanta['lunes']) >= 0 && $cal['fecha']->compareDate($this->semanaSanta['domingo']) <= 0) {
                $html .= ' class="semanaSanta" bgcolor=""';
            }
            $html .= '>';
            
            if ($this->getMes() == $cal['fecha']->get(Zend_Date::MONTH_SHORT)) {
                $esHoy = $this->fechaHoy->compareDate($cal['fecha']);
                    
                  if ($esHoy == 0) {
                    
                    //HOY
                    $html .= '<span class="hoy">';
                    
                }
                
                if ($cal['feriado']) {
                    $html .= '<span class="feriado" >';
                }
                    //OTROS DIAS
                    //$html .= $cal['fecha']->get(Zend_Date::DAY_SHORT);
                 $consulta = $this->getConsulta();
                    if($consulta == 'consulta'){
                    $html .= '<a title="Ver ' .  '">'. PHP_EOL;
                    $html .= $cal['fecha']->get(Zend_Date::DAY_SHORT).'</a>'. PHP_EOL;
                        
                    }else{
                    $html .= '<a href="' . $url .$textoAnio.$mes.$textoMes.$dia.$textodia.$tipo.$textoTipo. '" title="Ver ' .  '">'. PHP_EOL;
                    $html .= $cal['fecha']->get(Zend_Date::DAY_SHORT).'</a>'. PHP_EOL;
                    }
                if ($cal['feriado']) {
                    $html .= '</span>';
                }
                if ($esHoy == 0) {
                    
                   $html .= '</span> ';
                  
                }
                
                if (isset($this->elemento[$cal['fecha']->get(Zend_Date::YEAR)][$cal['fecha']->get(Zend_Date::MONTH)][$cal['fecha']->get(Zend_Date::DAY)])) {
                   //REUNIONES
                    foreach ($this->elemento[$cal['fecha']->get(Zend_Date::YEAR)][$cal['fecha']->get(Zend_Date::MONTH)][$cal['fecha']->get(Zend_Date::DAY)] as $elem) {
                       $urld = $this->getUrlDetalle();
                     if (Fmo_Util::right($urld, 1) != '/' ) {
                    $urld .= '/id/';
                    } 
                    $reunion  = Application_Model_Reunion::getReunionIndice($elem['id']);
        
                    $tipo= '/tipo/';
                    $textoTipo =  'No Laboral';
                     
                     
                        //Fmo_Logger::debug($elem['id'].$tipo.$textoTipo);
                        $id = $elem['id'];
                        $consulta = $this->getConsulta();
                        if($consulta == 'consulta'){
                        $html .= '<a title="Ver ' .  '">'. PHP_EOL;
                        $html .= isset($elem['imgHtml']) ? $elem['imgHtml'] : $elem['titulo'].'</a>'. PHP_EOL;
                           
                        }else{
                        $html .= '<a href="' . $urld.$elem['id'].$tipo.$textoTipo.'" title="Ver ' .  '">'. PHP_EOL;
                        $html .= isset($elem['imgHtml']) ? $elem['imgHtml'] : $elem['titulo'].'</a>'. PHP_EOL;
                        }
                        
                        }
                }
            }
             $html .= '</td>'. PHP_EOL;
                
            //$html .= '</td>' . PHP_EOL;
            // sí el día de la semana es domingo cerramos la fila
            if ($diaSemana == 0) {
                $html .= '</tr>' . PHP_EOL;
            }
        }
        $html .= '</tbody>' . PHP_EOL;
        //termina mes
        $html .= '</table>';
        if ($this->isMostrarElementos() && isset($this->elemento[$this->getAnio()][$mesDosDigitos])) {
            $html .= '<ul>';
            foreach ($this->elemento[$this->getAnio()][$mesDosDigitos] as $elem) {
                foreach ($elem as $elemDia) {
                    $html .= '<li>';
                    $html .= $elemDia['titulo'];
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }

        return $html;  
        
        
        return parent::buildAnioMes();
    }

    protected function buildMes($mes)
    {
        
        
        try {
            $domSemSanta = Fmo_Util::calcularDomingoSemanaSanta($this->getAnio());
            $lunSemSanta = $domSemSanta->copyPart(Zend_Date::TIMESTAMP)->subDayOfYear(6);
            $this->semanaSanta = array('lunes' => $lunSemSanta, 'domingo' => $domSemSanta);
            unset($domSemSanta, $lunSemSanta);
        } catch (Exception $e) {
            $this->semanaSanta = array();
        }
        $titulo = $this->getTitulo();
        $url = $this->getUrlSigAntAnio();
        if (Fmo_Util::right($url, 1) != '/') {
            $url .= '/';
        }
        $url .= 'anio/';
        $html = '<table class="calendario" summary="' . $this->getTitulo() . '">' . PHP_EOL;
        $html .= '<caption>';
        $textoAnio = $this->getAnio() - 1;

        $html .= '</a> ';
        if (!empty($titulo)) {
            $html .= $titulo . ' - ';
        }
        $html .= 'Año ' . $this->getAnio();

        $html .= '</a>';
        $html .= '</caption>' . PHP_EOL;

            $this->setMes($mes);
            if ($mes % $this->getFormato() == 1) {
                $html .= '<tr>' . PHP_EOL;
            }
            $html .= '<tr width="' . round(100.0 / $this->getFormato()) . '%">' . $this->buildAnioMes() . '</tr>' . PHP_EOL;
            if ($mes % $this->getFormato() == 0) {
                $html .= '</tr>' . PHP_EOL;

        }

        $html .= '</table>' . PHP_EOL;
        $html .= '<br>' . PHP_EOL;
        /*$html .= '<table class="calendario" align="center" style="width: 50%">' . PHP_EOL;
        $html .= '<caption>Leyenda:</caption>'.PHP_EOL;
        $html.= '<thead>'.PHP_EOL;
        $html.= '<tr>'.PHP_EOL;
                
         $html .= '<span class="elementoLeyenda"><span class"hoy" style=" color: black;
    background-color: skyblue; border: 1px black solid;">N</span> No Laboral.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class"hoy" style=" color: black;
    background-color: white; border: 1px black solid;">N</span> Laboral Normal.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: skyblue;border: 1px black solid;">N</span> Reunion Ordinaria.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: yellow;border: 1px black solid;">N</span> Reunion Extraordinaria.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: turquoise;border: 1px black solid;">N</span> Reunion Efectuada.</span>' . PHP_EOL;
        $html .= '<span class="elementoLeyenda"><span class="hoy" style=" color: black;
    background-color: gray;border: 1px black solid;">N</span> Reunion Ordinaria No Efectuada.</span>' . PHP_EOL;
      $html .= '<th><span class="elementoLeyenda">';
        $html .= $this->getView()->img('ico_semana_santa.png');
        $html .= ' Semana Santa.</span></th>' . PHP_EOL;
        $html .= '<th><span class="elementoLeyenda">';
        $html .= $this->getView()->img('ico_bala_rojo.png');
        $html .= ' Día de Acto Público.</span></th>' . PHP_EOL;
        $html.= '</tr>';
        $html.= '</thead>'.PHP_EOL;
        $html .= '</table>' . PHP_EOL;*/
        return $html;
        return parent::buildMes($mes);
    }

}
