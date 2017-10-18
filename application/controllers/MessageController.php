<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageController
 *
 * @author Wojciech
 */
class MessageController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout()->setLayout("base");
    }
    
    public function preDispatch()
    {
        $this->session = new Zend_Session_Namespace('default');
        
        if (!$this->session->user_id)
        {
            $this->session->user_id = 0;
        }
        
        $view = new App_View();
        $this->view = $view->conf($this->session->user_id, $this->view);
    }
    
    public function indexAction()
    {
        $messages = new Application_Model_DbTable_Messages();
        
        $this->view->messages = $messages->fetchAll();
    }
    
    public function createAction()
    {
        try {
            if (isset($_POST['send']) && $this->session->user_id != 0)
        {
            $msg = addslashes(htmlspecialchars($_POST['message']));
            //$msg = str_replace(array('<','>','"'),array('[',']','|'),$msg);
            
            if (empty($msg))
                $this->view->msg = "Błąd!";
            else
            {
                $message = new Application_Model_DbTable_Messages();
                $message->addMessage($msg, $this->session->user_id);
                $this->_helper->Redirector->gotoUrl('/');
            }
        }
        elseif ($this->session->user_id == 0)
            $this->_helper->Redirector->gotoUrl('/');
            
        } catch (Exception $ex) {
            $this->view->bald = $ex->getMessage();
        }
    }
    
    public function deleteAction()
    {
        $messages = new Application_Model_DbTable_Messages();
        
        if ($this->getRequest()->getParam('id') == $messages->getID($this->getRequest()->getParam('id')) && $this->view->user['access'])
            $messages->delete('msg_id =' . $this->getRequest()->getParam('id'));
        
        $this->_helper->Redirector->gotoUrl('/');
    }
    
    public function editAction()
    {
        $messages = new Application_Model_DbTable_Messages();
        $id = $this->getRequest()->getParam('id');
        
        if ($id == $messages->getID($id) && ($this->session->user_id == $messages->getUser($id) || $this->view->user['access']))
        {
            //$message = $messages->fetchRow($messages->select()->from('messages',array('id'=>'msg_id','w'=>'msg'))->where($id));
            $message = $messages->get($id);
            $this->view->edit_message = $message['msg'];
            
            if (isset($_POST['send']))
                if (!empty($_POST['message']) && $_POST['message'] != $message['msg'])
                {
                    try {
                        $this->view->message = "";
                    //$msg = "<table style='border-style: double'><tr><td>" . $message['msg'] . "<td></tr></table><br/>" . addslashes(htmlspecialchars($_POST['message'])) . "\n\r <p style='color: #f00'>Zedytowane przez ".$this->view->user['name']."</p>";
                        $msg = addslashes(htmlspecialchars($_POST['message'])) . "\n\r <p style='color: #f00'>Zedytowane przez ".$this->view->user['name']."</p>";
                    $messages->updateMessage($this->getRequest()->getParam('id'), $msg);
                    $this->_helper->Redirector->gotoUrl('/');
                        
                    } catch (Exception $ex) {
                        $this->view->message = $ex->getMessage();
                    }
                }
                else
                    $this->view->message = "Błąd!";
        }
        else
            $this->_helper->Redirector->gotoUrl('/');
    }
}
