<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductsModel extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = ['id'];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset("storage/files/image/" . $value) : "",
        );
    }
}
