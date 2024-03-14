<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [ 'firstname', 'lastname', 'country', 'city', 'state', 'address', 'address2', 'zip', 'phone'];
}
