<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataLead extends Model
{
    const LEG_CONTROL = 1;
    const LEG_INTERVENTION = 2;

    const ENTRY_SINGLE = 1;
    const ENTRY_GROUP = 2;

    protected $table = 'data_leads';

    protected $guarded = [];

    public function measurements() : HasMany {
        return $this->hasMany(DataMeasurement::class, 'data_lead_id', 'id');
    }

    protected function casts(): array {
        return [
            'ip_info ' => 'array',
        ];
    }
}
