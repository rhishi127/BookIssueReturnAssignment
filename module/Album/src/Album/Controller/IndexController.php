<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
    protected  $_primaryTable =null;
    protected  $_serviceManager =null;


    public function indexAction(){
        
        $firstNumber = 0;
        $secondNumber = 1;
        $indexNumber =0;
        
        $temporaryNumber= 0;
        $febonacciSeriseArray = array();
        array_push($febonacciSeriseArray, $firstNumber);
        array_push($febonacciSeriseArray, $secondNumber);
        echo "<br />".$firstNumber;
        echo "<br />".$secondNumber;
        while ($indexNumber< 10){
            $temporaryNumber = $firstNumber + $secondNumber;
            echo "<br />".$temporaryNumber;
            array_push($febonacciSeriseArray, $temporaryNumber);
            $firstNumber = $secondNumber;
            $secondNumber = $temporaryNumber;
            $temporaryNumber =0;
            $indexNumber++;
        }
        //print_r($febonacciSeriseArray);
        //echo implode(",", $febonacciSeriseArray);
        die;
        /*
$indexNumber = 0;  
$firstNumber = 0;  
$secondNumber = 1;  
$thirdNumber = 0;

echo "<h3>Fibonacci series for first 12 numbers: </h3>";  
echo "\n";  
echo $firstNumber.' '.$secondNumber.' ';  
while ($indexNumber < 10 )  
{  
    $thirdNumber = $secondNumber + $firstNumber;  
    echo $thirdNumber.' ';  
    $firstNumber = $secondNumber;  
    $secondNumber = $thirdNumber;  
    $indexNumber++;  
        
}
die;*/
    if(is_null($this->_primaryTable)){
           $this->getTable('AlbumTable');
        }
        return new ViewModel(
            array(
                'albums' =>$this->_primaryTable->fetchAll(),
            ) 
        );
    }
    public function addAction(){
        $request = $this->getRequest();
        
        $albumForm= new \Album\Form\AlbumForm ();
        if($request->isPost()){
            $album  = new \Album\Model\Album();
            $albumForm->setInputFilter($album->getInputFilter());
            $albumForm->setData($request->getPost());
            if($albumForm->isValid()){
                $album->exchangeArray($request->getPost());
                if(is_null($this->_primaryTable)){
                    $this->getTable ('AlbumTable');
                }              
                $this->_primaryTable->saveAlbum($album);
            }else{
                
               
            }
        }
       
            return new ViewModel(
            array(
                'albumForm' => $albumForm,
            ) 
        );
    }

    public function editAction(){
    
      
    }

    public function deleteAction(){
       
    }
    
    public function getTable($table){
           
        if(is_null($this->_serviceManager)){   
            $this->_serviceManager = $this->getServiceLocator();        
            $this->_primaryTable = $this->_serviceManager->get($table);
         
        }else{
           $this->_primaryTable = $this->_serviceManager->get($table);
        }
    }
    public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('AlbumTable');
         }
         return $this->albumTable;
     }
}
