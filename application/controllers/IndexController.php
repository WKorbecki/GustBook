<?php

class IndexController extends Zend_Controller_Action
{
    protected $session;

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        try
        {
            $this->_helper->Redirector->gotoUrl('/message');
        } 
        catch (Exception $ex)
        {
            echo $ex->getMessage();
        }
        //include '/item';
    }


}

