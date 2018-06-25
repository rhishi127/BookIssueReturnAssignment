<?php
/**
 * 
 *
 * Controller to manage Issue and Receive Bookd .
 *
 * PHP version  7.0.13
 * @category    CRUD
 * @package     BOOk
 * @author      RJ
 * 
 */
namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
    
    
    
    protected  $_primaryTable = null; //variable holds value for primary table gateway 
    
    protected  $_serviceManager =null; //variable hold value of zend serviceManger instance 
    
    // error code resource not  found 
    public $_RES_NOT_FOUND = array('statusCode' => 404, 'reasonPhrase' => 'Not Found');
    
    // error code method not allowed  
    public $_RES_METHOD_NOT_ALLOWED = array('statusCode' => 405, 'reasonPhrase' => 'Method Not Allowed');
   
    //success response code 
    public $_RES_OK = array('statusCode' => 200, 'reasonPhrase' => 'OK');
    
    //internal server response code 
    public $_RES_INTERNAL_SERVER_ERROR = array('statusCode' => 500, 'reasonPhrase' => 'Internal Server Error');
    
    //service unavailable response code
    public $_RES_SERVICE_UNAVAILABLE = array('statusCode' => 503, 'reasonPhrase' => 'Service Unavailable');
   
    /**
     * indexAction
     * Action used to render  view to show list of books
     * @access public 
     * @return ViewModel
     */
    
    public function indexAction(){    
         $this->getBookTable();
        
        return new ViewModel(
            array(
                'books' =>$this->_primaryTable->fetchAll(),
            ) 
        );
    }
    
    
    /**
     * issueBook
     * Action used to issue specific book it is action created to handle xmlHttp REquest only  
     * @param int  $bookId id of book wanted to issue
     * @access public 
     * @return JsonArray
     */
    public function issueBookAction(){
        $result = array('response' => $this->_RES_INTERNAL_SERVER_ERROR);    
        $request =  $this->getRequest();
        if($request->isXmlHttpRequest()){
           if($request->isPost()){
                try {
                  $bookId = (int)$request->getPost('bookId');
                  $this->getBookTable();
                  $book = $this->_primaryTable->getBook($bookId);
                  $issueSuccess = $this->_primaryTable->issueReceiveBook($book,1);
                  if($issueSuccess['success']){
                        if($issueSuccess['id']){
                          $result = array('response' => $this->_RES_OK, 'reasonPhrase' =>array('Book Issued Successfully',$issueSuccess['books']));
                        }else{
                             $result = array('response' => $this->_RES_SERVICE_UNAVAILABLE, 'reasonPhrase' =>array('No Books Available To Issue',$issueSuccess['books']));
                        }  
                      
                  }else{
                        $result = array('response' => $this->_RES_INTERNAL_SERVER_ERROR, 'reasonPhrase' =>array('Internal Server Issue occured please contact Administrator'));
                  }  
                }
                catch (\Exception $ex) {
                    $result = array('response' => $this->_RES_NOT_FOUND, 'reasonPhrase' => array($ex->getMessage()));
                }
            }
           
        }else{
              $result = array('response' => $this->_RES_METHOD_NOT_ALLOWED, 'reasonPhrase' => array('method not allowed'));
        }
        $this->sendResponse($result);
    }
    
    /**
     * returnBookAction
     * Action used to return specific book it is action created to handle xmlHttp REquest only  
     * @param int  $bookId id of book wanted to return
     * @access public 
     * @return JsonArray
     */
    public function returnBookAction(){
        $result = array('response' => $this->_RES_INTERNAL_SERVER_ERROR);    
        $request =  $this->getRequest();
        if($request->isXmlHttpRequest()){
           if($request->isPost()){  
               try {
                  $bookId = (int)$request->getPost('bookId');
                  $this->getBookTable();
                  $book = $this->_primaryTable->getBook($bookId);
                  $issueSuccess = $this->_primaryTable->issueReceiveBook($book,0);
                  if($issueSuccess['success']){
                       if($issueSuccess['id']){
                           $result = array('response' => $this->_RES_OK, 'reasonPhrase' =>array('Book Return Successfully',$issueSuccess['books']));
                       }else{
                           $result = array('response' => $this->_RES_SERVICE_UNAVAILABLE, 'reasonPhrase' =>array('No Books To Return',$issueSuccess['books']));
                           
                       }
                      
                  }else{
                        $result = array('response' => $this->_RES_INTERNAL_SERVER_ERROR, 'reasonPhrase' =>array('Internal Server Issue occured please contact Administrator'));
                  }  
                }
                catch (\Exception $ex) {
                    $result = array('response' => $this->_RES_NOT_FOUND, 'reasonPhrase' => array($ex->getMessage()));
                }
            }
        }else{
              $result = array('response' => $this->_RES_METHOD_NOT_ALLOWED, 'reasonPhrase' => array('method not allowed'));
        }
        $this->sendResponse($result);
    }
  
        
    /*
     * getBookTable
     * function used to locate BookTable Factory from module config 
     * @access public 
     * @return  instance of /Model/BookTable
    */
   
    public function getBookTable(){
        if (is_null($this->_primaryTable)) {
            $this->getClassServiceLocator();
            $this->_primaryTable = $this->_serviceManager->get('BookTable');
         }
        return $this->_primaryTable;
    }
    
   
    /*
     * getClassServiceLocator
     * function used to set ServiceManager instance in $_serviceManager  and return serviceManager instance 
     * @access public 
     * @return zend   ServiceManager instance 
    */
    public function getClassServiceLocator(){
        if(is_null($this->_serviceManager)){
          $this->_serviceManager = $this->getServiceLocator();     
        }
        return $this->_serviceManager;
    }
    
     /**
     * Formats the Response and returns.
     * 
     * @param json reposne  array
     */
    public function sendResponse($result = array()) {
        $response = array();
        if (is_array($result) && array_key_exists('response', $result)) {
            $response['statusCode'] = $result['response']['statusCode'];
            $response['reasonPhrase'] = array_key_exists('reasonPhrase', $result) ? $result['reasonPhrase'] : $result['response']['reasonPhrase'];
            $response['data'] = array_key_exists('data', $result) ? (is_array($result['data']) ? $result['data'] : array($result['data'])) : array();

            http_response_code($response['statusCode']);
            $response = json_encode($response);
        }
        echo $response;
        exit();
    }
} 
    