<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'api',
        'name',
        'created_by',
        'email',
        'phone',
        'address',
        'note'
    ];
}
