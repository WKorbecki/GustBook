<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserDTO
 *
 * @author Wojciech
 */
class App_UserDTO 
{
    /*private $id;
    private $name;
    private $password;
    private $email;
    private $access;*/
    
    public $id;
    public $name;
    public $password;
    public $email;
    public $access;
    
    public function __construct($id,$name,$password,$email,$access) 
    {
        $this->setId($id);
        $this->setName($name);
        $this->setPwd($password);
        $this->setEmail($email);
        $this->setAccess($access);
    }
    
    //set
    public function setId($id)
    {
        $this->id=$id;
    }
    
    public function setName($name)
    {
        $this->name=$name;
    }
    
    public function setPwd($password)
    {
        $this->password=$password;
    }
    
    public function setEmail($email)
    {
        $this->email=$email;
    }
    
    public function setAccess($access)
    {
        $this->access=$access;
    }
    
    //get
    /*public function getId()
    {
        $this->id;
    }
    
    public function getName()
    {
        $this->name;
    }
    
    public function getPwd()
    {
        $this->password;
    }
    
    public function getEmail()
    {
        $this->email;
    }
    
    public function getAccess()
    {
        $this->access;
    }*/
}
//<td></td>