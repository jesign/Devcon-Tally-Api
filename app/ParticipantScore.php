<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipantScore extends Model
{
    protected $fillable = [
        'criteria_id',
        'participant_id',
        'user_id',
        'score',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function judge()
    {
        return $this->hasMany(User::class);
    }
}
