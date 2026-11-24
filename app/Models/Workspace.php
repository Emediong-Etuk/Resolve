<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name','description','logo','company_data', 'user_id'])]
class Workspace extends Model
{
    use HasUuids, SoftDeletes;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
