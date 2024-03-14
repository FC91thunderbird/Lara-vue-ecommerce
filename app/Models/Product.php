<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 'title', 'slug', 'category_id', 'subcategory_id', 'buy_price', 'price', 'description', 'colors', 'sizes', 'image', 'quantity'];

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array'
    ];

    function setTitleAttribute($title){
        $this->attributes['title'] = ucfirst($title);
        $this->attributes['slug'] = Str::slug(strtolower($title));
    }

    // function getColorsAttribute($colors){
    //     return $this->attributes['colors'] = array($colors);
    // }
    // function getSizesAttribute($sizes){
    //     return $this->attributes['sizes'] = array($sizes);
    // }

    function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    function subcategory(){
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }
}
