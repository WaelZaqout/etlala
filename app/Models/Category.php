<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'image',
        'description',
    ];

    // القسم الأب
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // الأقسام الفرعية
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // المنتجات التابعة للقسم
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
