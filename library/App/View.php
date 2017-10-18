<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author Wojciech
 */
class App_View
{
    public function conf($id, $view)
    {
        $edit_view = $view;
        
        if($id!=0)
        {
            //$users = new Application_Model_DbTable_Users();
            $user_info = new App_User();
            
            //$user = $users->getUser($id);
            $user = $user_info->info($id);
            $edit_view->user = array('name'=>$user['name'],'access'=>$user['access'],'messages'=>$user['count']);
        }
        else
            $edit_view->user = array('name'=>'','access'=>0,'messages'=>0);
        
        $edit_view->user_id = $id;
        
        return $edit_view;
    }
}
