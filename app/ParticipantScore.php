<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipantScore extends Model
{
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    public function participant()
    {
        return $this->belongsTo(ParticipantScore::class);
    }
}
