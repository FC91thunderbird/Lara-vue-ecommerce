<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug', 'perms'];

    protected $casts = [
        'perms' => 'arrray'
    ];

    function setNameAttribute($name) {
        $this->attributes['name'] = ucfirst($name);
        $this->attributes['slug'] = Str::slug(strtolower($name));
    }
}
