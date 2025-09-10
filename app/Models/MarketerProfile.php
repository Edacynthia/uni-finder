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


// Marketers saving other marketers
public function favorites()
{
    return $this->belongsToMany(
        MarketerProfile::class,
        'favorites',
        'user_id', // who is saving
        'marketer_id'          // who is being saved
    )->withTimestamps();
}

public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites', 'marketer_id', 'user_id')
                ->withTimestamps();
}


}

