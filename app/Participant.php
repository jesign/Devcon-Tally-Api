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

    public function overAllScore(){
        $this->load('scores.criteria');

        $overall = 0;
        $result["scores"] = [];
        foreach($this->scores as $key => $score){
            $computation = ($score->score / $score->criteria->max_points) * $score->criteria->percentage;
            $score->subTotal = $computation;
            $overall += $computation;

            $result['scores'][$key] = $score;
        }
        $result['overall'] = $overall;

        return $result;
    }

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'participant_scores');
    }
}
