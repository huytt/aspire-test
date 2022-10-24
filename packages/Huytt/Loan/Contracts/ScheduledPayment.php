<?php
namespace Huytt\Loan\Contracts;

interface ScheduledPayment
{
    const SCHEDULED_PAYMENT_STATUS_PENDING = 'pending';
    const SCHEDULED_PAYMENT_STATUS_APPROVE = 'approve';
    const SCHEDULED_PAYMENT_STATUS_PAID = 'paid';
}