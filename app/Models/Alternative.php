<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternative extends Model
{
    use HasFactory;

    protected $table = 'alternatives';

    protected $fillable = [
        'code',
        'name',
        'brand',
        'spec_summary',
        'price_raw',
        'image_url',
        'order',
    ];

    protected $casts = [
        'price_raw' => 'float',
        'order' => 'integer',
    ];

    public function scores()
    {
        return $this->hasMany(AlternativeScore::class, 'alternative_id');
    }

    public function criterias()
    {
        return $this->belongsToMany(Criteria::class, 'alternative_scores', 'alternative_id', 'criteria_id')
            ->withPivot('score')
            ->withTimestamps();
    }

    public function getScoreForCriteria($criteriaId)
    {
        $score = $this->scores->firstWhere('criteria_id', $criteriaId);
        return $score ? (float)$score->score : 0.0;
    }
}
