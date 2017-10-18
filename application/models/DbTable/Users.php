<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author Wojciech
 */
class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    
    public function getUser($id, $mode = 'user_id')
    {
        $row = $this->fetchRow($mode . ' = ' . $id);
        
        if (!$row)
            throw new Exception("Could not find row $id");
        
        return $row->toArray();
    }
    
    public function addUser($login,$password,$name,$email)
    {
        $data = array(
            'login' => $login,
            'pwd' => $password,
            'name' => $name,
            'email' => $email
        );
        $this->insert($data);
    }


    /*public function fetchAllUsers() 
    {
        $select = $this->select();
        $result = $this->fetchAll($select);

        return $result; //returns array of row objects (rowset object)
    }*/
    
    public function userExists($key, $value)
    {
	$select = $this->select()->where($key . ' =?', $value);
	$row = $this->fetchRow($select);
	if(is_null($row->user_id))
		return 0;
	else
		return $row->user_id;
    }
}
