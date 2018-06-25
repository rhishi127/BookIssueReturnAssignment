<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Album
 *
 * @author Administrator
 */
namespace Album\Model;

// Add these import statements
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 use Zend\InputFilter\Factory as InputFactory;
class Album implements InputFilterAwareInterface {
    public $id;
    public $title;
    public $artist;
    public $inputFilter;
    
    public function exchangeArray($data){
        
        $this->id = (!empty($data['id']))?$data['id'] :null;
        $this->title = (!empty($data['title']))?$data['title'] :null;
        $this->artist = (!empty($data['artist']))?$data['artist'] :null;
        
    }
    public function SetInputfilter(InputFilterInterface $inputFilter){
        
    }
    public function getInputFilter(){
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            
            $factory = new InputFactory();
            $inputFilter->add($factory->createInput(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             )));

             $inputFilter->add($factory->createInput(array(
                 'name'     => 'artist',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'attributes'=>array(
                           'class'=>'form-control',
                         ), 
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                         
                     ),
                     array(
                      'name' =>'NotEmpty', 
                        'options' => array(
                            'messages' => array(
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Please enter artist!' 
                            ),
                        ),
                    ),
                 ),
             )));

             $inputFilter->add($factory->createInput(array(
                 'name'     => 'title',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                array(
                'name' => 'not_empty',
                ),
                array(
                    'name' => 'string_length',
                    'options' => array(
                        'min' => 1,
                    ),
                ),
        ),
             )));
             $this->inputFilter = $inputFilter;
       }
       return $this->inputFilter;
    }
}
