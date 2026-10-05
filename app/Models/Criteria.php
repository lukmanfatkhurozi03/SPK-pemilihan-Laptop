<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $table = 'criterias';

    protected $fillable = [
        'code',
        'name',
        'attribute',
        'weight',
        'unit',
        'description',
        'order',
    ];

    protected $casts = [
        'weight' => 'float',
        'order' => 'integer',
    ];

    public function scores()
    {
        return $this->hasMany(AlternativeScore::class, 'criteria_id');
    }

    public function scales()
    {
        return $this->hasMany(CriteriaScale::class, 'criteria_id')->orderBy('value', 'desc');
    }

    public function isBenefit(): bool
    {
        return strtolower($this->attribute) === 'benefit';
    }

    public function isCost(): bool
    {
        return strtolower($this->attribute) === 'cost';
    }
}
