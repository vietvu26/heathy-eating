<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'description',
        'calories',
        'price',
        'quantity',
        'image',
        'status'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
