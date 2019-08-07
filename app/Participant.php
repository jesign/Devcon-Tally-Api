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

    private function formatScore($score){
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

        return $scoreSummary;
    }

    public function scoreFromJudge($user){
        $judgeScores = $this->scores()->where('user_id', $user->id)->get();
        $subTotal = 0;
        $scores = [];
        foreach($judgeScores as $scoreKey => $score){

            $scoreSummary = $this->formatScore($score);

            $subTotal += $scoreSummary['computed_score'];
            $scores[] = $scoreSummary;
        }

        return compact('subTotal', 'scores');
    }

    public function scoreSummary(){
        $overall = 0;

        $judgesScoring = $this->scores->groupBy(function($item, $key){
            return $item->judge->name;
        })->all();
        $result = [];

        foreach($judgesScoring as $key => $scores){ /* Per Judge*/

            $subTotal = 0;
            foreach($scores as $scoreKey => $score){

                $scoreSummary = $this->formatScore($score);

                $subTotal += $scoreSummary['computed_score'];
                $result[$key]['tallies'][$scoreKey] = $scoreSummary;
            }

            $result[$key]['sub_total'] = $subTotal;

            $overall += $result[$key]['sub_total']; /* Overall total from all judges*/
        }

        $result['overall'] = $overall;

        return $result;
    }

    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'participant_scores');
    }
}
