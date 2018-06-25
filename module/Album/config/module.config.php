<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Index' => 'Album\Controller\IndexController'
        ),
    ),
      'router' => array(
        'routes' => array(
            'album' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/album',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Album\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id][/:yid][/:yer]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[a-zA-Z0-9_-]*',
                             ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'Album\Controller',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'factories' => array(
            'formelementerrors' => function($vhm) {
                $fee = new \Zend\Form\View\Helper\FormElementErrors();
                $fee->setAttributes([
                    'class' => 'error'
                ]);
                return $fee;
            },
    )),                
    
);
