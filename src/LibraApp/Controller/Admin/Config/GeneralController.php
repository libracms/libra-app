<?php

namespace LibraApp\Controller\Admin\Config;

use LibraApp\Form\AdminConfigGeneralForm;
use Zend\Config\Exception\RuntimeException;
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
    const PATH = 'config/config.php';

    protected function save($values)
    {
        $file = self::PATH;
        $writer = new PhpArray();
        $values = array('config' => array(
                'general' => array(
                    'data' => $values))
        );
        $config = include $file;
        $values = array_replace_recursive($config, $values);
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
        $form = new AdminConfigGeneralForm();
        if ($this->getRequest()->isPost()) {
            $post = $this->params()->fromPost();
            $form->setData($post);
            if ($form->isValid($post)) {
                $data = $form->getData();
                unset($data['csrf']);
                unset($data['submit']);
                $res = $this->save($data);
            }
        } else {
            $file = self::PATH;
            $config = include $file;
            $form->setData($config['config']['general']['data']);
        }

        return new ViewModel(array(
            'form'   => $form,
            'formErrorMessages' => $this->flashMessenger()->setNamespace('general-form')->getCurrentMessages(),
        ));
    }
}
