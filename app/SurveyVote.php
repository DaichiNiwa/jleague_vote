<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyVote extends Model
{
    protected $fillable = [
        'survey_id', 'voted_to', 'ip', 'user_agent',
    ];
}
