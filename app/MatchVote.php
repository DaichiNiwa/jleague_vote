<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchVote extends Model
{
    protected $fillable = [
        'match_id', 'voted_to', 'ip', 'user_agent',
    ];
}
