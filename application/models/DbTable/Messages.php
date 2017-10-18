<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Messages
 *
 * @author Wojciech
 */
class Application_Model_DbTable_Messages extends Zend_Db_Table_Abstract
{
    protected $_name = 'messages';
    
    public function get($id, $mode = 'msg_id')
    {
        $row = $this->fetchRow($mode . ' = ' . $id);
        
        if (!$row)
            throw new Exception("Could not find row $id");
        
        return $row->toArray();
    }
    
    public function getID($value, $key = 'msg_id')
    {
	$select = $this->select()->where($key . ' =?', $value);
	$row = $this->fetchRow($select);
	if(is_null($row->msg_id))
		return 0;
	else
		return $row->msg_id;
    }
    
    public function getUser($value, $key = 'msg_id')
    {
	$select = $this->select()->where($key . ' =?', $value);
	$row = $this->fetchRow($select);
	if(is_null($row->user_id))
		return 0;
	else
		return $row->user_id;
    }
    
    public function addMessage($msg,$user_id)
    {
        $data = array('msg' => $msg, 'user_id' => $user_id);
        $this->insert($data);
    }
    
    public function updateMessage($id,$msg)
    {
        $date = new Zend_Date();
        $datetime = date("Y-M-d_G:i:s", strtotime($date->get(Zend_Date::DATETIME)));
        //0000-00-00 00:00:00
        //$date_now = $date->get(Zend_Date::YEAR) . "-" . $date->get(Zend_Date::MONTH) . "-" . $date->get(Zend_Date::DAY) . " " . $date->get(Zend_Date::HOUR) . "-" . $date->get(Zend_Date::YEAR) . "-" . $date->get(Zend_Date::YEAR);
        $data = array('msg' => $msg, 'date_mod' => $date);
        $this->update($data, 'msg_id = '. (int)$id);
    }
}
