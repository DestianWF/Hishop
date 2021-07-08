<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sku',
        'name',
        'slug',
        'price',
        'weight',
        'description',
        'origin',
        'status',
    ];
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function categories(){
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }

    public static function statuses(){
        return[
            0 => 'draft',
            1 => 'active',
            2 => 'inactive',
        ];
    }
}
