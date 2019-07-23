<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $table = 'criteria';

    protected $fillable = ['name', 'description', 'max_points', 'percentage'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
