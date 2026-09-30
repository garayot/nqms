<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessGroup extends Model
{
    protected $fillable = [
        'process_group_name',
        'url',
    ];

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class);
    }
}
