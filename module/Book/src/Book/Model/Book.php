<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Book
 *
 * @author Administrator
 */
namespace Book\Model;

// Add these import statements
 
class Book  {
    
    /**
     * @var int $bookId
     * @access public 
    */
    public $bookId;
    
    /**
     * @var string $title
     * @access public 
    */
    public $title;
    
    /**
     * @var string $author
     * @access public 
    */
    public $author;
    
    /**
     * @var int $numberOfCopies
     * @access public 
    */
    public  $numberOfCopies;
    
    /**
     * @var int $issuedCopies
     * @access public 
    */
    public  $issuedCopies;
    
    /**
    * exchangeArray
     * 
    * function Used by ResultSet to pass each database row to the entity and  used 
    * to set posted data to object 
    * @access public
    * @param $data (posted array or resultset)
    */
    public function exchangeArray($data){
       // print_r($data);die;
        $this->bookId = (!empty($data['bookId']))?$data['bookId'] :null;
        $this->title = (!empty($data['title']))?$data['title'] :null;
        $this->author = (!empty($data['author']))?$data['author'] :null;
        $this->numberOfCopies =  isset($data['numberOfCopies'])?$data['numberOfCopies']:0; 
        $this->issuedCopies = isset($data['issuedCopies'])?$data['issuedCopies']:0;
    }
   
}
