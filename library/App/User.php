<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Wojciech
 */
class App_User
{
    public function info($id)
    {
        $users = new Application_Model_DbTable_Users();
        $user = $users->getUser($id);
        
        return array('name'=>$user['name'],'access'=>$user['access'],'count'=>$this->message($id));
    }
    
    private function message($id)
    {
        $messages = new Application_Model_DbTable_Messages();
        /*$select = $db->select()
                     ->from('messages',array('num'=>'count(*)'))
                     ->where('user_id = ?',$id);
        
        $select = $db->fetchRow($select);*/
        $select = $messages->fetchRow($messages->select()->from('messages',array('num'=>'count(*)'))->where('user_id = ?',$id));
        
        return $select->num;
    }
}
