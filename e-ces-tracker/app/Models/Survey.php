<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'description',
        'status',
        'department',
        'respondents_count',
        'satisfaction_score',
        'form_data',
        'created_by'
    ];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }
    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
