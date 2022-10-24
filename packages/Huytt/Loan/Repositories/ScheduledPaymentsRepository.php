<?php

namespace Huytt\Loan\Repositories;

use Huytt\Core\Eloquent\Repository;
use Huytt\Loan\Contracts\ScheduledPayment;

class ScheduledPaymentsRepository extends Repository
{
    public function model(): string
    {
        return ScheduledPayment::class;
    }
}
