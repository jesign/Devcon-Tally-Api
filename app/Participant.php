<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['event_id', 'name'];

    public function event(){
        return $this->belongsTo('event');
    }

    public function scores(){
        return $this->hasMany(ParticipantScore::class);
    }

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'participant_scores');
    }
}
