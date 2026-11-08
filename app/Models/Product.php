<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price Price in pence.
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    protected function casts(): array
    {
        return ['price' => 'integer'];
    }
}
