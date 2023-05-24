<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TshirtImage extends Model
{
    use HasFactory;
    protected function fullTshirtImageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->image_url ? asset('storage/tshirt_images/' . $this->image_url) :
                    asset('/img/avatar_unknown.png');
            },
        );
    }
}
