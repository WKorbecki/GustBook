<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemEditor
 *
 * @author Wojciech
 */
class App_forms_ItemEditor extends Zend_Form
{
    public function __construct($itemId, $session, $mode = 'create')
    {
        //$this->setMethod('post');
        
        $date = new Zend_Date();
        
        $this->addElement('text', 'user', array(
            'label'      => 'Your name:',
            'required'   => true,
            'filters'    => array('StringTrim')
        ));
        
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
        
        $this->addElement('textarea', 'message', array(
            'label'      => 'Message:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 100))
                )
        ));
        
        $this->addElement('hidden','id',array('value'=>$itemId));
        //$this->addElement('hidden','email',array('value'=>'no@email.com'));
        $this->addElement('hidden','date',array('value'=>$date->get(Zend_Date::DATETIME)));
        
        if(array_key_exists($itemId, $session->items))
        {
            $this->mapItemToForm($session->items[$itemId]);
        }
        
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => $mode,
        ));
        
        $this->setDecorators(array('FormElements',array('HtmlTag',array('tag' => 'dl')),'Form'));
    }
    
    private function mapItemToForm(App_ItemDTO $item)
    {
        $this->user->setValue($item->user);
        $this->email->setValue($item->email);
        $this->message->setValue($item->message);
        $this->date->setValue($item->date);
        $this->id->setValue($item->id);
    }

        public function MapFormToItemDTO()
    {
        return new App_ItemDTO($this->user->getValue(), 
                               $this->email->getValue(), 
                               $this->message->getValue(), 
                               $this->date->getValue(), 
                               $this->id->getValue());
    }
}
