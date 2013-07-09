<?php

namespace LibraApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

/**
 * Help update Libra CMS by versions
 */
class UpdaterController extends AbstractActionController
{
    public function updateAction()
    {
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest){
            throw new RuntimeException('You can only use this action from a console!');
        }

        $versionFrom = $this->params('version-from');
        $versionTo = $this->params('version-to');

        if (version_compare($versionFrom, '0.3.5', '<=')) {
            $service = $this->getServiceLocator()->get('LibraApp\Service\Updater');
            $service->updateIfFromLE035();
        echo "Article DB updated\n";
        }

        return 0;
    }
}
