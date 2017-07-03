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
                echo "hola mundo! bienvenido al curso de zend framework 2";
                die();
        }
        
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
                $usuarios =  $this->getUsuariosTable()->fetchAll();
                foreach($usuarios as $usuario){
                        var_dump($usuario);
                }
                
                 die();
        }
        //
        
}
