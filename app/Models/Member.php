<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'email',
        'name',
        'avatar',
        'password',
        'introduction',
        'phone',
        'authority',  
    ];
}
