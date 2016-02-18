<?php

namespace AppBundle\Exceptions;

use Symfony\Component\Form\Form;

class InvalidFormException extends \Exception
{
    protected $form;

    /**
     * InvalidFormException constructor.
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;

        parent::__construct();
    }

    /**
     * @return Form
     */
    public function getForm() {
        return $this->form;
    }

}