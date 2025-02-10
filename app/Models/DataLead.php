<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataLead extends Model
{
    const LEG_CONTROL = 1;
    const LEG_INTERVENTION = 2;

    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;
    const GENDER_NA = 3;

    const EXP_NONE = 1;
    const EXP_SOME = 2;
    const EXP_REGULAR = 3;

    protected $table = 'data_leads';

    protected $guarded = [];

    public function measurements() : HasMany {
        return $this->hasMany(DataMeasurement::class, 'data_lead_id', 'id');
    }

    public function group() : ?BelongsTo {
        return $this->belongsTo(DataGroupRun::class, 'data_group_run_id', 'id');
    }

    protected function casts(): array {
        return [
            'ip_info ' => 'array',
        ];
    }
}
