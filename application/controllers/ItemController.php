<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemController
 *
 * @author Wojciech
 */
class ItemController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
        $this->_helper->layout()->setLayout("base");
    }
    
    public function preDispatch() 
    {
        $this->session = new Zend_Session_Namespace('default');
        
        if (!$this->session->items)
        {
            $date = new Zend_Date();
            //$item1 = new App_ItemDTO('Guest1','no@email.com','hello world',$date->get(Zend_Date::DATETIME),1);
            //$item2 = new App_ItemDTO('Guest2','no@email.com','hello you',$date->get(Zend_Date::DATETIME),2);
            //$item3 = new App_ItemDTO('Wojciech','wojciechkorbecki@gmail.com','This is my first app in Zend Framework',$date->get(Zend_Date::DATETIME),3);
            //$this->session->items = array($item1,$item2,$item3);
            $this->session->items = array();
        }
        
        if (!$this->session->user_id)
        {
            $this->session->user_id = 0;
        }
        
        $view = new App_View();
        $this->view = $view->conf($this->session->user_id, $this->view);
        
        /*if($this->session->user_id!=0)
        {
            $users = new Application_Model_DbTable_Users();
            $id = $this->session->user_id;
            $user = $users->getUser($id);
            $this->view->user = array('name'=>$user['name'],'access'=>$user['access']);
            $this->session->user_name = $user['name'];
            $this->view->user_name = $this->session->user_name;
            $this->view->user_id = $this->session->user_id;
        }*/
        /*else
        {
            
            
            if ($user['access']==1)
                $this->_helper->layout()->setLayout("admin");
            else
                $this->_helper->layout()->setLayout("user");

            //$this->_helper->layout()->user_name = $this->session->user_name;
            //$this->_helper->layout()->user_id = $this->session->user_id;
        }*/
    }

    public function indexAction()
    {
        $this->view->items = $this->session->items;
    }
    
    public function createAction()
    {
        //$this->_helper->layout()->setLayout("layout2");
        $this->view->user_id = $this->session->user_id;
        $this->view->form = new App_forms_ItemEditor(count($this->session->items),  $this->session);
        
        if($this->getRequest()->isPost())
        {
            if($this->postBack())
                $this->_helper->Redirector->gotoUrl('/item');
        }
        
        
    }
    
    public function editAction()
    {
        $this->view->form = new App_forms_ItemEditor($this->getRequest()->getParam('id'), $this->session, 'edit');
        
        if($this->getRequest()->isPost())
        {
            if($this->postBack())
                $this->_helper->Redirector->gotoUrl('/item');
        }
    }
    
    public function deleteAction()
    {
        if(array_key_exists($this->getRequest()->getParam('id'), $this->session->items))
        {
            $this->session->items[$this->getRequest()->getParam('id')] = NULL;
            $this->view->message = "item delete!";
        }
        else
        {
            $this->view->message = "item not found!";
        }
    }

    private function postBack()
    {
        if($this->view->form->isValid($this->getRequest()->getParams()))
        {
            $this->session->items[$this->view->form->getValue('id')] = $this->view->form->MapFormToItemDTO();
            
            
            return true;
        }
        else
        {
            $this->view->errorElements = $this->view->form->getMessages();
        }
        
        return false;
    }
    
    private function layout_user($view,$session)
    {
        $edit_view = $view;
        
        return $edit_view;
    }
}
