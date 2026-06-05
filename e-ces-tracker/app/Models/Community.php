<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    public function events() {
        return $this->hasMany(Event::class);
    }

    public function projects() {
        return $this->hasManyThrough(Project::class, Event::class, 'community_id', 'id', 'id', 'project_id');
    }
}
