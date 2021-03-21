<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordReset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
