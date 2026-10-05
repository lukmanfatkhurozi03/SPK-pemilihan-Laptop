<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternativeScore extends Model
{
    use HasFactory;

    protected $table = 'alternative_scores';

    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'score',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class, 'alternative_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
