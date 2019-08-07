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

    public function scoreSummary(){
        $overall = 0;

        $judgesScoring = $this->scores->groupBy(function($item, $key){
            return $item->judge->name;
        })->all();
        $result = [];

        foreach($judgesScoring as $key => $scores){ /* Per Judge*/
            $result[$key]['sub_total'] = 0;
            foreach($scores as $scoreKey => $score){
                $computation = ($score->score / $score->criteria->max_points) * $score->criteria->percentage;

                $score->subTotal = $computation;

                $scoreSummary  = [
                    'tally' => $score->score,
                    'criteria_id' => $score->criteria->id,
                    'criteria_name' => $score->criteria->name,
                    'criteria_percentage' => $score->criteria->percentage,
                    'criteria_max_tally' => $score->criteria->max_points,
                    'computed_score' => $computation
                ];

                $result[$key]['sub_total'] += $computation;

                $result[$key]['tallies'][$scoreKey] = $scoreSummary;
            }
             $overall += $result[$key]['sub_total'];
        }

        $result['overall'] = $overall;

        return $result;
    }

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'participant_scores');
    }
}
