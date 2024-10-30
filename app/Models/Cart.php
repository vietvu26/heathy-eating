<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'category_id',
        'quantity',
        'price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id'); // 'category_id' là khóa ngoại, 'id' là khóa chính trong bảng products
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
