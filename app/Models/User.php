<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role_id'];

    protected $hidden = ['password'];

    // Relation entre User et Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relation entre User et Category
    public function categories()
    {
        return $this->hasMany(Category::class, 'user_id');
    }
}
