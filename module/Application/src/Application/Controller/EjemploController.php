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
                /*
                $usuarios = $this->getUsuariosTable()->fetchAll();
            
                return new ViewModel(array(
                        "usuarios" => $usuarios
                ));
                 */
                 
                //Lo que devuelva tendra paginacion
                $paginator = $this->getUsuariosTable()->fetchAll(true);
                //Por defecto apuntara a la pagina 1
                $paginator->setCurrentPageNumber((int) $this->params()->fromQuery("page", 1));
                //Ahora le diremos a Paginator el numero de elementos por pagina
                $paginator->setItemCountPerPage(4);
                //Renderisamos la vista
                return new ViewModel(array(
                        "usuarios" => $paginator
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
                                //$this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/ejemplo");
                                $this->redirect()->toRoute("ejemplo", array("action" => "index"));
                        }
                }
                return new ViewModel($view);
        }
        
        public function editAction(){
                $id =  (int) $this->params()->fromRoute("id", 0);
                
                if(!$id){
                        $this->redirect()->toRoute("ejemplo");
                }
                
                $usuario = $this->getUsuariosTable()->getUsuario($id);
                if($usuario != true){
                        $this->redirect()->toRoute("ejemplo");
                }
                
                
                $form = new FormAddUsuarios("AddUsuarios");
                $form->bind($usuario);
                //Asignar valores al boton SUBMIT
                $form->get("submit")->setAttribute("value", "Editar");
                
                if($this->request->isPost()){
                        $post = $this->request->getPost();
                        
                        if(empty($this->request->getPost("password"))){
                                $post["password"] = $usuario->password;
                        } else{
                                //CIFRAR DATOS CON BCRYPT
                                $bcrypt = new Bcrypt(array(
                                        "salt" => "curso_zend_framework_2_victor_robles",
                                        "cost" => "6",
                                ));
                                $post["password"] = $bcrypt->create($this->request->getPost("password"));
                        }
                        $form->setData($post);
                        
                        if($form->isValid()){
                                $usuario_by_email = $this->getUsuariosTable()->getUsuarioByEmail(
                                        $this->request->getPost("email"));
                                
                                if($usuario_by_email && $usuario_by_email->id  != $usuario->id){
                                        //print_r("1"); die();
                                        $this->flashMessenger()->setNamespace("add_false")->addMessage("El usuario NO se ha editato, utiliza otro email");
                                }else{
                                        $save = $this->getUsuariosTable()->saveUsuario($usuario);
                                        //print_r($save); die();
                                        //MENSAJES FLASH
                                        if($save){
                                                $this->flashMessenger()->setNamespace("add")->addMessage("El usuario se ha editado correctamente");
                                        } /*else{
                                                $this->flashMessenger()->setNamespace("add_false")->addMessage("El usuario NO se ha creado");
                                        }*/
                                }
                        } else{
                                /*$view = array(
                                        "form" => $form
                                );*/
                            
                                $errors = $form->getMessages();
                                print_r($errors); die();
                                //En la vista metelo
                                //$view["errors"] = $errors;
                                
                                //return new ViewModel($view)
                        }
                        
                        $this->redirect()->toRoute("ejemplo");
                }
                
                return new ViewModel(array(
                        "id" => $id,
                        "form" => $form
                ));
        }
    
        public function deleteAction(){
                //Le pongo 0 para obligarlo a ser 0 por defecto
                $id = (int) $this->params()->fromRoute("id", 0);
                
                if(!$id){
                        $this->redirect()->toRoute("ejemplo");
                }else{
                        $delete = $this->getUsuariosTable()->deleteUsuario($id);
                        if($delete){
                                $this->flashMessenger()->setNamespace("add")->addMessage("El usuario se ha borrado correctamente");
                        } else{
                                $this->flashMessenger()->setNamespace("add_false")->addMessage("El usuario NO se ha borrado!!!");
                        }
                }
                
                return $this->redirect()->toRoute("ejemplo");
        }
        
}