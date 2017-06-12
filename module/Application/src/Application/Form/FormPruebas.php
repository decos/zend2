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
        
        $this->setInputFilter(new \Application\Form\FormPruebasValidator());
        
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
        
        //Segundo campo creado
        //Tambien se puede usar el "factory"
        /*$factory = new Factory;
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
        $this->add($email); */
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
        
        //Prueba campo SELECT
        $this->add(array(
                'type' => 'Select',
                'name' => 'activo',
                'options' => array(
                        'label' => 'Activo: ',
                        'value_options' => array(
                                'si' => 'Si',
                                'no' => 'No'
                        ),
                ),
                'attributes' => array(
                        'value' => 'si', //marcar por defecto
                        'required' => 'required',
                        'class' => 'form-control'
                )
        ));
        
        //Prueba campo RADIO
        $this->add(array(
                "type" => "radio",
                "name" => "estado",
                "options" => array(
                        'value_options' => array(
                                'publico' => 'Público',
                                'seguidores' => 'Solo seguidores'
                        ),
                ),
                "attributes" => array(
                        "value" => "publico",   //marcar por defecto a publico
                        "required" => "required"
                )
        ));
        
        //Prueba campo CHECKBOX
        $this->add(array(
                "type" => "Checkbox",
                "name" => "documento",
                "options" => array(
                        "label" => "Documento",
                        "use_hidden_element" => false, //input hidden
                        "checked_value" => "si" //valor
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