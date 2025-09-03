<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_image',
        'whatsapp',
        'instagram',
        'facebook',
        'business_name',
        'phone',
        'bio',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function products()
{
    return $this->hasMany(Product::class, 'marketer_id', 'user_id');
}

}

