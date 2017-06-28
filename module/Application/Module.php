<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

//Agregar
use Zend\Db\ResultSet\ResultSet; //Devolver las cosas de cada registro
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Usuario; //Entidad
use Application\Model\UsuariosTable; //Operaciones con base de datos
//

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

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    //Metodo que cada vez que queremos modelos y entidades tenemos que agregarlo aqui
    public function getServiceConfig(){
        return array(
                "factories" => array(
                        "Application\Model\UsuariosTable" => function($sm){ //sm = Service Manager
                                //Obtenemos el UsuarioTableGateway
                                $tableGateway = $sm->get("UsuariosTableGateway");
                                //Creamos un objeto UsuariosTable y le pasamos y el tableGateway
                                $table =  new UsuariosTable($tableGateway);
                                return $table;
                        },
                        //Definimos el UsuariosTableGateway para q funcione lo de arriba
                        "UsuariosTableGateway" => function($sm){
                                //Use la configuracion de base de datos
                                $dbAdapter = $sm->get("Zend\Db\Adapter\Adapter"); 
                                //Use el resulset para devolver resultados
                                $resultSetPrototype = new ResultSet(); 
                                //el prototipo de entidad del modelo de tipo tablegateway es la entidad Usuario
                                $resultSetPrototype->setArrayObjectPrototype(new Usuario()); 
                                //Usa la tabla usuario, usa la conexion de dbAdapter y usa como prototipo el 
                                //resultSetPrototype con la entidad Usuario
                                return new TableGateway("usuarios", $dbAdapter, null, $resultSetPrototype); 
                        }      
                )
        );
    }
    
}
