<?php

namespace LibraApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LocaleController extends AbstractActionController
{
    public function switchAction()
    {
        $sef = $this->request->getQuery('sef');
        $routeMatch = $this->getEvent()->getRouteMatch();
        $uri = $_SERVER['HTTP_REFERER'];
        $segment_options = array(
            'route'    => '/[:locale_sef/[:others]]',
            'constraints' => array(
                'locale_sef' => '[a-zA-Z][a-zA-Z0-9_-]{1,9}',
                'others'     => '.+',
            ),
            'defaults' => array(
                'locale_sef' => '', //for main page (/)
                'others' => '',
            ),
        );
        $router = \Zend\Mvc\Router\Http\Segment::factory($segment_options);
        $request = new \Zend\Http\Request();
        $request->setUri($uri);

        $routeMatch = $router->match($request);
        $params = $request->getUri()->getQuery();
        $others = $routeMatch->getParam('others');
        return $this->redirect()->toUrl(rtrim("/{$sef}/{$others}?$params", '?')); //@todo need fix for invalid uri: /ru/aaa+fd
    }

}
