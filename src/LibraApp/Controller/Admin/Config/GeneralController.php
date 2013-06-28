<?php

namespace LibraApp\Controller\Admin\Config;

use Zend\Config\Writer\PhpArray;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Description of General
 *
 * @author duke
 */
class GeneralController extends AbstractActionController
{
    protected function save($values)
    {
        $file = '../config/config.php';
        $writer = new PhpArray();
        try {
            $writer->toFile($file, $values);
        } catch (RuntimeException $exc) {
            $this->flashMessenger()->setNamespace('general-form')->addMessage('Can\'t save file');
            return false;
        }
        $this->flashMessenger()->setNamespace('general-form')->addMessage('Gonfiguration was saved');
        return true;
    }

    public function viewAction()
    {
        $view = new ViewModel(array(

        ));
        //$view->setTemplate('libra-app/admin/config/general/view');

        return $view;
    }

    public function editAction()
    {
        if (!$this->hasPermition()) {
            return $this->AccessDenied();
        }
        $form = new GeneralForm();
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->post()->toArray();
            if ($form->isValid($post)) {
                $res = $this->save($form->getValues());
            }
        } else {
            $file = '../config/config.php';
            $config = include $file;
            $form->setDefaults($config);
        }

        return new ViewModel(array(
            'form'   => $form,
            'formErrorMessages' => $this->flashMessenger()->setNamespace('general-form')->getCurrentMessages(),
        ));
    }
}
