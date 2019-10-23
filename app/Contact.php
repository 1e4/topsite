<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    public function repliedBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'replied_by');
    }
}
