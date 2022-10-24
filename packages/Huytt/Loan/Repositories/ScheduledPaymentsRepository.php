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
}
