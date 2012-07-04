<?php

namespace LibraApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $l = $this->layout();
        $this->layout()->routeMatch = $this->getEvent()->getRouteMatch();
        //$this->layout()->setVariable('routeMatch', $this->getEvent()->getRouteMatch());
        $this->layout()->router     = $this->getEvent()->getRouter();
        return new ViewModel();
    }
}
