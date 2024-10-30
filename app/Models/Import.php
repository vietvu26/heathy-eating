<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'category_id', 'quantity', 'unit_price', 'total_price'];

    // Liên kết với nhà cung cấp
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Liên kết với danh mục sản phẩm (categories)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

  
    public function calculateTotalPrice()
    {
        return $this->quantity * $this->unit_price;
    }
}

