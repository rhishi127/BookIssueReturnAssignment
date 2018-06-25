<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlbumTable
 *
 * @author Administrator
 */
namespace Album\Model;
use \Zend\Db\TableGateway\TableGateway;
class AlbumTable {
    protected $_tableGateway;
 
    public function __construct(TableGateway $tableGateway){
       $this->_tableGateway  = $tableGateway;
    }
    
    /*
     * fetchAll
     * function used to fetch all records from album table
     * @access public 
     * return resultset
     * 
     */
    public function fetchAll(){
        $resultSet = $this->_tableGateway->select();
        return $resultSet;
    } 
    
    /*
     * getALbum 
     * function used to get spacific album data  by using  album id 
     * @access public 
     * @params int id (id of album required)
     * return resultSet
     * 
     */
    public function getAlbum($id){
        $id = (int)$id;
        $resultSet  = $this->_tableGateway->select(array('id',$id));
        return $resultSet;
    }
    
    /**
     * saveAlbum
     * Function used to  insert new album or update existing application 
     * @access public
     * @param \Album\Model\Album $album
     * return boolean $success
     */
    public function saveAlbum(Album $album){
        $data = array(
            'title' =>$album->title,
            'artist' =>$album->artist
        );
  
        
        $id = (int) $album->id;
        // Insert new album
        if($id){
                if($this->getAlbum($id)){  
                $this->_tableGateway->update($data,array('id'=>$id));
            }
            
        }else{
        $this->_tableGateway->insert($data);
        }
    }        
}
