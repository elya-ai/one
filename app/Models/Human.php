<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    public $timestamps = false;
    public $fillable = 
    [
    	'name', 'login', 'password',
    ];
}
