<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genres extends Model
{
    /** @use HasFactory<\Database\Factories\GenresFactory> */
    use HasFactory;
    protected $guarded = [];

    public function films(): BelongsToMany
    {
        return $this->belongsToMany(Films::class);
    }
}
