<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\HasIds;
use PHPUnit\Framework\Attributes\Ticket;

class Engineer extends Model
{

    use HasIds;

    protected $fillable = [
        'name',
        'email',
        'team',
        'products',
        'calendar_id'
    ];

    protected $casts = [
        'products' => 'array',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function holidays(): HasMany
    {
        return $this->hasMany(Holiday::class);
    }

    /**
     * Returns all tickets that are assigned to this engineer.
     *
     * The relation is determined by the assignee_id column in the tickets table.
     *
     * @return HasMany
     */
    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assignee_id');
    }

    public function temporaryTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'temporary_assignee_id');
    }
}
