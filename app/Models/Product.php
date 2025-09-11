<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'marketer_id',
        'business_name',
        'image',

    ];

    public function marketer()
    {
        return $this->belongsTo(User::class, 'marketer_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Product.php
    public function marketerProfile()
    {
        return $this->hasOne(MarketerProfile::class, 'user_id', 'marketer_id');
    }
}
