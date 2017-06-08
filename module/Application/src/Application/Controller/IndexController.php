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

class IndexController extends AbstractActionController
{
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
                $form = new FormPruebas("form");
                return new ViewModel(array(
                        "title" => "Formularios con Zend Framework 2",
                        "form" => $form
                ));
        }
        
        public function getFormDataAction(){
                
                $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/form");
        }
        
        
}
