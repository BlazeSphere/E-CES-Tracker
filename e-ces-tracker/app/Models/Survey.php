<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
