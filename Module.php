<?php

namespace LibraApp;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public $config;
    protected $isAdminLoaded = false;

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

   public function getViewHelperConfig()
    {
        return array(
            'aliases' => array(
                //'_'  => 'translate',
                //'__' => 'translatePlural',
            ),
            'invokables' => array(
                //'_' => 'Zend\I18n\View\Helper\Translate',
                //'__' => 'Zend\I18n\View\Helper\TranslatePlural',
            ),
        );
    }

    public function appBootstrap($e)
    {
        if ($this->isAdminLoaded) return; //fix for Controller: libra-article/admin-(resolves to invalid controller class or alias: libra-article/admin-)
        $e->getViewModel()->setTemplate('layout/' . $this->config['layoutName'] . '/layout');
        $sm = $e->getApplication()->getServiceManager();
        $translator   = $sm->get('translator');

        //Fix of set correct sl for menu helper
        $phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        $helper = $phpRenderer->navigation('navigation')->findHelper('menu');
        $helper->setServiceLocator($sm);

        //$navigation   = $sm->get('navigation');
        //$phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        //$helperMenu   = $phpRenderer->navigation($navigation)->findHelper('menu');
        //$helperMenu->setUlClass('nav nav-list');
    }

    public function adminBootstrap($e)
    {
        $e->getViewModel()->setTemplate('layout/admin-' . $this->config['adminLayoutName'] . '/layout');
        $sm = $e->getApplication()->getServiceManager();
        $translator   = $sm->get('translator');
        $navigation   = $sm->get('AdminNavigation');

        $phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        $helperMenu   = $phpRenderer->navigation($navigation)->findHelper('menu');
        $helperMenu->setUlClass('nav');
        $this->isAdminLoaded = true;
    }

    /**
     * executes on boostrap
     * @param \Zend\Mvc\MvcEvent $e
     * @return null
     */
    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $config = $sm->get('config');
        $this->config = $config['libra_app'];

        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminRouterListener'), 1);
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminAppListener'), 1);
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'setModuleAwareRouter'), 1);
        $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'appBootstrap'));  //configure as application at route error
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($em);
    }

    /**
     * add admin- prefix to route admin-default and others admin- routers
     * @param MvcEvent $e
     */
    public function adminRouterListener(MvcEvent $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        if (strpos($routeMatch->getMatchedRouteName(), 'admin/') === 0
                && (stripos($controllerName, 'admin') !== 0)) {
            $routeMatch->setParam('controller', 'admin-' . $controllerName);
        }
    }

    /**
     * Checks controller name to contain admin- prefix
     * and add admin configurations like layout
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function adminAppListener(MvcEvent $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        if (strpos($routeMatch->getMatchedRouteName(), 'admin/' === 0)
                || stripos($controllerName, 'admin') === 0) {
            //check permissions and do redirect to login logaction
            if (!$user = $e->getApplication()->getServiceManager()->get('zfcuser_auth_service')->getIdentity()) {
                $_SESSION['tried_url'] = $_SERVER['REQUEST_URI'];
                $flashMessenger = new \Zend\Mvc\Controller\Plugin\FlashMessenger();
                $flashMessenger->setNamespace('zfcuser-login-form')->addMessage('Restricted area. You should login first');
                $router = $e->getRouter();
                $url = $router->assemble(array(), array('name' => 'zfcuser/login'));
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);
                return $response;
            }
            $this->adminBootstrap($e);
            return;
        }
        $this->appBootstrap($e);
    }

    /**
     * set router scheme to /module-name/controller-name/action
     * @param MvcEvent $e
     */
    public function setModuleAwareRouter(MvcEvent $e)
    {
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        $moduleName     = $routeMatch->getParam('module');
        if ($moduleName && $controllerName) {
            $controllerName = $moduleName . '/' . $controllerName;
            $routeMatch->setParam('controller', $controllerName);
        }
    }

}
