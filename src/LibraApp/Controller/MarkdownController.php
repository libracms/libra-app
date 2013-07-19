<?php

namespace LibraApp\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MarkdownController extends AbstractActionController
{
    /**
     * Transform markdown file and dislpay it
     * Allows files only from project directory
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction()
    {
        $errorMessage = sprintf('No file was selected. To choose file add in url "<b>?file=filename</b>".
            Filename can be without extension ".md"');
        $fileContent = null;
        $file = $this->params()->fromQuery('file');

        if ($file) {
            if (strpos($file, '.md', strlen($file) - 3) === false) {
                $file = $file . '.md';
            }

            if (!file_exists($file)) {
                $errorMessage = sprintf('File "<b>%s</b>" doesn\'t exists', $file);
            } elseif (false === strpos(realpath($file), realpath(getcwd()))) {
                    $errorMessage = 'You don\'t allowed to get files outside of project directory';
            } else {
                $fileContent = file_get_contents($file);
                $errorMessage = sprintf('Chosen file is "<b>%s</b>"', $file);
            }
        }

        return new ViewModel(array(
            'fileContent' => $fileContent,
            'errorMessage'   => $errorMessage,
        ));
    }
}
