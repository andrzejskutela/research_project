<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataMeasurement extends Model
{
    public $timestamps = false;
    protected $table = 'data_measurements';

    public function dataLead() : BelongsTo {
        return $this->belongsTo(DataLead::class, 'data_lead_id', 'id');
    }
}
