<?php

namespace Huytt\Loan\Models;

use Huytt\Core\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Huytt\Loan\Contracts\ScheduledPayment as ScheduledPaymentContract;
class ScheduledPayment extends Model implements ScheduledPaymentContract
{
    use HasFactory, Uuid;
    protected $table = 'scheduled_payments';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'loan_id',
        'date',
        'amount',
        'amount_paid',
        'status'
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
