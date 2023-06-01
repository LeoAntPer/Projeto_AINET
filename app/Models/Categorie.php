<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    use HasFactory;

    public function tshirt_images(): HasMany
    {
        return $this->hasMany(TshirtImage::class , 'category_id', 'id');
    }
}
