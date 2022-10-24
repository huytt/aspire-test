<?php

namespace Huytt\Loan\Repositories;

use Huytt\Core\Eloquent\Repository;
use Huytt\Loan\Contracts\Loan;

class LoanRepository extends Repository
{
    public function model(): string
    {
        return Loan::class;
    }
}
