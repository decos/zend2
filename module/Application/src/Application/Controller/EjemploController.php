<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FormAddUsuarios;
//CIFRAR DATOS CON BCRYPT
use Zend\Crypt\Password\Bcrypt;

class EjemploController extends AbstractActionController
{
        protected $usuariosTable;   
        
        protected function getUsuariosTable(){
                if(!$this->usuariosTable){
                        //$sm = $this->getServiceLocator();
                        $sm =  $this->serviceLocator;
                        $this->usuariosTable = $sm->get("Application\Model\UsuariosTable");
                }
                
                return $this->usuariosTable;
        }

        public function indexAction()
        {
                //echo "Ejemplo";
                
                $usuarios = $this->getUsuariosTable()->fetchAll();
            
                return new ViewModel(array(
                        "usuarios" => $usuarios
                ));
        }
    
        
        public function addAction(){
                $form = new FormAddUsuarios("AddUsuarios");
                $view = array(
                        "form" => $form
                );
                
                //Si nos ha llegado el POST
                if($this->request->isPost()){
                        //Coger todo lo del post y rellene e formulario
                        $form->setData($this->request->getPost()); 
                        //Si el formulario no es valido
                        if(!$form->isValid()){
                                //Mandame un array con los error
                                $errors = $form->getMessages();
                                //En la vista metelo
                                $view["errors"] = $errors;
                        } else{
                                
                                $usuario = new \Application\Model\Usuario();
                
                                //CIFRAR DATOS CON BCRYPT
                                $bcrypt = new Bcrypt(array(
                                        "salt" => "curso_zend_framework_2_victor_robles",
                                        "cost" => "6",
                                ));
                                $password = $bcrypt->create($this->request->getPost("password"));
                                
                                $data = array(
                                        "name" => $this->request->getPost("name"),
                                        "surname" => $this->request->getPost("surname"),
                                        "description" => $this->request->getPost("description"),
                                        "email" => $this->request->getPost("email"),
                                        "password" => $password,
                                        "image" => null,
                                        "alternative" => null,
                                );

                                $usuario->exchangeArray($data);

                                $usuario_by_email = $this->getUsuariosTable()->getUsuarioByEmail($data['email']);

                                if($usuario_by_email){
                                        $this->flashMessenger()->setNamespace("add_false")->addMessage("El usuario NO se ha creado");
                                } else{
                                        $save = $this->getUsuariosTable()->saveUsuario($usuario);
                                        //MENSAJES FLASH
                                        if($save){
                                                $this->flashMessenger()->setNamespace("add")->addMessage("El usuario se ha creado correctamente");
                                        } else{
                                                $this->flashMessenger()->setNamespace("add_false")->addMessage("El usuario NO se ha creado");
                                        }
                                        
                                }
                                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/ejemplo");

                            
                        }
                }
                
                return new ViewModel($view);
        }
    
}