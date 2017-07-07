<?php

namespace Application\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class FormAddUsuarios extends Form{
    
    public function __construct($name = null) {
        //Constructor del Padre tendra el nombre que le pasemos
        parent::__construct($name); 
        
        $this->setInputFilter(new \Application\Form\FormAddUsuariosValidator());
        
        //Primer campo creado
        $this->add(array(
                "name" => "name",
                "options" => array(
                        "label" => "Nombre: "
                ),
                "attributes" => array(
                        "type" => "text",
                        "class" => "form-control"
                )
        ));
        
        $this->add(array(
                "name" => "surname",
                "options" => array(
                        "label" => "Apellidos: "
                ),
                "attributes" => array(
                        "type" => "text",
                        "class" => "form-control"
                )
        ));
        
        $this->add(array(
                "name" => "description",
                "options" => array(
                        "label" => "Descripción: "
                ),
                "attributes" => array(
                        "type" => "textarea",
                        "class" => "form-control"
                )
        ));
        
        $this->add(array(
                "name" => "email",
                "options" => array(
                        "label" => "Email: "
                ),
                "attributes" => array(
                        "type" => "email",
                        "class" => "form-control"
                )
        ));
        
        $this->add(array(
                "name" => "password",
                "options" => array(
                        "label" => "Contraseña: "
                ),
                "attributes" => array(
                        "type" => "password",
                        "class" => "form-control"
                )
        ));
        
        //Prueba campo SUBMIT
        $this->add(array(
            "name" => "submit",
            "attributes" => array(
                "type" => "submit",
                "value" => "Enviar",
                "title" => "Enviar"
            )
        ));
    }
}