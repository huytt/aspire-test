<?php

namespace Huytt\Loan\Models;

use Huytt\Core\Traits\Uuid;
use Huytt\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Huytt\Loan\Contracts\Loan as LoanContract;

class Loan extends Model implements LoanContract
{
    use HasFactory, Uuid;
    protected $table = 'loans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'user_id',
        'amount',
        'term',
        'status',
        'frequency'
    ];

    public function scheduledPayments(): HasMany
    {
        return $this->hasMany(ScheduledPayment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
