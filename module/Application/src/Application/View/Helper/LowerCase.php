<?php

namespace Application\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class LowerCase extends AbstractHelper{
    // _invoke = Es como un constructor que se ejecuta cuando llamas a la clase LowerCase
    
   public function __invoke($str){
        return trim(strtolower($str));
   }
   
   
    
    
}