<?php

namespace LibraApp;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';
        $config['di']['instance'] = include __DIR__ . '/config/di.php';
        $config = array_merge_recursive($config, include __DIR__ . '/config/libra-app.php');
        return $config;
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

    protected function appBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $e->getViewModel()->setTemplate('layout/default/layout');
        $translator   = $sm->get('translator');
        $navigation   = $sm->get('navigation');

        $phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        $helperMenu   = $phpRenderer->navigation($navigation)->findHelper('menu');
        $helperMenu->setUlClass('nav nav-list');
    }

    protected function adminBootstrap($e)
    {
        $e->getViewModel()->setTemplate('admin-layout/default/layout');
        $sm = $e->getApplication()->getServiceManager();
        $translator   = $sm->get('translator');
        $navigation   = $sm->get('AdminNavigation');

        $phpRenderer  = $sm->get('Zend\View\Renderer\PhpRenderer');
        $helperMenu   = $phpRenderer->navigation($navigation)->findHelper('menu');
        $helperMenu->setUlClass('nav');
    }

    /**
     * executes on boostrap
     * @param \Zend\Mvc\MvcEvent $e
     * @return null
     */
    public function onBootstrap(MvcEvent $e)
    {
        $em = $e->getApplication()->getEventManager();
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminRouterListener'), 1);
        $em->attach(MvcEvent::EVENT_ROUTE, array($this, 'adminAppListener'), 1);
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
        $routeMatch     = $e->getRouteMatch();
        $controllerName = $routeMatch->getParam('controller');
        if ( strpos($routeMatch->getMatchedRouteName(), 'admin') === 0
                && (strpos($controllerName, 'admin-') !== 0)) {
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
        if ($routeMatch->getMatchedRouteName() !== 'admin-default'
                && strpos($controllerName, 'admin') !== 0) {
            $this->appBootstrap($e);
            return;
        }
        $this->adminBootstrap($e);
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
