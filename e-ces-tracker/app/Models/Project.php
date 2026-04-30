<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function events() {
        return $this->hasMany(Event::class);
    }
}
