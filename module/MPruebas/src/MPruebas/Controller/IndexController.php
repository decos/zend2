<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace MPruebas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', 'on');
        
        return new ViewModel();
    }
    
    public function helloWorldAction(){
        echo "hola mundo! bienvenido al curso de zend framework 2";
        die();
    }
}
