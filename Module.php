<?php

namespace LibraApp;

use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;
use Zend\Console\Console;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Version\Version as ZendVersion;

class Module
{
    /**
     * root path of moodule
     */
    const DIR = __DIR__;

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

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'LibraApp\Service\Updater' => 'LibraApp\Service\Updater',
            ),
        );
    }

    public function appBootstrap(MvcEvent $e)
    {
        if ($this->isAdminLoaded) return; //fix for Controller: libra-article/admin-(resolves to invalid controller class or alias: libra-article/admin-)
        $e->getViewModel()->setTemplate('layout/' . $this->config['layoutName'] . '/layout');
        $sm = $e->getApplication()->getServiceManager();
        //$translator   = $sm->get('translator');

        //Fix of set correct sl for menu helper
        $phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        $helper = $phpRenderer->navigation('navigation')->findHelper('menu');
        $helper->setServiceLocator($sm);

        //$navigation   = $sm->get('navigation');
        //$phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        //$helperMenu   = $phpRenderer->navigation($navigation)->findHelper('menu');
        //$helperMenu->setUlClass('nav nav-list');
    }

    /**
     * Load admin layout and configs
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function adminBootstrap(MvcEvent $e)
    {
        $e->getViewModel()->setTemplate('layout/admin-' . $this->config['adminLayoutName'] . '/layout');
        $sm = $e->getApplication()->getServiceManager();
        //$translator   = $sm->get('translator');
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
        if (!Console::isConsole()) {
            $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminRouterListener'), 1);
            $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminAppListener'), 1);
            $em->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'appBootstrap'));  //configure as application at route error
        }
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'setModuleAwareRouter'), 1);
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($em);
    }

    /**
     * add admin- prefix to route admin-default and others admin- routers
     * @param MvcEvent $e
     */
    public function adminRouterListener(MvcEvent $e)
    {
        $routeMatch      = $e->getRouteMatch();
        $controllerName  = $routeMatch->getParam('controller');
        $moduleNamespace = $routeMatch->getParam(ModuleRouteListener::MODULE_NAMESPACE);
        if (
            (strpos($routeMatch->getMatchedRouteName(), 'admin/') === 0
                || $routeMatch->getMatchedRouteName() === 'admin')
            && stripos($controllerName, 'admin') !== 0
            && stripos($controllerName, 'Controller\Admin') === false
            && stripos($moduleNamespace, 'Controller\Admin') === false
        ) {
            $routeMatch->setParam('controller', 'admin-' . $controllerName);
        }
    }

    /**
     * Determines if controller consists in children of admin router
     * and if so then runs $this->adminBootstrap()
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function adminAppListener(MvcEvent $e)
    {
        $routeMatch      = $e->getRouteMatch();
        //$controllerName  = $routeMatch->getParam('controller');
        //$moduleNamespace = $routeMatch->getParam(ModuleRouteListener::MODULE_NAMESPACE);
        if (
            (strpos($routeMatch->getMatchedRouteName(), 'admin/') === 0
                || $routeMatch->getMatchedRouteName() === 'admin')
            //|| stripos($controllerName, 'admin') === 0
            //|| stripos($moduleNamespace, 'Controller\Admin') !== false //@todo clean up after ver. 0.5.0
        ) {
            //check permissions and do redirect to login logaction
            $rbacRoleService = $e->getApplication()->getServiceManager()->get('ZfcRbac\Service\RoleService');
            if (!$rbacRoleService->matchIdentityRoles(['manager'])) {
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
        } else {
            $this->appBootstrap($e);
        }
        return;
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
            // Copy to NS to work any other
            $routeMatch->setParam(ModuleRouteListener::MODULE_NAMESPACE, $moduleName);
        }
    }

    public function getConsoleBanner(ConsoleAdapter $console)
    {
        return sprintf("Libra CMS\nZend Framework %s", ZendVersion::VERSION);
    }
}
