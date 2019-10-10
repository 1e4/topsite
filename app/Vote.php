<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    public $fillable = [
        'listing_id',
        'vote_type',
        'voter_ip'
    ];

    const VOTE_IN = 1;

    const VOTE_OUT = 2;
}
