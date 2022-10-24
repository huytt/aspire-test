<?php

namespace Huytt\Loan\Repositories;

use Huytt\Core\Eloquent\Repository;
use Huytt\Loan\Contracts\Loan;
use Mockery\Exception;

class LoanRepository extends Repository
{
    public function model(): string
    {
        return Loan::class;
    }

    /**
     * @param array $with
     * @return LoanRepository
     */
    public function meList($with = []): LoanRepository
    {
        return $this->with($with)->scopeQuery(function ($query) {
            return $query->where('user_id', auth()->user()->id);
        });
    }

    public function approve($id) {
        if(!auth('admin-api')->check()) {
            throw new Exception('Unauthorized', 401);
        }

        return $this->update(['status' => Loan::LOAN_STATUS_APPROVE], $id);
    }
}
