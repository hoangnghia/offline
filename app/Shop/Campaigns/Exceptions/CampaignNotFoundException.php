<?php

namespace App\Shop\Employees\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampaignNotFoundException extends NotFoundHttpException
{

    /**
     * EmployeeNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Campaign not found.');
    }
}
