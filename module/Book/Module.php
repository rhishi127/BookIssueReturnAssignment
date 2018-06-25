<?php
/**
 * File manages Module level configuarations factories and invocable
 * @package    Book
 * @author     Rhishikesh Jadhav
 * 
 */

namespace Book;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Book\Model\Book;
use Book\Model\BookTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig(){
        return array (
            'factories' => array(
                'BookTable'=>function($sm){
                  $tableGateway = $sm->get('BookTableGateway');
                  $table = new Model\BookTable($tableGateway);
                  return $table;
                },
                'BookTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Book());
                    return new TableGateway('book', $dbAdapter, null, $resultSetPrototype);
                },
            )
        );        
    }
    
    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
