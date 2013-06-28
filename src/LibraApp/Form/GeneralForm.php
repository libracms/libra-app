<?php

namespace LibraApp\Form;

use Zend\Form\Form;

/**
 * Description of GeneralForm
 *
 * @author duke
 */
class GeneralForm extends Form
{
    public function __construct($name = 'general-form')
    {
        parent::__construct($name);
        $this->setAttribute('method', 'post');
            //->setElementsBelongTo('general[data]');

        $this->add(array(
            'name' => 'datum',
            'type' => 'Text',
            'options' => array(
                'label' => 'Datum',
            ),
        ));

//        $this->add(array(
//            'name' => 'csrf',
//            'type' => 'Csrf',
//            'options' => array(
//            ),
//        ));

        //$csrf = new Element\Csrf('csrf');
        //$this->add($csrf);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}
