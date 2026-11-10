<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'description'])]
class Department extends Model
{
    // Bölüme degişli işgärleri alýar.
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
