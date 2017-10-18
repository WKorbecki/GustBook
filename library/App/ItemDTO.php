<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemDTO
 *
 * @author Wojciech
 */
class App_ItemDTO 
{
    public $id;
    public $user;
    public $email;
    public $message;
    public $date;
    //public $userId;
    
    //public function __construct($user,$email,$message,$date,$id,$userId) 
    public function __construct($user,$email,$message,$date,$id) 
    {
        $this->user = $user;
        $this->email = $email;
        $this->message = $message;
        $this->date = $date;
        $this->id = $id;
        //$this->userId = $userId;
    }
}
