<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'surface',
        'rooms',
        'bedrooms',
        'floor',
        'price',
        'city',
        'address',
        'postal_code',
        'sold',
        'user_id'
    ];
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSlug(): string
    {
        return Str::slug($this->title);
    }
    public function getUser()
    {
        $user = User::find($this->user_id);
        return $user;
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
