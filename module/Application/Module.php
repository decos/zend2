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
        //Metodo que se lanza al cargar el modulo
        public function onBootstrap(MvcEvent $e)
        {
                $eventManager        = $e->getApplication()->getEventManager();
                $moduleRouteListener = new ModuleRouteListener();
                $moduleRouteListener->attach($eventManager);
                
                //AUTORIZACION
                $this->initAcl($e);
                $e->getApplication()->getEventManager()->attach("route", array($this, "checkAcl"));
                
                //CAMBIAR DE IDIOMA DESDE LA WEB
                $translator = $e->getApplication()->getServiceManager()->get("translator");
                $lang = new \Zend\Session\Container("lang");
                $translator->setLocale($lang->lang)->setFallbackLocale($lang->lang);
        }

        //FUNCION 1
        public function initAcl(MvcEvent $e){
                $acl = new \Zend\Permissions\Acl\Acl();
                $roles = require_once 'module/Application/config/acl.roles.php';
                
                foreach ($roles as $role => $resources){
                        $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
                        $acl->addRole($role);
                        
                        foreach($resources["allow"] as $resource){
                                if(!$acl->hasResource($resource)){
                                        $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                                }
                                
                                $acl->allow($role, $resource);
                        }
                        
                        foreach($resources["deny"] as $resource){
                                if(!$acl->hasResource($resource)){
                                        $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                                }
                                
                                $acl->deny($role, $resource);
                        }
                }
                
                $e->getViewModel()->acl = $acl;
        }
        
        //FUNCION 2
        //Comprobar si el permiso que tiene el usuario esta en la ACL
        public function checkAcl(MvcEvent $e){
                // Coger la ruta en la que estamos ahora
                $route = $e->getRouteMatch()->getMatchedRouteName();

                $auth = new \Zend\Authentication\AuthenticationService();
                $identity =  $auth->getStorage()->read();

                if($identity != false && $identity != null){
                        $userRole = "admin";
                } else{
                        $userRole = "visitante";
                }
                
                if(!$e->getViewModel()->acl->isAllowed($userRole, $route)){
                        $response = $e->getResponse();
                        $response->getHeaders()->addHeaderLine("Location", 
                                $e->getRequest()->getBaseUrl()."/404");
                        $response->setStatusCode(404);
                }
                
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
