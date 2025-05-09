<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\Attributes\Ticket;

class Engineer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'team'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function holidays(): HasMany
    {
        return $this->hasMany(Holiday::class);
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assignee_id');
    }

    /**
     * Temporary tickets assigned to this engineer.
     *
     * This is a tickets assigned to another engineer, but this engineer is
     * covering for them while they are on holiday.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function temporaryTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'temporary_assignee_id');
    }
}
