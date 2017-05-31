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

class PruebasController extends AbstractActionController
{
    public function indexAction()
    {
        
        $id = $this->params()->fromRoute("id", "POR DEFECTO");
        $id2 = $this->params()->fromRoute("id2", "POR DEFECTO 2");
        
        //if ($id == "POR DEFECTO"){
                //return $this->redirect()->toRoute("home");
                /*return  $this->redirect()->toUrl(
                        $this->getRequest()->getBaseUrl()
                        );
                 * 
                 */
                 //return $this->redirect()->toUrl("http://www.google.com");
        //}
        
        $this->layout("layout/prueba");
        
        $this->layout()->parametro="Hola que tal?";
        $this->layout()->title="Plantilla en Zend Framework 2";
        
        return new ViewModel(array(
            "texto" => "Vista del nuevo metodo action del nuevo controlador",
            "id" => $id,
            "id2" => $id2,
        ));
    }
    
    public function verDatosAjaxAction(){
        $view= new ViewModel();
        
        $view->setTerminal(true); //Es como decirle, no cargues los estilos, no cargues la plantilla
        return $view;
    }
    
}
