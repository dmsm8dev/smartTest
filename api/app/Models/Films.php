<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Films extends Model
{
    /** @use HasFactory<\Database\Factories\FilmsFactory> */
    use HasFactory;
    protected $guarded = [];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genres::class);
    }
}
