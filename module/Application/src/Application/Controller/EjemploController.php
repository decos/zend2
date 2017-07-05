<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EjemploController extends AbstractActionController
{
        public function indexAction()
        {
                echo "Ejemplo";
                die();
        }
    
    
}