<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use Zend\I18n\Validator as I18nValidator;

class FormAddUsuariosValidator extends InputFilter {

    public function __construct() {

        $this->add(array(
                "name" => "name",
                "required" => true,
                "filters" => array(
                        array("name" => "StripTags"), //Este filtro puede quitar las etiquetas XML y HTML del contenido dado
                        array("name" => "StringTrim"), //Que borre los espacios por delante y detras
                ),
                "validators" => array(
                        array(
                                "name" => "StringLength",
                                "options" => array(
                                        "encoding" => "UTF-8",
                                        "min" => "5",
                                        "max" => "20",
                                        "messages" => array(
                                                \Zend\Validator\StringLength::INVALID => "Tu nombre está mal",
                                                \Zend\Validator\StringLength::TOO_SHORT => "Tu nombre tiene que llevar más de 4 letras",
                                                \Zend\Validator\StringLength::TOO_LONG => "Tu nombre tiene que llevar menos de 20 letras",
                                        )
                                )
                        ),
                        array(
                                "name" => "Alpha",
                                "options" => array(
                                        "messages" => array(
                                                I18nValidator\Alpha::INVALID => "Tu nombre solo puede tener letras",
                                                I18nValidator\Alpha::NOT_ALPHA => "Tu nombre solo puede tener letras",
                                                I18nValidator\Alpha::STRING_EMPTY => "Tu nombre no puede estar vacío",
                                        )
                                )
                        )
                )
        ));

        $this->add(array(
                "name" => "surname",
                "required" => true,
                "filters" => array(
                        array("name" => "StripTags"), //Este filtro puede quitar las etiquetas XML y HTML del contenido dado
                        array("name" => "StringTrim"), //Que borre los espacios por delante y detras
                ),
                "validators" => array(
                        array(
                                "name" => "StringLength",
                                "options" => array(
                                        "encoding" => "UTF-8",
                                        "min" => "5",
                                        "max" => "20",
                                        "messages" => array(
                                                \Zend\Validator\StringLength::INVALID => "Tu apellido está mal",
                                                \Zend\Validator\StringLength::TOO_SHORT => "Tu apellido tiene que llevar más de 4 letras",
                                                \Zend\Validator\StringLength::TOO_LONG => "Tu apellido tiene que llevar menos de 20 letras",
                                        )
                                )
                        ),
                        array(
                                "name" => "Alpha",
                                "options" => array(
                                        "messages" => array(
                                                I18nValidator\Alpha::INVALID => "Tu apellido solo puede tener letras",
                                                I18nValidator\Alpha::NOT_ALPHA => "Tu apellido solo puede tener letras 2",
                                                I18nValidator\Alpha::STRING_EMPTY => "Tu apellido no puede estar vacío",
                                        )
                                )
                        )
                )
        ));

        $this->add(array(
                "name" => "description",
                "required" => true,
                "filters" => array(
                        array("name" => "StripTags"), //Este filtro puede quitar las etiquetas XML y HTML del contenido dado
                        array("name" => "StringTrim"), //Que borre los espacios por delante y detras
                ),
                "validators" => array(
                        array(
                                "name" => "StringLength",
                                "options" => array(
                                        "allowWhiteSpace" => true, //permitir espacios en blanco
                                        "encoding" => "UTF-8",
                                        "min" => "1",
                                        "messages" => array(
                                                \Zend\Validator\StringLength::INVALID => "Mete bien la descripción",
                                                \Zend\Validator\StringLength::TOO_SHORT => "Mete bien la descripción",
                                                //\Zend\Validator\StringLength::TOO_LONG => "Tu nombre tiene que llevar menos de 20 letras",
                                        )
                                )
                        ),
                )
        ));

        $this->add(array(
                "name" => "email",
                "required" => true,
                "filter" => array(
                        array("name" => "StringTrim")
                ),
                "validators" => array(
                        array(
                                "name" => "EmailAddress",
                                "options" => array(
                                        "allowWhiteSpace" => true, //permitir espacios en blanco
                                        "messages" => array(
                                                \Zend\Validator\EmailAddress::INVALID_HOSTNAME => "Email no válido"
                                        )
                                )
                        )
                )
        ));
    }

}
