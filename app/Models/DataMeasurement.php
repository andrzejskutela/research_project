<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataMeasurement extends Model
{
    public $timestamps = false;
    protected $table = 'data_measurements';

    protected $guarded = [];


    public function dataLead() : BelongsTo {
        return $this->belongsTo(DataLead::class, 'data_lead_id', 'id');
    }

    protected function casts(): array {
        return [
            'time_breakdown' => 'array',
            'time_seconds' => 'decimal:2'
        ];
    }
}
