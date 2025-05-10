<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\HasIds;

class Ticket extends Model
{
    use HasIds;

    protected $fillable = [
        'title',
        'description',
        'product',
        'assignee_id',
        'status',
        'temporary_assingnee_to'
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(Engineer::class, 'assignee_id');
    }

    public function temporaryAssignee(): BelongsTo
    {
        return $this->belongsTo(Engineer::class, 'temporary_assingnee_to');
    }
}
