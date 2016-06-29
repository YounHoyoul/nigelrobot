<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    protected $fillable = ['x','y','heading','commands']; 

    public $timestamps = false;

    protected $hidden = ["id","shop_id","shop"];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}
