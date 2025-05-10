<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\HasIds;

class Holiday extends Model
{

    use HasIds;

    protected $fillable = [
        'engineer_id',
        'start_date',
        'end_date',
        'status',
        'notes',
        'calendar_event_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the engineer that the holiday belongs to.
     *
     * @return BelongsTo
     */
    public function engineer(): BelongsTo
    {
        return $this->belongsTo(Engineer::class);
    }
}
