<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FormPruebas;
//Agregar componentes de validacion
use Zend\Validator;
//Validar si es alfanumerico, letra
use Zend\I18n\Validator as I18nValidator;

//SESIONES 
use Zend\Session\Container;

class IndexController extends AbstractActionController
{
        //Modelos y Entidades
        protected $usuariosTable;
        protected function getUsuariosTable(){
                if(!$this->usuariosTable){
                        //ERROR: Solucionado gracias a:
                            https://disqus.com/home/discussion/zfmanual/titledatabase_and_models_zend_framework_2_200_documentationtitle/newest/
                        //$sm =  $this->getServiceLocator();
                        $sm =  $this->serviceLocator;
                        //print_r($sm); die();
                        $this->usuariosTable = $sm->get("Application\Model\UsuariosTable");
                }
                
                return $this->usuariosTable;
        }
        //
    
        public function indexAction()
        {
                //echo "index"; die();
                return new ViewModel();
        }
        
        public function helloWorldAction(){
                $ejemplo = new \Ejemplo();
                echo $ejemplo->hello();
                die();
        }
        /*
        public function helloWorldAction(){
                echo "hola mundo! bienvenido al curso de zend framework 2";
                die();
        }
        */
        public function formAction(){
                /*$form = new FormPruebas("form");
                return new ViewModel(array(
                        "title" => "Formularios con Zend Framework 2",
                        "form" => $form
                )); */
            
                $form = new FormPruebas("form");
                
                $view = array(
                        "title" => "Formularios con Zend Framework 2",
                        "form" => $form
                );
                
                if($this->request->isPost()){
                        $form->setData($this->request->getPost());
                        
                        //Si el formulario no es valido
                        if(!$form->isValid()){
                                $errors = $form->getMessages();
                                $view["errors"] = $errors;
                        }
                }
                
                return new ViewModel($view);
        }
        
        public function getFormDataAction(){
                if( $this->request->getPost("submit") ){
                        $data = $this->request->getPost();
                        
                        //Validar el mail
                        $email = new Validator\EmailAddress();
                        $email->setMessage("El email '%value%' no es correcto ");
                        $validate_email = $email->isValid($this->request->getPost("email"));
                        
                        $alpha = new I18nValidator\Alpha();
                        $alpha->setMessage("El nombre '%value%' no son solo letras");
                        $validate_alpha = $alpha->isValid($this->request->getPost("nombre"));
                        
                        if($validate_email == true && $validate_alpha == true ){
                                $validate = "Validación de datos correcta";
                        }else{
                                $validate = array(
                                        $email->getMessages(),
                                        $alpha->getMessages()
                                );
                                var_dump($validate);
                                die();
                        }
                        
                        var_dump($data);
                        die();
                }else{
                        $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/form");
                }
                
        }
        
        
        //Modelos y Entidades
        public function listarAction(){
                //Obtener todos los usarios (objetos)
                /*
                $usuarios =  $this->getUsuariosTable()->fetchAll();
                foreach($usuarios as $usuario){
                        var_dump($usuario);
                }*/
            
                //CONSULTAS SQL NATIVO (array)
                $usuarios =  $this->getUsuariosTable()->fetchAllSql();
                foreach($usuarios as $usuario){
                        var_dump($usuario);
                }
            
                //Obtener al usuario con id 2
                /*
                $usuario =  $this->getUsuariosTable()->getUsuario(2);
                var_dump($usuario);
                */
                
                 die();
        }
        
        public function addAction(){
                
                $usuario = new \Application\Model\Usuario();
                
                $data = array(
                        "name" => "Luis",
                        "surname" => "Abanto",
                        "description" => "Soy Luis",
                        "email" => "labanto@gmail.com",
                        "password" => "labanto",
                        "image" => null,
                        "alternative" => null,
                );
                 
                $usuario->exchangeArray($data);
                
                $usuario_by_email = $this->getUsuariosTable()->getUsuarioByEmail($data['email']);
                
                if($usuario_by_email){
                        $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/listar");
                } else{
                        $save = $this->getUsuariosTable()->saveUsuario($usuario);
                }
                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/listar");
                
        }
        
        //Sesiones Prueba
        public function sesionesAction(){
                //-En lugar de hacer esto
                //$_SESSION["nombre"]  =  "HOLA";
                $sesion = new Container("sesion");
                
                if(!$sesion->id){
                        $sesion->id = 1;
                        $sesion->nombre = "Curso ZF2 Diego Abanto";
                }
                return array("sesion" => $sesion->id);
        }
        
        //Metodo que sea añadir un numero a la sesion
        public function addSesionAction(){
                $sesion =  new Container("sesion");
                $sesion->id++;
                /*return $this->redirect()->toRoute("application", array(
                                "controller" => "index",
                                "action" => "sesiones"
                        ));*/
                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/sesiones");
        }
        
        public function deleteSesionAction(){
                $sesion =  new Container("sesion");
                $sesion->id--;
                /*return $this->redirect()->toRoute("application", array(
                                "controller" => "index",
                                "action" => "sesiones"
                        ));*/
                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/sesiones");
        }
        
        public function langAction(){
                $lang_post = $this->params()->fromPost("lang", "es_ES");
                $lang =  new Container("lang");
                
                $lang->lang = $lang_post;
                
                //$translator = $this->getServiceLocator()->get("translator");
                $translator = $this->serviceLocator->get("translator");
                $translator->setLocale($lang->lang)->setFallbackLocale($lang->lang);
                
                $this->redirect()->toRoute("home");
                
        }
        
        //AJAX
        public function ajaxAction(){
                return new ViewModel();
        }
        
        public function loadAction(){
                if($this->request->isXmlHttpRequest()){
                        echo "Te devuelvo los datos";
                        die();
                } else{
                        $this->redirect()->toRoute("home");
                }
        }
        
}
