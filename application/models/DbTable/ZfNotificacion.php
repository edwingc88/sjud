<?php

class Application_Model_DbTable_ZfNotificacion extends Application_Model_DbTable_Abstract
{
    protected $_name = 'zf_notificacion';
    protected $_sequence = true;
    protected $_referenceMap = array(
        'Para' => array(
            'columns' => 'para',
            'refTableClass' => 'Fmo_DbTable_RpsdatosDatoBasico',
            'refColumns' => 'datb_cedula'
        )
    );
}
