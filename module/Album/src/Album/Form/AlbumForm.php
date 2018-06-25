<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlbumForm
 *
 * @author Administrator
 */

namespace Album\Form;
use Zend\Form\Form;

class AlbumForm extends Form {

    public  function __construct($name = null) {
        parent::__construct('albumForm');
    
        $this->add(array(
            'name'=>'id',
            'id'=>'id',
            'type'=>'hidden',
        ));
        
        $this->add(array(
            'name'=>'title',
            
            'type'=>'text',
            'options'=>array(
              'label' =>'Title'
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'id'=>'title',
            )
        ));
        $this->add(array(
            'name'=>'artist',
            'type'=>'text',
            'options'=>array(
              'label' =>'Artist'
            ),
            'attributes'=>array(
                'class'=>'form-control',
                'id'=>'artist',        
            )
        ));
        $this->add(array(
            'name'=>'submit',
            'type'=>'submit',
           
            'attributes'=>array(
                'id'=>'submit',       
                'class'=>'btn btn-primary',
                'value'=>'ADD',
            )
        ));
        
        
        
    }
    
    
}
