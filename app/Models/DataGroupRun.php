<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataGroupRun extends Model
{
    protected $table = 'data_group_runs';

    protected $guarded = [];

    public function participants() : HasMany {
        return $this->hasMany(DataLead::class, 'data_group_run_id', 'id');
    }
}
