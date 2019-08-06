<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'start_date', 'end_date', 'n_of_participants'];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function criteria(){
        return $this->hasMany(Criteria::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'event_judges');
    }

    public function scopeJudges($query){
        return $this->users()->where('roles', 'judge');
    }
}
