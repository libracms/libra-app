<?php

namespace LibraApp\Form;

use Zend\Form\Form;

/**
 * Description of GeneralForm
 *
 * @author duke
 */
class AdminConfigGeneralForm extends Form
{
    public function __construct($name = 'config-general-form')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
            //->setElementsBelongTo('general[data]');

        $this->add(array(
            'name' => 'param0',
            'type' => 'Text',
            'options' => array(
                'label' => 'Param0',
            ),
        ));

        $this->add(array(
            'name' => 'param1',
            'type' => 'Text',
            'options' => array(
                'label' => 'Param1',
            ),
        ));

        $this->add(array(
            'name' => 'param2',
            'type' => 'Text',
            'options' => array(
                'label' => 'Param2',
            ),
        ));

        $this->add(array(
            'name' => 'param3',
            'type' => 'Text',
            'options' => array(
                'label' => 'Param3',
            ),
        ));

        $this->add(array(
            'name' => 'param4',
            'type' => 'Text',
            'options' => array(
                'label' => 'Param4',
            ),
        ));

        $this->add(array(
            'name' => 'csrf',
            'type' => 'Csrf',
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'options'    => array(
                'primary'    => true,
            ),
            'attributes' => array(
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}
