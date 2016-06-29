<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['width','height']; 

    public $timestamps = false;

    public function robots(){
        return $this->hasMany(Robot::class)->orderBy('id');
    }
}
