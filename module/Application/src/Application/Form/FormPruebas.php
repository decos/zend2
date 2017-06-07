<?php

namespace Application\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class FormPruebas extends Form{
    
    public function __construct($name = null) {
        //Constructor del Padre tendra el nombre que le pasemos
        parent::__construct($name); 
        
        //Primer campo creado
        $this->add(array(
            "name" => "nombre",
            "options" => array(
                "label" => "Nombre: "
            ),
            "attributes" => array(
                "type" => "text",
                "class" => "form-control"
            )
        ));
        //
        
        //Segundo campo creado
        //Tambien se puede usar el "factory"
        $factory = new Factory;
        $email = $factory->createElement(array(
            "type" => "Zend\Form\Element\Email",
            "name" => "email",
            "options" => array(
                "label" => "Email: "
            ),
            "attributes" => array(
                "class" => "form-control",
                "id" => "email-input"
            )
        ));
        $this->add($email);
        //
        
        //Tercer campo creado
        $this->add(array(
            "name" => "submit",
            "attributes" => array(
                "type" => "submit",
                "value" => "Enviar",
                "title" => "Enviar"
            )
        ));
        //
    }
}