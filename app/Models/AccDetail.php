<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'Bank','accType','accName','accNumber','user_id'
    ];
}
