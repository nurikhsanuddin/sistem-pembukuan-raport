<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predikat extends Model
{
    use HasFactory;
    //use predikat table


    protected $fillable = ['predikat', 'nilai'];
}
