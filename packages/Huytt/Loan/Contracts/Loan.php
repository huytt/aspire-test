<?php
namespace Huytt\Loan\Contracts;

interface Loan
{
    const FREQUENCY = 'weekly';
    const LOAN_STATUS_PENDING = 'pending';
    const LOAN_STATUS_APPROVE = 'approve';
    const LOAN_STATUS_PAID = 'paid';
}