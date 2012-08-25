<?php

/*
 * eJoom.com
 * This source file is subject to the new BSD license.
 */

namespace LibraApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of AdminDashboard
 *
 * @author duke
 */
class AdminIndexController extends AbstractActionController
{
    public function indexAction()
    {
        //run code;
    }

    public function dispatch(\Zend\Stdlib\RequestInterface $request, \Zend\Stdlib\ResponseInterface $response = null)
    {
        $user = $this->zfcuserauthentication()->getIdentity();
        if (!$user) {
            $this->layout()->setTemplate('layout/admin-default/login-layout');
            return $this->redirect()->toRoute('zfcuser/login');
            return $this->redirect()->toRoute('admin/libra-app/login');
        }
        return parent::dispatch($request, $response);
    }

}
