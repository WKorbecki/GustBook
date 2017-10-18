<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dual
 *
 * @author Wojciech
 */
class Application_Model_DbTable_Dual extends Zend_Db_Table_Abstract
{
    protected $_name = 'dual';
    
    public function getDateTime()
    {
        $select = $this->select()->from('dual',array('datetime'=>'sysdate()'));
        $date = $this->fetchRow($select);
        
        return $date->datetime;
    }
}
