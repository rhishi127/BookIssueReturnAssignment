<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BookTable
 *
 * @author Administrator
 */
namespace Book\Model;
use \Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class BookTable {
    protected $_tableGateway;
 
    public function __construct(TableGateway $tableGateway){
       $this->_tableGateway  = $tableGateway;
    }
    
    /*
     * fetchAll
     * function used to fetch all records from book table
     * @access public 
     * return resultset
     * 
     */
    public function fetchAll(){
      
        //return $resultSet;
        $resultSet = $this->_tableGateway->select(function (Select $select){
            $select ->columns(array('bookId'=>"book_id",'author'=>'author','title'=>'title','numberOfCopies'=>'number_of_copies','issuedCopies'=>'issued_copies',
            ));
            $select->order('book_id DESC');
            });
        return $resultSet;
        } 
    
    /*
     * getBook 
     * function used to get spacific book data  by using  book id 
     * @access public 
     * @params int id (id of book required)
     * return $row
     * 
     */
    public function getBook($id){
       
        $id = (int)$id;
        $resultSet = $this->_tableGateway->select(function (Select $select)use ($id){
            $select ->columns(array('bookId'=>"book_id",'author'=>'author','title'=>'title','numberOfCopies'=>'number_of_copies','issuedCopies'=>'issued_copies'));
            $select->where(array('book_id'=>$id));         
         });
        $row = $resultSet->current();
         if (!$row) {
             throw new \Exception("Could not find book");
          }
        
        return $row;
    }
    
    /**
     * issueReceiveBook
     * Function used to  receive or issue a book
     * @access public
     * @param \Book\Model\Book $book
     * @param int $mode (1 issue , 0 Receive)
     * return  array with boolean $success  and issued value
     */
    public function issueReceiveBook(Book $book,$mode){
        $id =(int) $book->bookId;    
        $success  = false;
        $availableCopies =$book->numberOfCopies -  $book->issuedCopies;
        //issue book when mode is 1 
        if($mode){
          if($book->issuedCopies <  $book->numberOfCopies ) 
            $book->issuedCopies = $book->issuedCopies  + 1;
          else 
              $id=0;
        }
        else{ 
          if(($book->issuedCopies > 0) && ($book->issuedCopies  <= $book->numberOfCopies) )    
            $book->issuedCopies = $book->issuedCopies  - 1;
          else 
            $id=0;
        }
        $data = array(
          'issued_copies' =>$book->issuedCopies,
        );
        if($id){
          if($this->getBook($id)){  
             $success = (bool)$this->_tableGateway->update($data,array('book_id'=>$id));
          }
        }else{
            $success =true;
        }
        return array('success'=>$success,'id'=>$id,'books'=>array('issued'=>$book->issuedCopies,'available'=>$book->numberOfCopies - $book->issuedCopies));
    }    
}
