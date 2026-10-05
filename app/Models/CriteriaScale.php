<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriteriaScale extends Model
{
    use HasFactory;

    protected $table = 'criteria_scales';

    protected $fillable = [
        'criteria_id',
        'label',
        'value',
        'description',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
