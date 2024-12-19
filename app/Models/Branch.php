<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function trainings():HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function vacants():HasMany
    {
        return $this->hasMany(Vacant::class);
    }
}
