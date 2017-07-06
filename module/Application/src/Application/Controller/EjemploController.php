<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FormAddUsuarios;

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
                
                if($this->request->isPost()){
                        $form->setData($this->request->getPost()); //recoja todo lo del formulario
                        
                        if(!$form->isValid()){
                                $errors = $form->getMessages();
                                $view["errors"] = $errors;
                        } else{
                                
                        }
                }
                
                return new ViewModel($view);
        }
    
}