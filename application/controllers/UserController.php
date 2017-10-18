<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Wojciech
 */
class UserController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout()->setLayout("base");
    }
    
    public function preDispatch() 
    {
        $this->session = new Zend_Session_Namespace('default');
        
        if (!$this->session->users)
        {
            $users = new Application_Model_DbTable_Users();
            $this->session->users = $users->fetchAll();
        }
        
        if (!$this->session->user_id)
        {
            $this->session->user_id = 0;
        }
        
        $view = new App_View();
        $this->view = $view->conf($this->session->user_id, $this->view);
    }

    public function indexAction()
    {
        $users = new Application_Model_DbTable_Users();
        
        try
        {
            $this->view->users = $users->fetchAll();
            $this->session->users = $users->fetchAll();
        }
        catch (Exception $ex)
        {
            $this->view->eMsg = $ex->getMessage();
        }
    }
    
    public function signinAction()
    {
        if(isset($_POST['signin']) && $this->session->user_id == 0)
        {
            $users = new Application_Model_DbTable_Users();
            
            if(!empty($_POST['login']) && !empty($_POST['pwd']) && $users->userExists('login', $_POST['login']))
            {
                $id = $users->userExists('login', $_POST['login']);
                $user = $users->getUser($id);
                if (md5($_POST['pwd'])==$user['pwd'])
                {
                    $this->session->user_id=$id;
                    $this->_helper->Redirector->gotoUrl('/');
                }
            }
        }
        elseif($this->session->user_id != 0)
            $this->_helper->Redirector->gotoUrl('/');
    }
    
    public function signupAction()
    {
        $this->view->msg = "";
        
        $errors = array('login' => array('null' => 'This field is required.',
                                         'exist' => 'This login exist.',
                                         'short' => 'This login is too short',
                                         'long' => 'This login is too long'),
                        'pwd' => array('null' => 'This field is required.'),
                        're_pwd' => array('null' => 'This field is required.',
                                          'not' => 'Passwords are not the same.'),
                        'name' => array('null' => 'This field is required.',
                                        'exist' => 'This name exist.'),
                        'email' => array('null' => 'This field is required.',
                                         'exist' => 'This e-mail exist.'));
        
        
        if(isset($_POST['signup']) && $this->session->user_id == 0)
        {
            $this->view->errors = array('login' => '','pwd' => '','re_pwd' => '','name' => '','email' => '');
            
            $signup_form = array('login'=>addslashes(htmlspecialchars($_POST['login'])),
                                 'pwd'=>addslashes(htmlspecialchars($_POST['pwd'])),
                                 're_pwd'=>addslashes(htmlspecialchars($_POST['re_pwd'])),
                                 'name'=>addslashes(htmlspecialchars($_POST['name'])),
                                 'email'=>addslashes(htmlspecialchars($_POST['email'])));
            
            $users = new Application_Model_DbTable_Users();
            
            if (empty($signup_form['login']))
                $this->view->errors['login'] = $errors['login']['null'];
            
            if (empty($signup_form['pwd']))
                $this->view->errors['pwd'] = $errors['pwd']['null'];
            
            if (empty($signup_form['re_pwd']))
                $this->view->errors['re_pwd'] = $errors['re_pwd']['null'];
            
            if (empty($signup_form['name']))
                $this->view->errors['name'] = $errors['name']['null'];
            
            if (empty($signup_form['email']))
                $this->view->errors['email'] = $errors['email']['null'];
            
            if ($users->userExists('login', $signup_form['login']))
                $this->view->errors['login'] = $errors['login']['exist'];
            
            if ($signup_form['pwd']!=$signup_form['re_pwd'])
                $this->view->errors['re_pwd'] = $errors['re_pwd']['not'];
            
            if ($users->userExists('name', $signup_form['name']))
                $this->view->errors['name'] = $errors['name']['exist'];
            
            if ($users->userExists('email', $signup_form['email']))
                $this->view->errors['email'] = $errors['email']['exist'];
            
            if (empty($this->view->errors['login']) && empty($this->view->errors['pwd']) && empty($this->view->errors['re_pwd']) && empty($this->view->errors['name']) && empty($this->view->errors['email']))
            {
                $users->addUser($signup_form['login'], md5($signup_form['pwd']), $signup_form['name'], $signup_form['email']);
                $this->_helper->Redirector->gotoUrl('/');
            }
        }
        elseif($this->session->user_id != 0)
            $this->_helper->Redirector->gotoUrl('/');
    }
    
    public function logoutAction()
    {
        try {
            if ($this->session->user_id != 0)
        {
            $this->session->user_id = 0;
            
            $view = new App_View();
            $this->view = $view->conf($this->session->user_id, $this->view);
            
            $this->_helper->Redirector->gotoUrl('/');
        }
        else
            $this->_helper->Redirector->gotoUrl('/');
            
        } catch (Exception $ex) {
            $this->view->emsg = $ex->getMessage();
        }
    }
}
