<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataLead extends Model
{
    protected $table = 'data_leads';

    public function measurements() : HasMany {
        return $this->hasMany(DataMeasurement::class, 'data_lead_id', 'id');
    }
}
