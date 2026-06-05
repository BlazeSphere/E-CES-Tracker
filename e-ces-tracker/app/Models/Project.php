<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_name', 
        'description', 
        'category',
        'department',
        'status', 
        'start_date',
        'end_date',
        'budget', 
        'volunteers_count',
        'beneficiaries_count',
        'completion_percentage',
        'impact_score',
        'user_id',
        'adopted_community_id'
    ];

    public function adoptedCommunity(): BelongsTo
    {
        return $this->belongsTo(AdoptedCommunity::class);
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function surveys() {
        return $this->hasMany(Survey::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTitleAttribute()
    {
        return $this->project_name;
    }
}
