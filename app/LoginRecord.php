<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginRecord extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'user_id', 'ip',
    ];

}
