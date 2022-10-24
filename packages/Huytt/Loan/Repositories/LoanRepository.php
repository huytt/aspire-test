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

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function getById($id) {
        $loan = $this->findOneWhere(['id' => $id]);
        if(!$loan) {
            throw new \Exception("$id is not exist", 400);
        }

        return $loan;
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
}
