<?php
namespace AppBundle\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ValidatorException
 * @package AppBundle\Exceptions
 */
class ValidatorException extends \Exception
{
    protected $errors;

    /**
     * InvalidFormException constructor.
     * @param ConstraintViolationListInterface $errors
     */
    public function __construct(ConstraintViolationListInterface $errors)
    {
        $this->errors = $errors;

        parent::__construct();
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getErrors() {
        return $this->errors;
    }

}