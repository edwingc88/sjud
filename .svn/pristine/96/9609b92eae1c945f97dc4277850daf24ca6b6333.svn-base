<?php

/**
 * Controlador para los ajax
 */
class AjaxController extends Zend_Controller_Action
{

    public function init()
    {
        $context = $this->_helper->ajaxContext();
        foreach (get_class_methods(__CLASS__) as $method) {
            if (strpos($method, 'Action') !== false) {
                $context->addActionContext($method, 'json');
            }
        }
        $context->initContext();
    }

      
    /**
     * Acción para listar las gerencias
     */
    public function gerenciaAction()
    {
        $term = $this->getParam('term', '%');
        if ($term != '%') {
            $term .= '%';
        }
        Fmo_Logger::debug('termino ='.$term);
        $filter = new Zend_Filter_StringToUpper();
        $filtro = $filter->filter($term);
        $tGerencias = new Application_Model_DbTable_GerenciaGeneralCoordinacion();
        $select = $tGerencias->select()
                ->setIntegrityCheck(false)
                ->from(array('a' => $tGerencias->info(Zend_db_table::NAME)),array('value' => 'a.siglas', 'label' => new Zend_Db_Expr("a.siglas || ' ' || a.descripcion")),$tGerencias->info(zend_db_Table::SCHEMA))               
                ->where('a.siglas LIKE ?', $filtro);
                //->order('label')
                //->limit(10);
       
        Fmo_Logger::debug($select);
        $this->_helper->autoComplete($this->_helper->json((array) $select->getAdapter()->fetchAll($select)));
    }
    

}
