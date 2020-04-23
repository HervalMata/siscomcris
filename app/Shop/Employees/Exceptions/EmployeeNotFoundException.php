<?php


namespace App\Shop\Employees\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeNotFoundException extends NotFoundHttpException
{

    /**
     * CustomerNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Funcionário não encontrado.');
    }
}
